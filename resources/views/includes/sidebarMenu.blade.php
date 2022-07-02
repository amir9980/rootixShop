

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
        data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

        <li class="nav-item">
            <a href="{{route('profile.show')}}" class="nav-link">
                <i class="fa fa-user-circle" aria-hidden="true">&nbsp;</i>
                <p>حساب کاربری</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('cart.show')}}" class="nav-link">
                <i class="fa fa-shopping-cart" aria-hidden="true">&nbsp;</i>
                <p>سبد خرید</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('users.charge')}}" class="nav-link">
                <i class="fa fa-credit-card-alt" aria-hidden="true">&nbsp;</i>

                <p>شارژ کیف پول</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('factor.index')}}" class="nav-link">
                <i class="fa fa-shopping-cart" aria-hidden="true">&nbsp;</i>
                <p>خرید های ثبت شده</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('users.bookmarks')}}" class="nav-link">
                <i class="fa fa-bookmark" aria-hidden="true">&nbsp;</i>
                <p>محصولات ذخیره شده</p>
            </a>
        </li>


    </ul>
</nav>