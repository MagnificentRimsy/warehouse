
<!DOCTYPE html>
<html>


<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Bronko Warehouse Manager</title>

    <link href="{{ url('logo.png') }}" rel="apple-touch-icon" type="image/png" sizes="144x144">
    <link href="{{ url('logo.png') }}" rel="apple-touch-icon" type="image/png" sizes="114x114">
    <link href="{{ url('logo.png') }}" rel="apple-touch-icon" type="image/png" sizes="72x72">
    <link href="{{ url('logo.png') }}" rel="apple-touch-icon" type="image/png">
    <link href="{{ url('logo.png') }}" rel="icon" type="image/png">
    <link href="{{ url('logo.png') }}" rel="shortcut icon">


    <![endif]-->
    <link rel="stylesheet" href="{{url('css/separate/vendor/slick.min.css')}}">
    <link rel="stylesheet" href="{{url('css/separate/pages/profile.min.css')}}">

    <link rel="stylesheet" href="{{url('css/lib/lobipanel/lobipanel.min.css')}}">
    <link rel="stylesheet" href="{{url('css/separate/vendor/lobipanel.min.css')}}">
    <link rel="stylesheet" href="{{url('css/lib/jqueryui/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{url('css/separate/pages/widgets.min.css')}}">
    <link rel="stylesheet" href="{{url('css/lib/font-awesome/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('css/lib/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('css/main.css')}}">
    <link rel="stylesheet" href="{{url('css/jquery-ui.min.css')}}">



    <script src="{{url('js/lib/jquery/jquery.min.js')}}"></script>

    <script type="text/javascript" src="{{url('js/jquery-ui.min.js')}}"></script>




</head>
<body class="with-side-menu control-panel control-panel-compact">

<style>
    .box-typical-body{
        padding: 50px;
    }
