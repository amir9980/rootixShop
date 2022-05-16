<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/plugins/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('assets/plugins/iCheck/flat/blue.css')}}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{asset('assets/plugins/morris/morris.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datepicker/datepicker3.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker-bs3.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="{{asset('assets/dist/css/bootstrap-rtl.min.css')}}">
    <!-- template rtl version -->
    <link rel="stylesheet" href="{{asset('assets/dist/css/custom-style.css')}}">


</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{route('home')}}" class="nav-link">خانه</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">تماس</a>
            </li>
            @guest
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{route('login')}}" class="nav-link">ورود</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{route('register')}}" class="nav-link">عضویت</a>
                </li>
            @endguest
            @auth
                <li class="nav-item d-none d-sm-inline-block ">
                    <form action="{{route('logout')}}" method="post">
                        @csrf
                        <button type="submit" class="list-group-item border-0 m-1">خروج</button>
                    </form>
                </li>
            @endauth
        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="جستجو" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav mr-auto">

        @auth
            @if(isset($cart))
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
                                <button type="button" class="btn btn-warning " data-toggle="modal"
                                        data-target="#cartModal">
                                    خرید
                                </button>
                            </div>


                        </div>

                        @endif

                    </li>
                @endauth


        </ul>
    </nav>
    <!-- /.navbar -->
@auth

    <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
                     class="brand-image img-circle elevation-3"
                     style="opacity: .8">
                <span class="brand-text font-weight-light">پنل مدیریت</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar" style="direction: ltr">
                <div style="direction: rtl">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="https://www.gravatar.com/avatar/52f0fbcbedee04a121cba8dad1174462?s=200&d=mm&r=g"
                                 class="img-circle elevation-2" alt="User Image">
                        </div>

                        <div class="info">
                            <a href="#" class="d-block">{{\Illuminate\Support\Facades\Auth::user()->username}}</a>
                        </div>

                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                                 with font-awesome or any other icon font library -->
                            @if(request()->user()->is_admin == 1)
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-shopping-bag" aria-hidden="true">&nbsp;</i>
                                        <p>
                                            محصولات
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview" style="display: none;">
                                        <li class="nav-item">
                                            <a href="{{route('product.index')}}" class="nav-link">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>نمایش محصولات</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('product.create')}}" class="nav-link">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>ایجاد محصول</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-user-circle" aria-hidden="true">&nbsp;</i>

                                        <p>
                                            خرید ها
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview" style="display: none;">

                                        <li class="nav-item">
                                            <a href="{{route('factor.index')}}" class="nav-link">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>سبد های ثبت شده</p>
                                            </a>
                                        </li>


                                    </ul>
                                </li>

                            @endif
                            <li class="nav nav-item">
                                <a href="{{route('factor.index')}}" class="nav-link">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <p>خرید های انجام شده</p>
                                </a>
                            </li>

                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
            </div>
            <!-- /.sidebar -->
        </aside>

@endauth

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@yield('page title')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">خانه</a></li>
                            <li class="breadcrumb-item active">@yield('page title')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid ">

                @if($errors->any())
                    <div class="alert alert-danger col-sm-12 col-lg-6">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>

                @endif

                @if(session('message'))
                    <div class="alert alert-success col-sm-12 col-lg-6">
                        <ul class="list-inline">
                            <li>
                                <button type="button" class="close float-left" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </li>
                            <li>{{session('message')}}</li>

                        </ul>
                    </div>

                @endif

                @if(isset($cart))
                    {{-- Cart Modal --}}
                    <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLongTitle">تایید سبد خرید</h5>
                                    <button type="button" class="close mr-auto ml-0" data-dismiss="modal"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if(count($cart)>0)
                                        <form action="{{route('factor.store')}}" method="post">
                                            @csrf
                                            <p>آیا از خرید اطمینان دارید؟</p>
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th>عنوان محصول</th>
                                                    <th>تعداد</th>
                                                    <th>قیمت</th>
                                                </tr>
                                                @php $sum = 0 @endphp
                                                @foreach($cart as $item)
                                                    <tr>
                                                        <td>{{$item->product->title}}</td>
                                                        <td>{{$item->count}}</td>
                                                        <td>{{$item->product->price}}تومان&nbsp;</td>
                                                    </tr>
                                                    @php $sum += $item->product->price*$item->count @endphp
                                                @endforeach
                                                <tr>
                                                    <td colspan="3">مبلغ پرداختی:&nbsp;@php echo $sum; @endphpتومان
                                                    </td>
                                                </tr>
                                            </table>

                                            <input type="submit" class="btn btn-primary" name="sumbit" value="پرداخت">
                                            <input type="hidden" name="price" value="@php echo $sum; @endphp">
                                        </form>
                                    @else
                                        <p>شما محصولی در سبد خرید خود ندارید!</p>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- Cart Modal --}}
                @endif


                @yield('content')


            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>CopyLeft &copy; 2018 <a href="http://github.com/hesammousavi/">حسام موسوی</a>.</strong>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{asset('assets/plugins/morris/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('assets/plugins/knob/jquery.knob.js')}}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{asset('assets/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{asset('assets/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('assets/plugins/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('assets/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('assets/dist/js/demo.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".jalaliDatePicker").pDatepicker();
    });
</script>


</body>
</html>
