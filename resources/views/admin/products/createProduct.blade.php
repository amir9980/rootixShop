@extends('admin.layouts.master')

@section('title','Create Product')

@section('content')

<div class="d-flex col-lg-3">


    <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">title:</label>
            <input type="text" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">description:</label>
            <textarea name="description" cols="30" rows="10"></textarea>
        </div>
        <div class="form-group">
            <label for="price">price:</label>
            <input type="number" name="price" required>
        </div>
        <div class="form-group">
            <label for="old_price">old price:</label>
            <input type="number" name="old_price">
        </div>
        <div class="form-group">
            <label for="img">picture:</label>
            <input type="file" name="img">
        </div>
        <input type="submit" name="submit" value="store" class="btn btn-success">
    </form>
</div>

    @endsection