</style>
<header class="site-header">
    <div class="container-fluid">



        <button id="show-hide-sidebar-toggle" style="float: left;" class="show-hide-sidebar">
            <span>toggle menu</span>
        </button>

        <button class="hamburger hamburger--htla">
            <span>toggle menu</span>
        </button>

        <a style="color:white; margin-left: 20px" href="{{url('/')}}" class="site-logo">
            <img src="{{ url('logo.png') }}" alt="">
        </a>
        

        <div class="site-header-content">
            <div class="site-header-content-in">
                <div class="site-header-shown">
                    <div class="dropdown dropdown-notification notif">
                        <a href="#"
                           class="header-alarm dropdown-toggle active"
                           id="dd-notification"
                           data-toggle="dropdown"
                           aria-haspopup="true"
                           aria-expanded="false">

                            <i class="font-icon-alarm"></i>
                        </a>

                        {{-- notifications --}}
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-notif" aria-labelledby="dd-notification">
                            <div class="dropdown-menu-notif-header">
                                Notifications
                                <span class="label label-pill label-danger">{{count(Session::get('lowStock'))}}</span>

                            </div>
                            <div class="dropdown-menu-notif-list">
                                @foreach(Session::get('lowStock') as $item)
                                <div class="dropdown-menu-notif-item">
                                    <div class="dot"></div>
                                    <a href="{{url('product/'. $item->pid)}}">{{$item->name}}</a>s stock is low
                                    <div class="color-blue-grey-lighter">{{$item->quantity}} remaining</div>
                                </div>
                                @endforeach
                            </div>
                            <div class="dropdown-menu-notif-more">
                                <a href="{{url('view-products')}}">View All Products</a>
                            </div>
                        </div>
                    </div>





                    @if(Auth::guest())

                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @else
                    <div class="dropdown user-menu">
                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span style="color:white;">{{Auth::user()->name}}</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
                            <a class="dropdown-item" href="{{url('profile/' . Auth::user()->uid)}}"><span class="font-icon glyphicon glyphicon-user"></span>Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item"  href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();"><span class="font-icon glyphicon glyphicon-log-out"></span>Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>

                        </div>
                    </div>
                    @endif

                    <button type="button" class="burger-right">
                        <i class="font-icon-menu-addl"></i>
                    </button>
                </div><!--.site-header-shown-->

                <div class="mobile-menu-right-overlay"></div>
                <div class="site-header-collapsed">
                    <div class="site-header-collapsed-in">
                        <div class="dropdown dropdown-typical">
                            <div class="dropdown-menu" aria-labelledby="dd-header-sales">
                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-home"></span>Skillset</a>
                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-cart"></span>Real Gmat Test</a>
                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-speed"></span>Prep Official App</a>
                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-users"></span>CATprer Test</a>
                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-comments"></span>Third Party Test</a>
                            </div>
                        </div>
                        <div class="dropdown dropdown-typical">

                            @if(Session::get('settings')->topMenu == 1)



                            <div class="dropdown dropdown-typical">
                                <a class="dropdown-toggle" style="color:white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Suppliers
                                </a>

                                <div class="dropdown-menu" >
                                    &nbsp;<a class="dropdown-item" href="{{url('/add-supplier')}}">Add Supplier</a>
                                    &nbsp;<a class="dropdown-item" href="{{url('/view-suppliers')}}">View Suppliers</a>
                                </div>
                            </div>



                            <div class="dropdown dropdown-typical">
                                <a class="dropdown-toggle" style="color:white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Categories

                                </a>

                                <div class="dropdown-menu" >
                                    &nbsp;<a class="dropdown-item" href="{{url('/add-category')}}">Add Category</a>

                                </div>
                            </div>

                            <div class="dropdown dropdown-typical">
                                <a class="dropdown-toggle" style="color:white"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Products/Services
                                </a>

                                <div class="dropdown-menu" >
                                    <a class="dropdown-item"  href=" {{url('/add-product')}} ">Add Products</a>
                                    <a class="dropdown-item"  href=" {{url('/view-products')}} ">View Products</a>


                                </div>
                            </div>


                            <div class="dropdown dropdown-typical">
                                <a class="dropdown-toggle" style="color:white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    Clients
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dd-header-social">
                                    <a class="dropdown-item"  href=" {{url('add-clients')}} ">Add Clients</a>
                                    <a class="dropdown-item"  href=" {{url('view-clients')}} ">View Clients</a>

                                </div>
                            </div>


                                <div class="dropdown dropdown-typical">
                                    <a class="dropdown-toggle" style="color:white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        Sales Reps
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dd-header-social">
                                        <a class="dropdown-item"  href=" {{url('add-salesreps')}} ">Add Sales Rep</a>
                                        <a class="dropdown-item"  href=" {{url('view-salesreps')}} ">View Sales Reps</a>

                                    </div>
                                </div>


                                <div class="dropdown dropdown-typical">
                                    <a class="dropdown-toggle" style="color:white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        Sales
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dd-header-social">
                                        <a class="dropdown-item"  href=" {{url('add-sales')}} ">Add Sales</a>
                                        <a class="dropdown-item"  href=" {{url('view-sales')}} ">View Sales</a>

                                    </div>
                                </div>


                                <div class="dropdown dropdown-typical">
                                    <a class="dropdown-toggle" style="color:white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        Receipts
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dd-header-social">
                                        <a class="dropdown-item"  href=" {{url('create-receipt')}} ">Add Receipts</a>
                                        <a class="dropdown-item"  href=" {{url('view-receipts')}} ">View Receipts</a>

                                    </div>
                                </div>

                                <div class="dropdown dropdown-typical">
                                    <a class="dropdown-toggle" style="color:white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        Settings
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dd-header-social">
                                        <a class="dropdown-item"  href=" {{url('settings')}} "> Settings </a>


                                    </div>
                                </div>


                            @endif


                        </div><!--.site-header-collapsed-in-->
                    </div><!--.site-header-collapsed-->
                </div><!--site-header-content-in-->
            </div><!--.site-header-content-->
        </div><!--.container-fluid-->
    </div>
</header><!--.site-header-->

<div class="mobile-menu-left-overlay"></div>


{{-- Side Menu --}}

