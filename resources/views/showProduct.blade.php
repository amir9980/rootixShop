@extends('layouts.master')

@section('title', 'مشاهده محصول')
@section('page title', 'مشاهده محصول')

@section('content')
    <div class="container">
        <div class="row pb-2">
            <div class="col-md-6 ">
                <div class="card text-center p-3 h-100">
                    @auth
                        <div id="bookmark" class="position-absolute" onclick="bookmark(this,{{$product->id}})">

                        <span class="fa @if(request()->user()->bookmarks->contains($product)) fa-bookmark @else fa-bookmark-o @endif "
                              aria-hidden="true"></span>
                        </div>
                    @endauth
                    <div class="card-header ">
                        <h5>{{$product->title}}</h5>
                    </div>


                    <div class="card-body d-flex flex-column">
                        <div class="lead mt-3">{{$product->description}}</div>
                        <div class="my-auto">
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

                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-4">
                                <del class="text-danger text-bold">{{number_format($product->off_price)}}</del>
                                <span class="h5 text-bold">{{number_format($product->price)}}&nbsp;تومان</span>

                            </div>
                            <div class="col-md-4">
                                <form action="{{route('cart.store',$product)}}" method="post">
                                    @csrf
                                    <button type="submit" name="addToCart" class="btn btn-light"
                                            onclick="this.disabled=true;this.innerHTML='<small>در حال انجام...</small>';this.form.submit();">
                                        <span class="fa fa-cart-plus text-success display-4" aria-hidden="true"></span>
                                    </button>
                                </form>
                            </div>

                        </div>


                    </div>
                    @auth
                        <div class="card-footer">

                            <div class="rate mt-3">
                                @foreach(range(1,5) as $index)
                                <span class="fa fa-star {{$index<=$product->rate ? 'checked':''}}"></span>
                              @endforeach

                            </div>
                            <p>
                                امتیاز: <span class="badge badge-dark rateBadge">{{$product->rate}}</span> از <span
                                        class="badge badge-dark rateCountBadge">{{$product->rate_count}}</span> رای
                            </p>

                        </div>
                    @endauth


                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 h-100">
                    <div class="card-body">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"
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
                                        <img class="d-block w-100" src="{{route('images.product',$image->path)}}"
                                             alt=" slide" style="height: 500px">
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                               data-slide="next">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                               data-slide="prev">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="col-12">نظرات</h2>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($product->comments as $comment)
                        @if($comment->status == 'Active')
                            <li class="list-group-item">
                                <div class="row justify-content-between">
                                    <div class="d-flex col-md-3 align-items-center">
                                        <img src="{{route('images.user',$comment->user->profile_pic)}}" alt="user image"
                                             width="40rem" class="rounded-circle">
                                        <h5 class="mr-3 mb-0">{{$comment->user->username}}</h5>
                                    </div>
                                    <div class="d-flex col-md-2 align-items-center justify-content-between">

                                        @can('delete',$comment)
                                            <form action="{{route('comment.destroy',$comment->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger ">حذف
                                                </button>
                                            </form>
                                        @endcan
                                        <small>{{\Morilog\Jalali\Jalalian::forge($comment->created_at)->format('%A, %d %B %y')}}</small>
                                    </div>

                                </div>
                                <p class="mb-0 mt-3">{{$comment->body}}</p>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <form action="{{route('comment.store',$product->id)}}" method="POST" class="my-5">
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control" name="body" placeholder="نظر بدهید..."></textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">ارسال نظر</button>
                </form>
            </div>
        </div>
    </div>




@endsection


@section('script')
    <script type="text/javascript">


        function bookmark(div, prodId) {
            $.ajax({
                type: "POST",
                url: '/product/' + prodId + '/bookmark',
                headers: {
                    "X-CSRF-TOKEN": "@php echo csrf_token() @endphp"
                },
                success: function (data) {
                    if (data.message == 'deleted.') {
                        div.innerHTML = "<span class='fa fa-bookmark-o'></span>";
                        console.log(data.message);
                    } else {
                        div.innerHTML = "<span class='fa fa-bookmark'></span>";
                        console.log(data.message);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }


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

