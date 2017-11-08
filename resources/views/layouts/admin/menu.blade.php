
@if(Auth::guard('admin')->check())
<ul class="nav navbar-nav">
    <li><a href="{{ url('admin/reservation_place') }}">Reservation places</a></li>
    <li><a href="{{ url('admin/department') }}">Departments</a></li>
    <li><a href="{{ url('admin/doctor') }}">Doctors</a></li>
    <li><a href="{{ url('admin/medical_device') }}">Medical Devices</a></li>
    <li><a href="{{ url('admin/procedure') }}">Procedures</a></li>
    <li><a href="{{ url('admin/user') }}">Users</a></li>
    <li><a href="{{ url('admin/reservation_user') }}">Reservation place users</a></li>
</ul>
@endif
