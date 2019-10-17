@extends('frontend.layouts.master')

@section('main')
    <div class="container">
        <br>
        <p class="text-center">Cart</p>
        <hr>

        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
    @if (!count($cart))
        <div class="alert alert-info" >
            Please add some products to your cart.
        </div>
    @else

        <table class="table table-bordered">
            <thead>
            <tr>
                <td>Serial</td>
                <td>Product</td>
                <td>Unit Price</td>
                <td>Quantity</td>
                <td>Price</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>

        @php $i=1; @endphp

        @foreach ($cart as $key => $product)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $product['title'] }}</td>
                <td>BDT {{ number_format($product['unit_price'],0)}}</td>
                <td><input type="number" name="quantity" value="{{ $product['quantity'] }}"></td>
                <td>BDT {{ number_format($product['total_price'],0) }}</td>
                <td>
                    <form action="{{ route('cart.remove') }}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $key }}">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Remove</button>
                    </form>
                </td>
            </tr>
        @endforeach

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>Total</td>
                <td>BDT {{ number_format($total,0) }}</td>
                <td></td>
            </tr>
            </tbody>
        </table>

        <a href="{{ route('cart.clear') }}" class="btn btn-danger">Clear Cart</a>
        <a href="{{ route('checkout') }}" class="btn btn-success">Checkout</a>
    @endif

    </div>
@stop
