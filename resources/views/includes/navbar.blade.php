

<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom @guest mr-0 @endguest">
    <!-- Left navbar links -->
    <ul class="navbar-nav">

        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('home')}}" class="nav-link">صفحه اصلی</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">تماس</a>
        </li>
        @guest
            <li class="nav-item d-none d-sm-inline-block ml-2">
                <a href="{{route('login')}}" class="nav-link btn btn-outline-success">ورود</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{route('register')}}" class="nav-link btn btn-outline-info">عضویت</a>
            </li>
        @endguest

    </ul>
    @auth
        <form action="{{route('logout')}}" method="post">
            @csrf
            <button type="submit" class="btn btn-outline-danger">خروج</button>
        </form>

@endauth

<!-- Right navbar links -->
    @auth
    <ul class="navbar-nav mr-auto align-items-center ">


        <li class="ml-3">
            <p class="mb-0 text-primary">موجودی کیف پول شما: <small>{{number_format(request()->user()->wallet)}}</small> تومان</p>
        </li>



            <!-- Cart Dropdown Menu -->

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        <span class="badge badge-warning navbar-badge">{{count(\Illuminate\Support\Facades\Auth::user()->cart)}}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
                        <span class="dropdown-item dropdown-header">{{count(\Illuminate\Support\Facades\Auth::user()->cart)}} محصول در سبد شما وجود دارد</span>
                        @foreach(\Illuminate\Support\Facades\Auth::user()->cart as $item)
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-item d-flex justify-content-between align-items-center">
                                <div>
                                    <img class="rounded-circle" src="{{route('images.product',$item->product->images['thumb'])}}" alt="productImage" width="50px" height="50px">
                                <span>{{$item->product->title}}</span>
                                </div>
                                <div class="d-flex text-muted text-sm align-items-center">
                                    <span>{{number_format($item->product->price)}}&nbsp;تومان</span>
                                </div>
                            </div>
                        @endforeach

                        <div class="dropdown-item dropdown-footer">
                            <a href="{{route('cart.show')}}" class="btn btn-block btn-warning">خرید</a>
                        </div>


                    </div>


                </li>


    </ul>
    @endauth
</nav>
