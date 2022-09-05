@extends('frontend.main_master')
@section('index')

@section('title')
the Hexaa
@endsection



@foreach ($products as $product)

<img src="{{ asset($product->product_thumbnail) }}" alt="" style="width: 200px; height:200px">

@endforeach

@endsection
