@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    <div class="container">
                        <div class="row align-items-center">
                            @foreach($products as $product)
                            <div class="card col-auto justify-content-center" style="width: 18rem;">
                                <img src="{{ asset('storage/images/'.$product->photo) }}" class= "card-img-top" alt="...">
                                <div class="card-body  ">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">$<span id="price">{{ $product->price  }}</span></p>
                                    <a href="{{ route('getCheckoutId',$product->price) }}" class="btn btn-primary">BUY NOW</a>
                                </div>
                            </div>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
