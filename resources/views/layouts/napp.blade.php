<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{url('js/jquery.js')}}"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        STV Warehouse
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Suppliers
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    &nbsp;<a href="{{url('/add-supplier')}}">Add Supplier</a>
                                </li>
                                <li>
                                    &nbsp;<a href="{{url('/view-suppliers')}}">View Suppliers</a>
                                </li>

                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Categories
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    &nbsp;<a href="{{url('/add-category')}}">Add Category</a>
                                </li>
                                <li>
                                    &nbsp;<a href="{{url('/view-categories')}}">View Categories</a>
                                </li>

                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Products
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    &nbsp;<a href="{{url('/add-product')}}">Add Product</a>
                                </li>
                                <li>
                                    &nbsp;<a href="{{url('/view-products')}}">View Products</a>
                                </li>

                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Clients
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    &nbsp;<a href="{{url('/add-client')}}">Add Client</a>
                                </li>
                                <li>
                                    &nbsp;<a href="{{url('/view-clients')}}">View Clients</a>
                                </li>

                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Sales Reps
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    &nbsp;<a href="{{url('/add-salesrep')}}">Add Sales Rep</a>
                                </li>
                                <li>
                                    &nbsp;<a href="{{url('/view-salesreps')}}">View Sales Reps</a>
                                </li>

                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Sales
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    &nbsp;<a href="{{url('/add-sale')}}">Add Sales</a>
                                </li>
                                <li>
                                    &nbsp;<a href="{{url('/view-sales')}}">View Sales</a>
                                </li>

                            </ul>
                        </li>


                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Invoices
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    &nbsp;<a href="{{url('/create-invoice')}}">Create Invoice</a>
                                </li>
                                <li>
                                    &nbsp;<a href="{{url('/view-invoices')}}">View Invoices</a>
                                </li>

                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Receipts
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    &nbsp;<a href="{{url('/create-receipt')}}">Create Receipt</a>
                                </li>
                                <li>
                                    &nbsp;<a href="{{url('/view-receipts')}}">View Receipts</a>
                                </li>

                            </ul>
                        </li>

                        <li>
                            <a href="{{url('settings')}}">Settings</a>
                        </li>


                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
