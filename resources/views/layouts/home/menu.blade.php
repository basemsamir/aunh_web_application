@if(Auth::check())
<ul class="nav navbar-nav">
    <li><a href="{{ url('patients') }}">Patients</a></li>
</ul>
@endif
