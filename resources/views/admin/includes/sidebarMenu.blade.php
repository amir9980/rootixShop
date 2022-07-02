<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
        data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

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
                    کاربران
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">

                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>لیست کاربران</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('factor.index')}}" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>خرید های ثبت شده</p>
                    </a>
                </li>


            </ul>
        </li>

        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="fa fa-usd" aria-hidden="true">&nbsp;</i>

                <p>
                    کدهای تخفیف
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">

                <li class="nav-item">
                    <a href="{{route('discountToken.index')}}" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>لیست کدهای تخفیف</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('discountToken.create')}}" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>ساخت کد تخفیف</p>
                    </a>
                </li>


            </ul>
        </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fa fa-calendar-check-o" aria-hidden="true">&nbsp;</i>

                        <p>
                            جشنواره های تخفیف
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">

                        <li class="nav-item">
                            <a href="{{route('discountEvent.index')}}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>لیست جشنواره ها</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('discountEvent.create')}}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>ساخت جشنواره</p>
                            </a>
                        </li>


            </ul>
        </li>


        <li class="nav-item has-treeview">
                    <a href="#" class="nav-link ">
                        <i class="fa fa-comment" aria-hidden="true">&nbsp;</i>
                        <p>
                            نظرات
                            <span class="badge badge-pill badge-light pt-1">{{\App\Models\Comment::where('status','=','inactive')->count()}}</span>
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">

                        <li class="nav-item">
                            <a href="{{route('comment.index')}}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>همه نظرات</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('inactiveComments.index')}}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>نظرات تایید نشده <span class="badge badge-pill badge-light pt-1">{{\App\Models\Comment::where('status','=','inactive')->count()}}</span></p>
                            </a>
                        </li>


            </ul>
        </li>


    </ul>
</nav>