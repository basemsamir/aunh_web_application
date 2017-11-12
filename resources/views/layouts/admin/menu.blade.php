<li class="@if(isset($res_active)) {{ 'active '}} @endif"><a href="{{ url('admin/reservation_place') }}">Reservation places</a></li>
<li class="@if(isset($dep_active)) {{ 'active '}} @endif"><a href="{{ url('admin/department') }}">Departments</a></li>
<li class="@if(isset($doc_active)) {{ 'active '}} @endif"><a href="{{ url('admin/doctor') }}">Doctors</a></li>
<li class="@if(isset($dev_active)) {{ 'active '}} @endif"><a href="{{ url('admin/medical_device') }}">Medical devices</a></li>
<li class="@if(isset($proc_active)) {{ 'active '}} @endif"><a href="{{ url('admin/procedure') }}">Procedures</a></li>
<li class="@if(isset($user_active)) {{ 'active '}} @endif"><a href="{{ url('admin/user') }}">Users</a></li>
<li class="@if(isset($res_user_active)) {{ 'active '}} @endif"><a href="{{ url('admin/reservation_user') }}">Reservation place users</a></li>
<li class="@if(isset($dev_proc_active)) {{ 'active '}} @endif"><a href="{{ url('admin/device_proc') }}">Medical device procedures</a></li>
