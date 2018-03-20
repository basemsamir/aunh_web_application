@extends('layouts.app')
@section('content')
<div class="container" >
  <div class="row" dir="rtl">

    <div class="alert alert-warning" id="saveing_state" style="display:none" >
			<a href="#" class="close" style="float:left">&times;</a>
			<b></b>
		</div>
		@include('layouts.flash_message')

		@yield('forms')

  </div>
</div>
@endsection
