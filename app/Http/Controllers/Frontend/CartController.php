<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function showCart()
    {	
    	// session()->flush();
    	
    	$data = [];
    	$data['total'] = 0;
    	$data['cart'] = session()->has('cart') ? session()->get('cart') : [];
    	$data['total'] = array_sum(array_column($data['cart'], 'total_price'));

        return view('frontend.cart',$data);
    }

    public function addToCart(Request $request)
    {	
        try {
            $this->validate($request, [
                'product_id' => 'required|numeric',
            ]);
        } catch (ValidationException $e) {
            return redirect()->back();
        }

        $product = Product::findOrFail($request->input('product_id'));
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
        session()->flash('message', $product->title.' added to cart.');


        return redirect()->route('cart.show');
    }

    public function removeFromCart(Request $request)
    {
        try {
            $this->validate($request, [
                'product_id' => 'required|numeric',
            ]);
        } catch (ValidationException $e) {
            return redirect()->back();
        }

        $cart = session()->has('cart') ? session()->get('cart') : [];
        unset($cart[$request->input('product_id')]);
        
        session(['cart' => $cart]);
        session()->flash('message', 'Product removed from your cart.');

        return redirect()->back();
    }

    public function clearCart()
    {
        session(['cart' => []]);

        return redirect()->back();
    }

    public function checkout()
    {
        $data = [];
        $data['cart'] = session()->has('cart') ? session()->get('cart') : [];
        $data['total'] = array_sum(array_column($data['cart'], 'total_price'));

        return view('frontend.checkout', $data);
    }

    public function processOrder()
    {
        $validator = Validator::make(request()->all(), [
            'customer_name' => 'required',
            'customer_phone_number' => 'required|min:11',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $cart = session()->has('cart') ? session()->get('cart') : [];
        $total = array_sum(array_column($cart, 'total_price'));

        $order = Order::create([
            'user_id' => auth()->user()->id,
            'customer_name' => request()->input('customer_name'),
            'customer_phone_number' => request()->input('customer_phone_number'),
            'address' => request()->input('address'),
            'city' => request()->input('city'),
            'postal_code' => request()->input('postal_code'),
            'total_amount' => $total,
            'paid_amount' => $total,
            'payment_details' => 'cash on delivery',
        ]);

        foreach ($cart as $product_id => $product) {
            $order->products()->create([
                'product_id' => $product_id,
                'quantity' => $product['quantity'],
                'price' => $product['total_price'],
            ]);
        }

        // auth()->user()->notify(new OrderEmailNotification($order, auth()->user()->name));

        session()->forget(['total', 'cart']);
        session()->flash('message', 'Order placed successfully.');

        return redirect()->route('order.details', $order->id);
    }

    public function showOrder($id)
    {
        $data = [];
        $data['order'] = Order::with(['products', 'products.product'])->findOrFail($id);

        return view('frontend.orders.details', $data);
    }
}
