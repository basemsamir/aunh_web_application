@if(Session::has('success_message') || Session::has('failure_message'))
	@if(Session::has('success_message'))
		<div class="alert alert-success">
			<a href="#" class="close" style="float:left" data-dismiss="alert" aria-label="close">&times;</a>
			<b>{{ Session::get('success_message') }} </b> <br>
		</div>
	@else
		<div class="alert alert-danger">
			<a href="#" class="close" style="float:left" data-dismiss="alert" aria-label="close">&times;</a>
			<b>{{ Session::get('failure_message') }} </b>
		</div>
	@endif
@endif
