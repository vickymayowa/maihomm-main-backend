<?php

namespace App\Services\Shop;

use App\Models\CartItem;
use App\Models\Property;

class CartItemService
{

    public static function saveToCart($cart_id, $property_id)
    {
        $property = Property::find($property_id);
        $quantity = $data["quantity"] ?? 1;
        $data["price"] = $property->price  * $quantity;
        $data["total"] =  ($data["price"]);
        $data["quantity"] = $quantity;

        $cart_item = CartItem::updateOrCreate([
            "cart_id" => $cart_id,
            "property_id" => $property_id
        ], $data);
        $cart = CartService::getById($cart_id);
        $cart->update([
            "total" => $cart->total + $cart_item->total,
            "items" => $cart->quantity + $cart_item->quantity,
        ]);
    }

    public static function oldsaveToCart($cart_id, $property_id)
    {
        $property = Property::find($property_id);
        $quantity = $data["quantity"] ?? 1;
        // $data["price"] = $property->price  * $quantity;
        $data["price"] = $property->per_slot  * $quantity;
        $data["fees"] = ($property->maihomm_fee / 40)  * $quantity;
        $data["taxes"] = ($property->legal_and_closing_cost / 40)  * $quantity;
        $data["total"] =  ($data["price"] + $data["fees"] + $data["taxes"]);
        $data["quantity"] = $quantity;

        CartItem::updateOrCreate([
            "cart_id" => $cart_id,
            "property_id" => $property_id
        ], $data);
        return CartService::refreshCart($cart_id);
    }

    public static function updateCart($cart_id, $property_id, $quantity = 1)
    {
        $property = Property::find($property_id);
        // $data["price"] = $property->price  * $quantity;
        $data["price"] = $property->per_slot  * $quantity;
        $data["fees"] = ($property->maihomm_fee / 40)  * $quantity;
        $data["taxes"] = ($property->legal_and_closing_cost / 40)  * $quantity;
        $data["total"] =  ($data["price"] + $data["fees"] + $data["taxes"]);
        $data["quantity"] = $quantity;

        CartItem::updateOrCreate([
            "cart_id" => $cart_id,
            "property_id" => $property_id
        ], $data);
        return CartService::refreshCart($cart_id);
    }



    public static function inCart($user_id, $property_id)
    {
        return CartItem::whereHas("cart", function ($query) use ($user_id) {
            $query->where("user_id", $user_id);
        })->where("property_id", $property_id)->first();
    }

    public static function removeFromCart($cart_id, $property_id)
    {
        CartItem::where([
            "cart_id" => $cart_id,
            "property_id" => $property_id
        ])->delete();
        return CartService::refreshCart($cart_id);
    }

    public static function getCartItems($cart_id)
    {
        $items = CartItem::with(["property", "property.defaultImage"])
            ->whereHas("property")
            ->where("cart_id", $cart_id);
        return $items;
    }
}
