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
        .leftText{
            text-align:left
        }
    </style>
    @yield('chart')

</head>
<body id="app-layout">
    
    @include('layouts.partials.header')
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
