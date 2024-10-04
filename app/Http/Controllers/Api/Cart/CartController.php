<?php

namespace App\Http\Controllers\Api\Cart;

use App\Constants\ApiConstants;
use App\Exceptions\Property\PropertyException;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartItemResource;
use App\Services\Shop\CartItemService;
use App\Services\Shop\CartService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CartController extends Controller
{
    public function inCart()
    {
        try {
            $cart = CartService::getCartByUser(auth()->id());
            CartService::refreshCart($cart->id);
            $cartItems = CartItemService::getCartItems($cart->id)
                ->latest()
                ->get();
            return ApiHelper::validResponse("Cart items retrieved successfully", CartItemResource::collection($cartItems));
        } catch (Exception $e) {
            return ApiHelper::problemResponse("An error occured while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function removeFromCart($property_id)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $cart = CartService::getCartByUser($user->id);
            CartItemService::removeFromCart($cart->id, $property_id);
            DB::commit();
            return ApiHelper::validResponse("Item removed from cart successfully!");
        } catch (Exception $e) {
            DB::rollBack();
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function addToCart($property_id)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();

            // if(CartService::hasCart($user->id)){
            //     return ApiHelper::problemResponse("Cart is not empty", ApiConstants::SERVER_ERR_CODE, null);
            // }

            $cart = CartService::getCartByUser($user->id);
            CartItemService::saveToCart($cart->id, $property_id);
            DB::commit();
            return ApiHelper::validResponse("Item added to cart successfully!");
        } catch (Exception $e) {
            DB::rollBack();
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function updateCart($property_id, $quantity){
        DB::beginTransaction();
        try {
            $user = auth()->user();

            $cart = CartService::getCartByUser($user->id);
            CartItemService::updateCart($cart->id, $property_id, $quantity);
            DB::commit();
            return ApiHelper::validResponse("Cart updated successfully!");
        } catch (Exception $e) {
            DB::rollBack();
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        } 
    }

    public function summary()
    {
        try {
            $cart = CartService::getCartByUser(auth()->id());
            $data = CartService::summary($cart);
            return ApiHelper::validResponse("Summary retrieved successfully", $data);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("An error occured while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }
    public function checkOut(Request $request)
    {
        try {
            $user = auth()->user();
            CartService::checkOut($user , $request->all());
            return ApiHelper::validResponse("Checkout successful");
        } catch (PropertyException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null,  $e);
        } catch (Throwable $e) {
            return ApiHelper::problemResponse("An error occured while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }
}
