@extends('frontend.layouts.master')

@section('main')
    <div class="container">
        <br>
        <p class="text-center">Register</p>
        <hr>

        @include('frontend.partials._message')

        <form action="{{ route('register') }}" class="form" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="form-control">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="form-control">
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" value="{{ old('phone_number') }}" required class="form-control">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" required class="form-control">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-block btn-success">
                    Register
                </button>
            </div>
        </form>
    </div>
@stop
