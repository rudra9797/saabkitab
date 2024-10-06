        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="">S<span style="color:rgb(201, 91, 91);">K</span></i>
                </div>
                <div class="sidebar-brand-text mx-3">SAAB <span style="color:rgb(201, 91, 91);">KITAB</span></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Request::is('dashboard*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            @if(Auth::user()->is_admin==1)
                <!-- Sidenav Heading (Settings)-->
                <li class="nav-item {{ Request::is('users*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Users</span></a>
                </li>
             
            @else
            <li class="nav-item {{ Request::is('pos*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pos.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>POS</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Orders
            </div>
                <li class="nav-item {{ Request::is('orders/complete**') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('order.completeOrders') }}">
                        <i class="fas fa-fw fa-check"></i>
                        <span>Complete</span></a>
                </li>
                <li class="nav-item {{ Request::is('orders/pending**') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('order.pendingOrders') }}">
                        <i class="fas fa-fw fa-check-square"></i>
                        <span>Pending</span></a>
                </li>
                <li class="nav-item {{ Request::is('orders/due**') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('order.dueOrders') }}">
                        <i class="fas fa-fw fa-exclamation-circle"></i>
                        <span>Due</span></a>
                </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Users
            </div>
            <li class="nav-item {{ Request::is('customers*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('customers.index') }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Customers</span></a>
                </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Catalog
            </div>
            <li class="nav-item {{ Request::is('products*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('products.index') }}">
                        <i class="fas fa-fw fa-briefcase"></i>
                        <span>Products</span></a>
                </li>
                <li class="nav-item {{ Request::is('categories*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('categories.index') }}">
                        <i class="fa-fw fa fa-th-list"></i>
                        <span>Categories</span></a>
                </li>
                <li class="nav-item {{ Request::is('units*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('units.index') }}">
                        <i class="fas fa-fw fa fa-th-large"></i>
                        <span>Units</span></a>
                </li>
                @endif
            <!-- Nav Item - Pages Collapse Menu -->
            
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle" style="display: none;"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->
        <?php /*?>
<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Core</div>
            <a class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Dashboard
            </a>
            @if(Auth::user()->is_admin==1)
                <!-- Sidenav Heading (Settings)-->
                <div class="sidenav-menu-heading">Settings</div>
                <a class="nav-link {{ Request::is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <div class="nav-link-icon"><i class="fa-solid fa-users"></i></div>
                    Users
                </a>
             
            @else
          
            <a class="nav-link {{ Request::is('pos*') ? 'active' : '' }}" href="{{ route('pos.index') }}">
                <div class="nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                POS
            </a>
                         <!-- Sidenav Heading (Orders)-->
                         <div class="sidenav-menu-heading">Orders</div>
            <a class="nav-link {{ Request::is('orders/complete*') ? 'active' : '' }}" href="{{ route('order.completeOrders') }}">
                <div class="nav-link-icon"><i class="fa-solid fa-circle-check"></i></div>
                Complete
            </a>
            <a class="nav-link {{ Request::is('orders/pending*') ? 'active' : '' }}" href="{{ route('order.pendingOrders') }}">
                <div class="nav-link-icon"><i class="fa-solid fa-clock"></i></div>
                Pending
            </a>
            <a class="nav-link {{ Request::is('orders/due*') ? 'active' : '' }}" href="{{ route('order.dueOrders') }}">
                <div class="nav-link-icon"><i class="fa-solid fa-credit-card"></i></div>
                Due
            </a>
            <!-- Sidenav Heading (Pages)-->
            <div class="sidenav-menu-heading">Pages</div>
            <a class="nav-link {{ Request::is('customers*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                <div class="nav-link-icon"><i class="fa-solid fa-users"></i></div>
                Customers
            </a>
          
            <!-- Sidenav Heading (Products)-->
            <div class="sidenav-menu-heading">Products</div>
            <a class="nav-link {{ Request::is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                <div class="nav-link-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                Products
            </a>
            <a class="nav-link {{ Request::is('categories*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                <div class="nav-link-icon"><i class="fa-solid fa-folder"></i></div>
                Categories
            </a>
            <a class="nav-link {{ Request::is('units*') ? 'active' : '' }}" href="{{ route('units.index') }}">
                <div class="nav-link-icon"><i class="fa-solid fa-folder"></i></div>
                Units
            </a>
            @endif

        </div>
    </div>

    <!-- Sidenav Footer-->
    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Logged in as:</div>
            <div class="sidenav-footer-title">{{ auth()->user()->name }}</div>
        </div>
    </div>
</nav>
<?php */ ?>