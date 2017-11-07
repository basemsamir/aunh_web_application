<!-- Branding Image -->
<a class="navbar-brand" href="{{ url('/') }}">
    AUNH
</a>
@if(Auth::check())
<a class="navbar-brand" href="{{ url('patients') }}">
    Patients
</a>
@endif

