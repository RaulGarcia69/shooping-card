@extends('layout')
@section('title', 'Products')
@section('content')
    <div class="container products">
        <div class="row">
            @foreach($products as $product)
                <div class="col-xs-18 col-sm-6 col-md-3 padding">
                    <div class="thumbnail">
                        <img src="{{ $product->photo }}" width="500" height="300">
                        <div class="caption">
                            <h4>{{ str_limit($product->name, 18, '') }}</h4>
                            <p class="text-secondary">{{ str_limit(strtolower($product->description), 50) }}</p>
                            <p class="float-left"><strong>Price: </strong> {{ $product->price }}</p><p class="text-success"><strong>&nbsp;$</strong> </p>
                            <p class="btn-holder"><a href="{{ url('add-to-cart/'.$product->id) }}" class="btn btn-warning btn-block text-center scale" role="button">Add to cart</a> </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection