@extends('layouts.master')

@section('title', 'online shop')

@section('content')

    @foreach($products as $product)
    <div class="col-lg-4">
        <h4>{{$product->title}}</h4>
        <a href="{{route('product.show',$product)}}">
                <img class=" img-thumbnail" src="{{asset('uploads/images/products/'.$product->img_src)}}" alt="{{$product->title}}">
            </a>
        <p>{{$product->description}}</p>
        <ul>
            <li style="text-decoration: line-through">{{$product->old_price}}</li>
            <li>{{$product->price}}</li>
        </ul>
        @auth
            <form action="{{route('cart.store',$product->id)}}" method="post">
                @csrf
                <input class="btn btn-success mb-2" type="submit" name="addToCart" value="add to cart">
            </form>

        @endauth
        <a href="{{route('product.show',$product)}}" class="btn btn-primary">read more</a>
    </div>
    @endforeach


    <!-- Pager -->
    <ul class="pager col-lg-12">
        <li class="previous">
            <a href="#">&larr; Older</a>
        </li>
        <li class="next">
            <a href="#">Newer &rarr;</a>
        </li>
    </ul>


    @endsection
