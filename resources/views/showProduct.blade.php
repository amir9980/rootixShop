@extends('layouts.master')

@section('title', 'مشاهده محصول')
@section('page title', 'مشاهده محصول')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card col-12 text-center">
                <div class="card-header ">
                    <h5>{{$product->title}}</h5>


                    <div id="carouselExampleIndicators" class="carousel slide w-50 mx-auto" data-ride="carousel"
                         style="height: 100%">
                        <ol class="carousel-indicators">
                            @foreach($product->images as $image)
                                <li data-target="#carouselExampleIndicators"
                                    data-slide-to="{{$loop->index}}" {{$loop->index==0?'active':''}}></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach($product->images as $image)
                                <div class="carousel-item justify-content-center {{$loop->index==0?'active':''}}">
                                    <img class="d-block w-100" src="{{route('images.product',$image->path)}}" alt=" slide">
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                           data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                           data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>


                <div class="card-body">
                    <p>&nbsp;{{number_format($product->price)}}&nbsp;<del>{{number_format($product->old_price)}}</del>
                        تومان
                    </p>
                    <p class="lead">{{$product->description}}</p>
                    @if(!empty($product->details))
                        @foreach($product->details as $detailName => $details)
                            <p>{{$detailName}}:
                                @foreach($details as $item)
                                    <span>{{$item}}&nbsp;</span>
                                @endforeach
                            </p>
                        @endforeach
                    @endif
                </div>
                @auth
                    <div class="card-footer">
                        <form action="{{route('cart.store',$product)}}" method="post" class="">
                            @csrf

                            <button type="submit" name="addToCart" class="btn btn-warning "
                                    onclick="this.disabled=true;this.innerHTML='<small>در حال انجام...</small>';this.form.submit();">
                                <small>اضافه کردن به سبد خرید</small>
                            </button>
                        </form>
                        <div class="rate mt-3">
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                        </div>
                        <p>
                            امتیاز: <span class="badge badge-dark rateBadge">{{$product->rate}}</span> از <span
                                    class="badge badge-dark rateCountBadge">{{$product->rate_count}}</span> رای
                        </p>

                    </div>
                @endauth


            </div>
        </div>
    </div>



@endsection


@section('script')
    <script type="text/javascript">
        $(".rate span").on("click", function () {
            var currentIndex = $(".rate span").index($(this));
            $(".rate span").each((index, item) => {
                if (index <= currentIndex) {
                    item.classList.add("checked");
                    // item.addClass("checked");
                } else {
                    item.classList.remove("checked");
                }
            });
            $.ajax({
                type: 'POST',
                url: '/product/' + '{{$product->id}}' + '/rate',
                headers: {
                    "X-CSRF-TOKEN": "@php echo csrf_token() @endphp"
                },
                data: {'rate': currentIndex + 1},
                success: function (data) {

                    $(".rateBadge").text(data.rate.slice(0, 3));
                    $(".rateCountBadge").text(data.rateCount);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>

@endsection