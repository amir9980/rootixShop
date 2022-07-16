@extends('layouts.master')

@section('title','Create Product')

@section('content')


    <div class="card card-success col-md-12">
        <div class="card-header">
            <h3 class="card-title">ایجاد محصول</h3>
        </div>
        <!-- /.card-header -->


        <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
            <div class="card-body">

                @csrf

                <div class="form-group">
                    <label for="title">عنوان</label>
                    <input type="text" class="form-control" name="title" required>
                </div>

                <!-- textarea -->
                <div class="form-group">
                    <label for="description">توضیحات</label>
                    <textarea class="form-control" id="body" rows="3" name="description" placeholder="توضیحات محصول را وارد کنبد"
                              ></textarea>
                </div>


                <div class="row align-items-center flex-start">
                    <div class="form-group col-md-12 col-lg-4">
                        <label for="price">قیمت محصول</label>
                        <input class="form-control numberInput" type="text" name="price" required placeholder="تومان">
                    </div>
                    <div class="col-lg-2">
                    <button class="btn btn-sm btn-info " type="button" data-toggle="collapse" data-target="#offPriceDiv">اضافه کردن قیمت تخفیف خورده</button>
                    </div>
                    <div id="offPriceDiv" class="collapse form-group col-md-12 col-lg-3 mr-lg-3 my-xs-3 my-lg-0">
                        <label for="off_price">قیمت تخفیف خورده</label>
                        <input class="form-control numberInput" type="text" name="off_price" placeholder="تومان">
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="form-group col-md-4 d-flex h-100 imgInputs">
                            <label for="img">تصاویر</label>

                            <input id="productImagesInput" type="file" hidden
                                   name="images[]" onchange="appendImage(this)">
                            <div class="form-control row d-flex mr-3" id="productImagesSelect"
                                 onclick="document.getElementById('productImagesInput').click()">
                            </div>
                        </div>

                    </div>


                </div>


                <!-- /.card-body -->
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">ایجاد محصول</button>
            </div>


        </form>


    </div>

@endsection





@section('script')

    <script src="{{asset('ckeditor5/ckeditor.js')}}"></script>

    <script>

        ClassicEditor
            .create( document.querySelector( '#body' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

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
