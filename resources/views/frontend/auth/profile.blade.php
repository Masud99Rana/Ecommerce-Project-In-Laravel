@extends('frontend.layouts.master')

@section('main')
    <div class="container">
        <br>
        <p class="text-center">My Profile</p>
        <hr>
    </div>

    <div class="container">
        <h3>My Orders</h3>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <td>Order ID</td>
                <td>Customer Name</td>
                <td>Customer Phone Number</td>
                <td>Total Amount</td>
                <td>Paid Amount</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->customer_phone_number }}</td>
                    <td>{{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ number_format($order->paid_amount, 2) }}</td>
                    <td>
                        <a href="{{ route('order.details', $order->id) }}">
                            Details
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
