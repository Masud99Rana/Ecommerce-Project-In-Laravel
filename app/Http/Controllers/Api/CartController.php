<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Product;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function addToCart()
    {
        try {
            $this->validate(request(), [
                'product_id' => 'required|numeric',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data validation failed',
                'errors' => 'Product ID is invalid',
            ]);
        }

        $product = Product::findOrFail(request()->input('product_id'));
        $unit_price = ($product->sale_price !== null && $product->sale_price > 0) ? $product->sale_price : $product->price;
        $cart = session()->has('cart') ? session()->get('cart') : [];

        if (array_key_exists($product->id, $cart)) {
            $cart[$product->id]['quantity']++;
            $cart[$product->id]['total_price'] = $cart[$product->id]['quantity'] * $cart[$product->id]['unit_price'];
        } else {
            $cart[$product->id] = [
                'title' => $product->title,
                'quantity' => 1,
                'unit_price' => $unit_price,
                'total_price' => $unit_price,
            ];
        }

        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'data' => [],
        ]);
    }

    public function removeFromCart()
    {
        try {
            $this->validate(request(), [
                'product_id' => 'required|numeric',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data validation failed',
                'errors' => 'Product ID is invalid',
            ]);
        }

        $cart = session()->has('cart') ? session()->get('cart') : [];
        unset($cart[request()->input('product_id')]);
        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'message' => 'Product removed from your cart.',
            'data' => [],
        ]);
    }

    public function getCart()
    {
        $data = [];
        $data['cart'] = session()->has('cart') ? session()->get('cart') : [];
        $data['total'] = array_sum(array_column($data['cart'], 'total_price'));

        return response()->json([
            'success' => true,
            'message' => '',
            'data' => $data,
        ]);
    }

    public function clearCart()
    {
        session(['cart' => []]);

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared.',
            'data' => [],
        ]);
    }
}
