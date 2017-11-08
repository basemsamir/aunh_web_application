<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>AUNH_Registration</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('css/font.css')}}" >
    <link rel="stylesheet" href="{{asset('css/lato.css')}}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}" >
	   <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<!-- Date Picker -->
    <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables/datatable.css')}}">
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    		.required{
    			color: red;
    		}
        .age_style{
          width: 32% !important;
        }
    </style>
</head>
<body id="app-layout">
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
                    AUNH
                </a>
            </div>
            @yield('menu')
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <!--
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                </ul>
                -->
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->

					@if(Auth::check() || Auth::guard('admin')->check())

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    @if(Auth::check())
									{{ Auth::user()->name }}
							    @else
									{{ Auth::guard('admin')->user()->name }}
								@endif
								<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
								@if(Auth::check())
									<li><a href="{{ url('/logout') }}">
								@else
									<li><a href="{{ url('/admin/logout') }}">
								@endif
								  <i class="fa fa-btn fa-sign-out"></i>Logout</a></li>

							</ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

     <!-- JavaScripts -->
    <script src="{{asset('js/jquery.js')}}" ></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
	<!-- datepicker -->
	<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
	<script src="{{asset('plugins/datatables/datatable.js')}}"></script>

	@yield('javascript')
</body>
</html>
