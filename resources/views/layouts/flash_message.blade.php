@if(Session::has('success_message') || Session::has('failure_message'))
	@if(Session::has('success_message'))
		<div class="alert alert-success">
			<b>{{ Session::get('success_message') }} </b>
		</div>
	@else
		<div class="alert alert-danger">
			<b>{{ Session::get('failure_message') }} </b>
		</div>
	@endif
@endif