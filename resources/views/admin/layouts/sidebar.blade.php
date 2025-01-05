<aside class="main-sidebar sidebar-light-primary elevation-4 custom-sidebar-bg">
    <a href="" class="brand-link text-start py-3">
        <img src="{{ asset('assests/photos/BrandLogo.ico') }}" alt="SSO Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin</span>
    </a>

    <div class="sidebar mt-3">
        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 40px; height: 40px;">
                    {{ strtoupper(substr(Auth::user()->firstname ?? 'G', 0, 1)) }}
                </div>
            </div>
            <div class="info ml-2">
                <a href="{{ route('admin.profile.dashboard') }}" class="d-block font-weight-bold text-dark">
                    {{ strtok(Auth::user()->firstname ?? 'Guest', ' ') }}
                </a>
            </div>
        </div>



        <!-- Sidebar Menu -->
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('admin.main-dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active bg-primary text-white' : 'text-dark' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p class="ml-2">Dashboard</p>
                    </a>
                </li>
                <li class="nav-header mt-3">User Management</li>

                <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link {{ request()->routeIs() ? 'active bg-primary text-white' : 'text-dark' }}">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p class="ml-2">Users<i class="right fas fa-angle-left mt-1"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.users.dashboard') }}" class="nav-link {{ request()->routeIs('admin.users.dashboard') ? 'active bg-primary' : 'text-dark' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Users</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <li class="nav-header mt-3">Product Management</li>

                <!-- <li class="nav-item {{ request()->routeIs('admin.stocks.*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link {{ request()->routeIs() ? 'active bg-primary text-white' : 'text-dark' }}">
                        <i class="nav-icon bi bi-people"></i>
                        <p class="ml-2">Users<i class="right fas fa-angle-left mt-1"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->routeIs() ? 'active bg-primary' : 'text-dark' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Users</p>
                            </a>
                        </li>
                    </ul>
                </li> -->

                <li class="nav-item {{ request()->routeIs('admin.brand.*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link {{ request()->routeIs() ? 'active bg-primary text-white' : 'text-dark' }}">
                        <i class="nav-icon bi bi-circle-square"></i>
                        <p class="ml-2">Brand<i class="right fas fa-angle-left mt-1"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.brand.dashboard') }}" class="nav-link {{ request()->routeIs('admin.brand.dashboard') ? 'active bg-primary' : 'text-dark' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Brand</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.brand.create') }}" class="nav-link {{ request()->routeIs('admin.brand.create') ? 'active bg-primary text-white' : 'text-dark' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p class="ml-2">Add Brand</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ request()->routeIs('admin.products.*', 'admin.product_discount.*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link {{ request()->routeIs() ? 'active bg-primary text-white' : 'text-dark' }}">
                        <i class="nav-icon bi bi-bag-plus"></i>
                        <p class="ml-2">Products<i class="right fas fa-angle-left mt-1"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.products.dashboard') }}" class="nav-link {{ request()->routeIs('admin.category.dashboard') ? 'active bg-primary' : 'text-dark' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.product_discount.dashboard') }}" class="nav-link {{ request()->routeIs('admin.product_discount.dashboard') ? 'active bg-primary' : 'text-dark' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Product Discounts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.products.create') }}" class="nav-link {{ request()->routeIs('admin.products.create') ? 'active bg-primary text-white' : 'text-dark' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p class="ml-2">Add Product</p>
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="nav-item {{ request()->routeIs('admin.category.*', 'admin.sub_category.*', 'admin.sub_sub_category.*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link {{ request()->routeIs() ? 'active bg-primary text-white' : 'text-dark' }}">
                        <i class="nav-icon bi bi-tags"></i>
                        <p class="ml-2">Categories<i class="right fas fa-angle-left mt-1"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.category.dashboard') }}" class="nav-link {{ request()->routeIs('admin.category.dashboard') ? 'active bg-primary' : 'text-dark' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.category.create') }}" class="nav-link {{ request()->routeIs('admin.category.create') ? 'active bg-primary' : 'text-dark' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Add Main Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.sub_category.create') }}" class="nav-link {{ request()->routeIs('admin.sub_category.create') ? 'active bg-primary' : 'text-dark' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Add Sub Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.sub_sub_category.create') }}" class="nav-link {{ request()->routeIs('admin.sub_sub_category.create') ? 'active bg-primary' : 'text-dark' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Add Sub Sub Category</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <li class="nav-item {{ request()->routeIs('admin.supplier.*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link {{ request()->routeIs() ? 'active bg-primary text-white' : 'text-dark' }}">
                        <i class="nav-icon bi bi-person-lines-fill"></i>
                        <p class="ml-2">Suppliers<i class="right fas fa-angle-left mt-1"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.supplier.dashboard') }}" class="nav-link {{ request()->routeIs('admin.supplier.dashboard') ? 'active bg-primary' : 'text-dark' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Suppliers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.supplier.create') }}" class="nav-link {{ request()->routeIs('admin.supplier.create') ? 'active bg-primary' : 'text-dark' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Add Suppliers</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ request()->routeIs('admin.stocks.*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link {{ request()->routeIs() ? 'active bg-primary text-white' : 'text-dark' }}">
                        <i class="nav-icon bi bi-box-seam"></i>
                        <p class="ml-2">Stocks<i class="right fas fa-angle-left mt-1"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.stocks.dashboard') }}" class="nav-link {{ request()->routeIs('admin.stocks.dashboard') ? 'active bg-primary' : 'text-dark' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Stocks</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header mt-3">History</li>

                <li class="nav-item">
                    <a href="{{ route('admin.activity_logs.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Activity Logs</p>
                    </a>
                </li>


                <li class="nav-item mt-3">
                    <a href="#" class="nav-link text-danger d-flex align-items-center" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon bi bi-door-closed"></i>
                        <p class="ml-2">Logout</p>
                    </a>
                </li>

                <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
                    @csrf
                </form>
            </ul>
        </nav>
    </div>
</aside>