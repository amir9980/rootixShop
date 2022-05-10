@extends('layouts.master')

@section('title', 'online shop')

@section('content')

    @if($product)
        <div class="col-lg-12">
            <h2>{{$product->title}}</h2>
            <a href="{{route('product.show',$product)}}">
                <img class="img-responsive" src="{{route('images',$product->img_src)}}" alt="{{$product->title}}">
            </a>
            <p>{{$product->description}}</p>
            @auth
                <form action="{{route('cart.store',$product->id)}}" method="post">
                    @csrf
                    <input class="btn btn-success mb-2" type="submit" name="addToCart" value="add to cart">
                </form>

            @endauth
        </div>
    @endif


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
