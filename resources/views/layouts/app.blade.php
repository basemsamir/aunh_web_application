<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>AUNH Registration</title>

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
    @yield('chart')

</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <!-- Branding -->
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Branding Image -->
                <a class="navbar-brand" href="
                    @if(Auth::guard('admin')->check())
                      {{ url('/admin') }}
                    @elseif(Auth::check())
                      {{ url('/') }}
                    @endif
                    ">
                    AUNH
                </a>

            </div>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->

                <ul class="nav navbar-nav">
                  @if(Auth::guard('admin')->check())
                    @include('layouts.admin.menu')
                  @elseif(Auth::check())
                    @include('layouts.home.menu')
                  @endif
                </ul>

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
                            @if(Auth::guard('admin')->check())
                            <li>
                               <a href="{{ url('/admin/wsconfig') }}">
                                 <i class="fa fa-btn fa-cogs"></i>Ws config
                               </a>
                            </li>
                            <li>
                               <a href="{{ url('error_log') }}">
                                 <i class="fa fa-btn fa-exclamation-triangle"></i> Error log
                               </a>
                            </li>
                            <li>
                               <a href="{{ url('tran_log') }}">
                                 <i class="fa fa-btn fa-book" aria-hidden="true"></i></i>Transaction log
                               </a>
                            </li>
                            @endif
                            <li>
            									<a href="@if(Auth::check()) {{ url('/logout') }} @else {{ url('/admin/logout') }} @endif">
            								            <i class="fa fa-btn fa-sign-out"></i>Logout</a>
                            </li>

          							  </ul>
                      </li>
                    @endif
                </ul>
                <!-- End of Right Side Of Navbar -->
              </div>
              <!-- End of #app-navbar-collapse -->
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
