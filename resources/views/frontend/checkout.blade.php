@extends('frontend.layouts.master')

@section('main')
    <div class="container">
        <br>
        <p class="text-center">Checkout</p>
        <hr>

        @guest()
            <div class="alert alert-info">
                You need to <a href="{{ route('login') }}">Login</a> first to complete your order.
            </div>
        @else
            <div class="alert alert-info">
                You are ordering as, {{ auth()->user()->name }}
            </div>
        @endguest
    </div>

    @auth()
        <div class="container">

            <div class="row">
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Your cart</span>
                        <span class="badge badge-secondary badge-pill">{{ count($cart) }}</span>
                    </h4>

                    <ul class="list-group mb-3">
                        @foreach($cart as $key => $product)
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">{{ $product['title'] }}</h6>
                                    <small class="text-muted">Quantity: {{ $product['quantity'] }}</small>
                                </div>
                                <span class="text-muted">{{ number_format($product['total_price'], 2) }}</span>
                            </li>
                        @endforeach

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (BDT)</span>
                            <strong>{{ number_format($total, 2) }}</strong>
                        </li>
                    </ul>
                </div>

                <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">Billing address</h4>

                    @include('frontend.partials._message')

                    <form action="{{ route('order') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name">Customer Name</label>
                            <input type="text" class="form-control" name="customer_name" value="{{ auth()->user()->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone_number">Customer Phone Number</label>
                            <input type="text" class="form-control" name="customer_phone_number" value="{{ auth()->user()->phone_number }}">
                        </div>

                        <div class="mb-3">
                            <label for="address">Address</label>
                            <textarea class="form-control" name="address" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="city">City</label>
                                <input class="form-control" type="text" name="city" placeholder="City" required>
                            </div>

                            <div class="col-md-5 mb-3">
                                <label for="postal_code">Postal Code</label>
                                <input class="form-control" type="text" name="postal_code" placeholder="Postal Code" required>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
                    </form>
                </div>
            </div>
        </div>
    @endauth
@stop
