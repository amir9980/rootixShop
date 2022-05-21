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


    </ul>
</nav>