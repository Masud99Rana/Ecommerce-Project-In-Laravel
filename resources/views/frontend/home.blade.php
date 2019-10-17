@extends('frontend.layouts.master')

@section('main')
    @include('frontend.partials._hero')

    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row">
                
            </div>

            {{ $products->render() }}

        </div>
    </div>
@stop
