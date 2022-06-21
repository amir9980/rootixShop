<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
{{--    <link rel="stylesheet" href="{{asset('assets/plugins/font-awesome/css/font-awesome.min.css')}}">--}}
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
{{--    <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">--}}
    <!-- iCheck -->
    {{--<link rel="stylesheet" href="{{asset('assets/plugins/iCheck/flat/blue.css')}}">--}}
    <!-- Morris chart -->
    {{--<link rel="stylesheet" href="{{asset('assets/plugins/morris/morris.css')}}">--}}
    <!-- jvectormap -->
    {{--<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">--}}
    <!-- Date Picker -->
    {{--<link rel="stylesheet" href="{{asset('assets/plugins/datepicker/datepicker3.css')}}">--}}
    <!-- Daterange picker -->
    {{--<link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker-bs3.css')}}">--}}
    <!-- bootstrap wysihtml5 - text editor -->
    {{--<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">--}}
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
{{--    <link rel="stylesheet" href="{{asset('assets/dist/css/bootstrap-rtl.min.css')}}">--}}
    <!-- template rtl version -->
{{--    <link rel="stylesheet" href="{{asset('assets/dist/css/custom-style.css')}}">--}}
    {{-- Persian Date Picker --}}
{{--    <link rel="stylesheet" href="{{asset('assets/dist/css/persian-datepicker.min.css')}}"/>--}}

    <style>
        .rate span.checked{
            color: orange;
        }
        .rate span:hover{
            cursor: pointer;
        }

    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    @include('includes.navbar')
    <!-- /.navbar -->
@auth

    <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{route('home')}}" class="brand-link">
                <span class="brand-text font-weight-light">پنل مدیریت</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar" style="direction: ltr">
                <div style="direction: rtl">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="{{route('images.user',\Illuminate\Support\Facades\Auth::user()->profile_pic)}}"
                                 class="img-circle elevation-2" alt="User Image">
                        </div>

                        <div class="info">
                            <a href="{{route('profile.show')}}" class="d-block">{{\Illuminate\Support\Facades\Auth::user()->username}}</a>
                        </div>

                    </div>

                    <!-- Sidebar Menu -->
                    @if(request()->user()->is_admin == 1)
                        @include('admin.includes.sidebarMenu')
                        @else
                        @include('includes.sidebarMenu')

                @endif
                    <!-- /.sidebar-menu -->
                </div>
            </div>
            <!-- /.sidebar -->
        </aside>

@endauth

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper @guest mr-0 @endguest">
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

                @include('includes.messagesDisplay')


                @yield('content')


            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer @guest mr-0 @endguest">
        <strong>&copy; تمامی حقوق متعلق به وبسایت میباشد.</strong>
    </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
{{--<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>--}}

<script src={{asset("js/app.js")}}></script>

<!-- jQuery UI 1.11.4 -->
{{--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>--}}

{{--<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->--}}
{{--<script>--}}
    {{--$.widget.bridge('uibutton', $.ui.button)--}}
{{--</script>--}}
{{--<!-- Bootstrap 4 -->--}}
{{--<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>--}}
{{--<!-- Morris.js charts -->--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
{{--<script src="{{asset('assets/plugins/morris/morris.min.js')}}"></script>--}}
{{--<!-- Sparkline -->--}}
{{--<script src="{{asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>--}}
{{--<!-- jvectormap -->--}}
{{--<script src="{{asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>--}}
{{--<script src="{{asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>--}}
{{--<!-- jQuery Knob Chart -->--}}
{{--<script src="{{asset('assets/plugins/knob/jquery.knob.js')}}"></script>--}}
{{--<!-- daterangepicker -->--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
{{--<script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>--}}
{{--<!-- datepicker -->--}}
{{--<script src="{{asset('assets/plugins/datepicker/bootstrap-datepicker.js')}}"></script>--}}
{{--<!-- Bootstrap WYSIHTML5 -->--}}
{{--<script src="{{asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>--}}
{{--<!-- Slimscroll -->--}}
{{--<script src="{{asset('assets/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>--}}
{{--<!-- FastClick -->--}}
{{--<script src="{{asset('assets/plugins/fastclick/fastclick.js')}}"></script>--}}
{{--<!-- AdminLTE App -->--}}
{{--<script src="{{asset('assets/dist/js/adminlte.js')}}"></script>--}}
{{--<!-- AdminLTE for demo purposes -->--}}
{{--<script src="{{asset('assets/dist/js/demo.js')}}"></script>--}}

{{-- Persian Date Picker --}}
<script src="{{asset('assets/dist/js/persian-date.min.js')}}"></script>
<script src="{{asset('assets/dist/js/persian-datepicker.min.js')}}"></script>

{{-- Jquery Number Format Plugin --}}
{{--<script src="{{asset('assets/dist/js/jquery.number.min.js')}}"></script>--}}

<script type="text/javascript">



    {{--function sendDeleteImgRequest(btn){--}}
        {{--$.ajax({--}}
            {{--type: "POST",--}}
            {{--url: "/admin/product/deleteImg",--}}
            {{--headers:{--}}
                {{--"X-CSRF-TOKEN":"@php echo csrf_token() @endphp"--}}
            {{--},--}}
            {{--success: function(data,txt,xhr){--}}
                {{--btn.innerHTML = data.message;--}}
            {{--},--}}
            {{--error: function (xhr,statustxt,err) {--}}
                {{--console.log(xhr.responseText);--}}
            {{--}--}}
        {{--})--}}

    {{--}--}}



    $(document).ready(function () {


        $(".rate span").on("click",function(){
            var currentIndex = $(".rate span").index($(this));
            $(".rate span").each((index,item)=>{
                if(index <= currentIndex){
                    item.classList.add("checked");
                    // item.addClass("checked");
                }else{
                    item.classList.remove("checked");
                }
            });
            $.ajax({
                type:'POST',
                url: '/product/'+'{{$product->id}}'+'/rate',
                headers:{
                "X-CSRF-TOKEN":"@php echo csrf_token() @endphp"
                },
                data:{'rate':currentIndex+1},
                success:function (data) {

                    $(".rateBadge").text(data.rate.slice(0,3));
                    $(".rateCountBadge").text(data.rateCount);
                },
                error:function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        $("#accessSelectBox").on('change',function () {
            if($(this).val()=='public'){
                $("#userIdInput").prop('disabled',true);
            }
            else {
                $("#userIdInput").prop('disabled',false);
            }
        });


        $("#confirmDetailsForm .increaseButton").click(function () {
            var val = parseInt(fixNumbers($(this).siblings("span").text()));
            $(this).siblings("span").text(val+1);
            $(this).siblings(".productCount").val(val+1);
        });

        $("#confirmDetailsForm .decreaseButton").click(function () {
            var val = parseInt(fixNumbers($(this).siblings("span").text()));
            if (val > 1){
                $(this).siblings("span").text(val-1);
                $(this).siblings(".productCount").val(val-1);

            }else if(val <= 1){
                $(this).closest("tr").remove();
            }
        });

        $(".submitbtn").click(function (){
            this.disabled=true;
            this.innerHTML='<small>...</small>';
            this.form.submit();
        });

        $(".jalaliDatePicker").pDatepicker({
            initialValue: false,
            autoClose: true,

            format: 'YYYY/MM/DD',
        });

        $(".numberInput").keyup(function () {
            var number = $(this).val();
            $(this).val($.number(number));
        });

        $(".numberInput").keydown(function (evt) {
            // var charCode = (e.which) ? e.which : event.keyCode;
            // if (String.fromCharCode(charCode).match(/[^0-9]/g))
            //     return false;
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        });

    });

        var
        persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g],
        arabicNumbers  = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g];

        fixNumbers = function (str)
        {
            if(typeof str === 'string')
            {
                for(var i=0; i<10; i++)
                {
                    str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
                }
            }
            return str;
        };

</script>


</body>
</html>
