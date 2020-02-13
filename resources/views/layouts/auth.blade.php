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


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>


    <![endif]-->
    <link rel="stylesheet" href="{{url('css/separate/pages/login.min.css')}}">
    <link rel="stylesheet" href="{{url('css/lib/font-awesome/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('css/lib/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('css/main.css')}}">
</head>
<body>

<style>
    body{
        background-color: #0241b6;
    }

    .help-block {
        color:red;
        text-align: center;
    }

 
    }
</style>

<div class="page-center">
    <div class="page-center-in">
        <div class="container-fluid">

            @yield('content')

        </div>
    </div>
</div><!--.page-center-->


<script src="{{url('js/lib/jquery/jquery.min.js')}}"></script>
<script src="{{url('js/lib/tether/tether.min.js')}}"></script>
<script src="{{url('js/lib/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{url('js/plugins.js')}}"></script>
<script type="text/javascript" src="{{url('js/lib/match-height/jquery.matchHeight.min.js')}}"></script>
<script>
    $(function() {
        $('.page-center').matchHeight({
            target: $('html')
        });

        $(window).resize(function(){
            setTimeout(function(){
                $('.page-center').matchHeight({ remove: true });
                $('.page-center').matchHeight({
                    target: $('html')
                });
            },100);
        });
    });
</script>
<script src="{{url('js/app.js')}}"></script>
</body>

</html>
