@if(Session::has('pid'))
    <div class="alert alert-success">
        <a href="#" class="close" style="float:left" data-dismiss="alert" aria-label="close">&times;</a>
        <b> كود المريض : {{ Session::get('pid') }} </b>
    </div>
@endif