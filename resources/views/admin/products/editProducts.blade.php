@extends('layouts.master')

@section('title','Show Product')

@section('content')

    <div class="card card-success col-md-12">
        <div class="card-header">
            <h3 class="card-title">ویرایش محصول "{{$product->title}}"</h3>
        </div>
        <!-- /.card-header -->


        <form action="{{route('product.update',$product)}}" method="post" enctype="multipart/form-data">
            <div class="card-body">

                @csrf

                <div class="form-group">
                    <label for="title">عنوان</label>
                    <input type="text" class="form-control" name="title" value="{{$product->title}}">
                </div>

                <!-- textarea -->
                <div class="form-group">
                    <label for="description">توضیحات</label>
                    <textarea class="form-control" rows="3" name="description">{{$product->description}}</textarea>
                </div>


                <div class="row">
                    <div class="form-group col-md-12 col-lg-6">
                        <label for="price">قیمت محصول</label>
                        <input class="form-control numberInput" type="text" name="price" value="{{$product->price}}">
                    </div>
                    <div class="form-group col-md-12 col-lg-6">
                        <label for="off_price">قیمت تخفیف خورده</label>
                        <input class="form-control numberInput" type="text" name="off_price"
                               value="{{$product->off_price}}">
                    </div>
                </div>


                <!-- select -->
                <div class="form-group">
                    <label for="status">وضعیت</label>
                    <select class="form-control" name="status">
                        <option value="Active" @if($product->status=='Active')selected @endif>فعال</option>
                        <option value="Inactive" @if($product->status=='Inactive')selected @endif>غیرفعال</option>
                        <option value="Deleted" @if($product->status=='Deleted')selected @endif>حذف شده</option>
                    </select>
                </div>
                <div class="row">
                    <div class="form-group col-md-4 d-flex h-100 imgInputs">
                        <label for="img">تصاویر</label>

                                <input id="productImagesInput" type="file" hidden
                                       name="images[]" onchange="appendImage(this)">
                                <div class="form-control row d-flex mr-3" id="productImagesSelect"
                                     onclick="document.getElementById('productImagesInput').click()">
                                </div>
                    </div>
                    <div class="form-group col-md-8">
                        <label> تصویر شاخص:</label>
                        <div class="row">
                            @foreach($product->images as $image)
                                <div class="col-md-3 col-sm-4 d-flex flex-column">
                                    {{--<label >حذف تصویر:</label>--}}
                                    <input type="radio" name="thumb"
                                           value="{{$image->path}}" {{$product->thumbnail == $image->path ? 'checked':''}}>
                                    <img src="{{route('images.product',$image->path)}}" alt="alt" width="100%">
                                    {{--<button class="btn btn-sm btn-danger" type="button" value="{{$image}}" onclick="sendDeleteImgRequest(this)">حذف</button>--}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                <!-- /.card-body -->
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">ویرایش محصول</button>
            </div>


        </form>


    </div>


@endsection

@section('script')

    <script>


                function appendImage(input) {
                    let currentFile = input.files[0];
                    input.removeAttribute('id');
                    input.removeAttribute('onchange');
                    let url = window.URL.createObjectURL(currentFile);
                    let img = new Image(120, 120);
                    img.src = url;

                    let imgInput = document.createElement("input");
                    imgInput.name = "images[]";
                    imgInput.setAttribute('type', 'file');
                    imgInput.setAttribute('onchange', 'appendImage(this)');
                    imgInput.setAttribute('hidden', true);
                    imgInput.setAttribute('id', "productImagesInput");

                    let span = document.createElement("span");
                    span.textContent = "حذف";
                    span.classList.add("position-absolute");
                    span.classList.add("text-danger");
                    span.setAttribute('onclick', 'deleteImage(this,event)');


                    let div = document.createElement("div");
                    div.classList.add("col-md-6");
                    div.classList.add("position-relative");
                    div.appendChild(input);
                    div.appendChild(img);
                    div.appendChild(span);

                    $(".imgInputs").prepend(imgInput);
                    $("#productImagesSelect").prepend(div);

                    // console.log(img);
                }

                function deleteImage(span,event){
                    event.stopPropagation();
                    span.closest("div").remove();
                }

    </script>

@endsection
