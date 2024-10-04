<?php

namespace App\Http\Controllers\Web\Shop;

use App\Constants\ApiConstants;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Services\Shop\CartItemService;
use App\Services\Shop\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{

    public function index()
    {
        return view();
    }

    public function save(Request $request, $id)
    {
        try {
            if (auth()->check()) {
                $request["quantity"] = $request->quantity ?? 1;
                $validator = Validator::make($request->all(), [
                    "quantity" => "required",
                    "color" => "nullable|string",
                    "size" => "nullable|string",
                ]);
                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }

                $data = $validator->validated();
                $user = auth()->user();
                $in_cart = CartItemService::inCart($user->id, $id);

                if (!empty($in_cart)) {
                    $cart = CartService::removeFromCart($user->id, $id);
                } else {
                    $cart = CartService::addToCart($user->id, $id, $data);
                }
            }

            $in_cart = !empty(CartItemService::inCart($user->id, $id));

            DB::commit();
            return ApiHelper::validResponse("Cart saved successfully", [
                "property_id" => $id,
                "in_cart" => $in_cart,
                "display_text" => $in_cart ? "Added to Cart" : "Removed from Cart",
                "btn_text" => $in_cart ? "Remove from Cart" : "Add to Cart",
                "items_count" => $cart->cartItems->count()
            ]);
        } catch (ValidationException $e) {
            $message = "The given data was invalid.";
            return ApiHelper::inputErrorResponse($message, ApiConstants::VALIDATION_ERR_CODE, $request, $e);
        } catch (\Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::SERVER_ERR_CODE, $request, $e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if (auth()->check()) {
                $validator = Validator::make($request->all(), [
                    "quantity" => "nullable|required",
                    "color" => "nullable|string",
                    "size" => "nullable|string",
                ]);
                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }

                $data = $validator->validated();

                $user = auth()->user();

                $in_cart = CartItemService::inCart($user->id, $id);
                if (!empty($in_cart)) {
                    $cart = CartService::addToCart($user->id, $id, $data);
                }

                $in_cart->refresh();

                return ApiHelper::validResponse("Cart updated successfully", [
                    "cart" => $cart,
                    "cartItem" => [
                        "property_id" => $id,
                        "discount" => $in_cart->discount,
                        "unit_price" => $in_cart->getPrice(),
                        "quantity" => $in_cart->quantity,
                        "sub_total" => format_money($in_cart->getSubtotal()),
                    ]
                ]);
            }
        } catch (ValidationException $e) {
            $message = "The given data was invalid.";
            return ApiHelper::inputErrorResponse($message, ApiConstants::VALIDATION_ERR_CODE, $request, $e);
        } catch (\Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::SERVER_ERR_CODE, $request, $e);
        }
    }

    public function deleteCartItem(Request $request, $id)
    {
        $cartItem = CartItemService::inCart(auth()->id(), $id);
        if (!empty($cartItem)) {
            CartItemService::removeFromCart($cartItem->cart_id, $cartItem->property_id);
            CartService::refreshCart($cartItem->cart_id);
            return ApiHelper::validResponse("Cart updated successfully", [
                "msg" => "Item removed from cart successfully"
            ]);
        }
    }
}
