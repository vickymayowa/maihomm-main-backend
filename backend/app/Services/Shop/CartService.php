<?php

namespace App\Services\Shop;

use App\Constants\StatusConstants;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\property;
use App\Models\User;
use App\Services\Finance\PropertyPaymentService;
use App\Services\Finance\Wallet\WalletService;
use Illuminate\Support\Facades\DB;

class CartService
{

    public static function hasCart($user_id) : bool {
        $cart = Cart::where('user_id', $user_id)->first();

        if(!$cart) return false;

        $cart_item = CartItem::where('cart_id', $cart->id)->first();

        return $cart_item ? true : false;
    }

    public static function getCartByUser($user_id): Cart
    {
        return Cart::firstOrCreate(["user_id" => $user_id], [
            "reference" => self::generateReferenceNo(),
            "price" => 0,
            "taxes" => 0,
            "fees" => 0,
            "total" => 0,
            "items" => 0,
        ]);
    }

    public static function generateReferenceNo()
    {
        $key = "RF_" . getRandomToken(8, true);
        $check = Cart::where("reference", $key)->count();
        if ($check > 0) {
            return self::generateReferenceNo();
        }
        return $key;
    }

    public static function addToCart($user_id, $property_id, array $data)
    {

        DB::beginTransaction();
        $cart = self::getCartByUser($user_id);
        CartItemService::saveToCart($cart->id, $property_id, $data);

        $cart = self::refreshCart($cart->id);
        DB::commit();
        return $cart;
    }

    public static function removeFromCart($user_id, $property_id)
    {
        DB::beginTransaction();

        $cart = self::getCartByUser($user_id);
        CartItemService::removeFromCart($cart->id, $property_id);
        $cart = self::refreshCart($cart->id);

        DB::commit();
        return $cart;
    }

    public static function refreshCart($cart_id)
    {
        $cart = self::getById($cart_id);

        CartItem::where("cart_id", $cart->id)->whereHas("property", function ($property) {
            $property->where("status", StatusConstants::INACTIVE);
        })->delete();

        CartItem::whereDoesntHave("property")->delete();

        $sums = CartItem::where("cart_id", $cart->id)
            ->whereHas("property")
            ->select(
                DB::raw("SUM(quantity) as quantity"),
                DB::raw("SUM(price) as total_price"),
                DB::raw("SUM(fees) as total_fees"),
                DB::raw("SUM(taxes) as total_taxes"),
                DB::raw("SUM(total) as total"),
            )->first()->toArray();

        $data = [
            "items" => $sums["count"] ?? 0,
            "price" => $sums["total_price"] ?? 0,
            "fees" => $sums["total_fees"] ?? 0,
            "taxes" => $sums["total_taxes"] ?? 0,
            "total" => $sums["total"] ?? 0
        ];

        $cart->update($data);
        return $cart->refresh();
    }

    public static function getById($cart_id): Cart
    {
        return Cart::find($cart_id);
    }

    public static function summary(Cart $cart)
    {
        $data = [
            "sub_total" => (double) $cart->price,
            "fees" => (double) $cart->fees,
            "taxes" => (double) $cart->taxes,
            "total" => (double) $cart->total
        ];

        return $data;
    }

    public static function checkOut(User $user, array $data)
    {
        
        $cart = self::getCartByUser($user->id);
        $cartItems = CartItemService::getCartItems($cart->id)->get();

        $properties = [];
        $currency_id = null;

        foreach ($cartItems as $item) {
            $properties[] = [
                "id" => $item->property_id,
                "slots" => $item->quantity,
            ];
            $currency_id = $item->property->currency_id;
        }
        
        PropertyPaymentService::saveMultiple([
            "user_id" => $user->id,
            "properties" => $properties,
            "files" => $data["files"] ?? [],
            "currency_id" => $currency_id,
            "amount" => $cart->total,
        ]);
        
        CartItem::where('cart_id', $cart->id)->delete();
        Cart::find($cart->id)->delete();
        
    }
}
