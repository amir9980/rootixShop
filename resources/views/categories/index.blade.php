@extends('layouts.master')

@section('title','دسته بندی ها')
@section('page title','دسته بندی ها')

@section('content')

    <div class="container">
        <div class="row">
            @foreach($categories as $cat)
                <div class="col-md-4 bg-light p-2 text-center">
                    <a class="btn btn-light" href="{{route('category.show',$cat->id)}}">
                    {{$cat->title}}
                    </a>
                </div>
            @endforeach
        </div>
    </div>

@endsection
