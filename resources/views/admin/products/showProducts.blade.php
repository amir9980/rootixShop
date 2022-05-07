@extends('admin.layouts.master')

@section('title','Show Product')

@section('content')

    @foreach($products as $product)
        <div class="col-lg-4">
            <h4>{{$product->title}}</h4>
            <a href="{{route('product.show',$product)}}">
                <img class=" img-thumbnail" src="{{asset('uploads/images/products/'.$product->img_src)}}" alt="{{$product->title}}">
            </a>
            <p>{{$product->description}}</p>

            <a href="{{route('product.edit',$product->id)}}" class="btn btn-primary">Edit</a>
            <form action="{{route('product.destroy',$product)}}" method="POST">
                @csrf
                <input class="btn btn-danger mb-2" type="submit" name="delete" value="Delete">
            </form>
        </div>
    @endforeach

@endsection