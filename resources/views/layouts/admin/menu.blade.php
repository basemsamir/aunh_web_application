<!-- Branding Image -->
<a class="navbar-brand" href="{{ url('/admin') }}">
    AUNH
</a>
@if(Auth::guard('admin')->check())
<a class="navbar-brand" href="{{ url('admin/reservation_place') }}">
    Reservation places
</a>
<a class="navbar-brand" href="{{ url('admin/department') }}">
    Departments
</a>
<a class="navbar-brand" href="{{ url('admin/doctor') }}">
    Doctors
</a>
<a class="navbar-brand" href="{{ url('admin/medical_device') }}">
    Medical Devices
</a>
<a class="navbar-brand" href="{{ url('admin/procedure') }}">
    Procedures
</a>
<a class="navbar-brand" href="{{ url('admin/user') }}">
    Users
</a>
@endif