<nav class="side-menu">
    <ul class="side-menu-list">
        <li class="grey">
            <a href="{{url('/home')}}">
	            <span>
	                <i class="font-icon font-icon-dashboard"></i>
	                <span class="lbl">Dashboard</span>
	            </span>
            </a>
        </li>


        <li class="gold with-sub">
	            <span>
	                <i class="font-icon font-icon-edit"></i>
	                <span class="lbl"> Suppliers</span>
	            </span>
            <ul>
                <li><a href="{{url('add-supplier')}}"><span class="lbl">Add Suppliers</span></a></li>
                <li><a href="{{url('view-suppliers')}}"><span class="lbl">View Suppliers</span></a></li>
            </ul>
        </li>


        <li class="gold with-sub">
	            <span>
	                <i class="font-icon font-icon-edit"></i>
	                <span class="lbl">Categories</span>
	            </span>
            <ul>
                <li><a href="{{url('add-category')}}"><span class="lbl">Add Category</span></a></li>
                <li><a href="{{url('view-categories')}}"><span class="lbl">View Categories</span></a></li>
            </ul>
        </li>

        <li class="gold with-sub">
	            <span>
	                <i class="font-icon font-icon-edit"></i>
	                <span class="lbl">Products/Services</span>
	            </span>
            <ul>
                <li><a href="{{url('add-product')}}"><span class="lbl">Add</span></a></li>
                <li><a href="{{url('view-products')}}"><span class="lbl">View Products</span></a></li>
            </ul>
        </li>

        @if(Auth::user()->role == 'Owner')

            <li class="gold with-sub">
                <span>
                    <i class="font-icon font-icon-edit"></i>
                    <span class="lbl">Clients</span>
                </span>
                <ul>
                    <li><a href="{{url('add-client')}}"><span class="lbl">Add</span></a></li>
                    <li><a href="{{url('view-clients')}}"><span class="lbl">Manage</span></a></li>
                </ul>
            </li>

            <li class="gold with-sub">
            <span>
                <i class="font-icon font-icon-edit"></i>
                <span class="lbl">Sales Reps</span>
            </span>
                <ul>
                    <li><a href="{{url('add-salesrep')}}"><span class="lbl">Add Sales Rep</span></a></li>
                    <li><a href="{{url('view-salesreps')}}"><span class="lbl">View Sales Reps</span></a></li>
                </ul>
            </li>

            <li class="gold with-sub">
            <span>
                <i class="font-icon font-icon-edit"></i>
                <span class="lbl">Sales</span>
            </span>
                <ul>
                    <li><a href="{{url('add-sale')}}"><span class="lbl">Add Sale</span></a></li>
                    <li><a href="{{url('return-sale')}}"><span class="lbl">Return Sale</span></a></li>
                    <li><a href="{{url('view-sales')}}"><span class="lbl">View Sales</span></a></li>
                </ul>
            </li>

            <li class="gold with-sub">
            <span>
                <i class="font-icon font-icon-edit"></i>
                <span class="lbl">Receipts</span>
            </span>
                <ul>
                    <li><a href="{{url('create-receipt')}}"><span class="lbl">Create Receipts</span></a></li>
                    <li><a href="{{url('view-receipts')}}"><span class="lbl">View Receipts</span></a></li>
                </ul>
            </li>

            <li class="gold with-sub">
            <span>
                <i class="font-icon font-icon-edit"></i>
                <span class="lbl">Budget Expenses</span>
            </span>
                <ul>
                    <li><a href="{{url('create-expense')}}"><span class="lbl">Create Expense</span></a></li>
                    <li><a href="{{url('view-expenses')}}"><span class="lbl">View Expenses</span></a></li>
                </ul>
            </li>



        <li class="gold with-sub">
	            <span>
	                <i class="font-icon font-icon-edit"></i>
	                <span class="lbl">Admin</span>
	            </span>
            <ul>
                {{--<li><a href="{{url('reports')}}"><span class="lbl">Reports</span></a></li>--}}
                {{--<li><a href="{{url('mobile-settings')}}"><span class="lbl">Un-delete</span></a></li>--}}
                {{--<li><a href="{{url('mobile-settings')}}"><span class="lbl">Mobile Settings</span></a></li>--}}
                <li><a href="{{url('settings')}}"><span class="lbl">Web Settings</span></a></li>
            </ul>
        </li>

        @endif

    </ul>


</nav><!--.side-menu-->

<div class="page-content">
    <div class="container-fluid">


        @yield('content')

    </div><!--.page-content-->




    <script src="{{url('js/lib/tether/tether.min.js')}}"></script>
    <script src="{{url('js/lib/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{url('js/footable.min.js')}}"></script>
    <script src="{{url('js/plugins.js')}}"></script>

    <script type="text/javascript" src="{{url('js/lib/lobipanel/lobipanel.min.js')}}"></script>
    <script type="text/javascript" src="{{url('js/lib/match-height/jquery.matchHeight.min.js')}}"></script>

    <script>
        $(document).ready(function() {


            $('.table').footable();

            $('.panel').lobiPanel({
                sortable: true
            });
            $('.panel').on('dragged.lobiPanel', function(ev, lobiPanel){
                $('.dahsboard-column').matchHeight();
            });


            $(window).resize(function(){
                drawChart();
                setTimeout(function(){
                }, 1000);
            });
        });
    </script>
    <script src="{{url('js/app.js')}}"></script>
</div>
</body>

</html>


