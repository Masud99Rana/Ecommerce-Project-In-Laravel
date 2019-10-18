@extends('frontend.layouts.master')

@section('main')
    <div class="container">
        <div class="container">
            @if (session()->has('message'))
                <div class="alert alert-success mt-2">
                    {{ session('message') }}
                </div>
            @endif
            <br>
            <p class="text-center">Order Details</p>
            <hr>
        </div>

        <div class="container">
            <ul class="list-group">
                @foreach($order->toArray() as $column => $value)
                    @if(is_string($value))
                        @if($column === 'user_id')
                            @continue
                        @endif
                        <li class="list-group-item">
                            {{ ucwords(str_replace('_', ' ', $column)) }}: {{ $value }}
                        </li>
                    @endif
                @endforeach
            </ul>

            <h3>Ordered Products</h3>

            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <td>Product Title</td>
                    <td>Quantity</td>
                    <td>Total Price</td>
                </tr>
                </thead>
                @foreach ($order->products as $product)
                    <tr>
                        <td>{{ $product->product->title }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>BDT {{ number_format($product->price,2) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@stop
