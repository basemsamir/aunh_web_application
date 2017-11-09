<div class="navbar-header">
    <!-- Collapsed Hamburger -->
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
        <span class="sr-only">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <!-- Branding Image -->
    <a class="navbar-brand" href="{{ url('/admin') }}">
        AUNH
    </a>

    <ul class="nav navbar-nav">
        <li><a href="{{ url('admin/reservation_place') }}">Reservation places</a></li>
        <li><a href="{{ url('admin/department') }}">Departments</a></li>
        <li><a href="{{ url('admin/doctor') }}">Doctors</a></li>
        <li><a href="{{ url('admin/medical_device') }}">Medical devices</a></li>
        <li><a href="{{ url('admin/procedure') }}">Procedures</a></li>
        <li><a href="{{ url('admin/user') }}">Users</a></li>
        <li><a href="{{ url('admin/reservation_user') }}">Reservation place users</a></li>
        <li><a href="{{ url('admin/device_proc') }}">Medical device procedures</a></li>
    </ul>
</div>
