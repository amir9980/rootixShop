

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


        @if(isset($cart) && !empty($cart))
            <!-- Cart Dropdown Menu -->

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        <span class="badge badge-warning navbar-badge">{{count($cart)}}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
                        <span class="dropdown-item dropdown-header">{{count($cart)}} محصول در سبد شما وجود دارد</span>
                        @foreach($cart as $item)
                            <div class="dropdown-divider"></div>
                            <a href="{{route('product.show',$item->product)}}" class="dropdown-item">
                                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                {{$item->product->title}}
                                <span class="float-left text-muted text-sm">{{$item->count}} عدد</span>
                            </a>
                        @endforeach

                        <div class="dropdown-item dropdown-footer">
                            <form action="{{route('factor.store')}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning">ثبت و ادامه</button>
                            </form>
                        </div>


                    </div>

                    @endif

                </li>


    </ul>
    @endauth
</nav>
