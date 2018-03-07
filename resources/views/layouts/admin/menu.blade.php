<li class="@if(isset($dev_proc_active)) {{ 'active '}} @endif"><a href="{{ url('admin/device_proc') }}">فحوصات الأجهزة الطبية</a></li>
<li class="@if(isset($res_user_active)) {{ 'active '}} @endif"><a href="{{ url('admin/reservation_user') }}">موظفي أماكن الحجز</a></li>
<li class="@if(isset($user_active)) {{ 'active '}} @endif"><a href="{{ url('admin/user') }}">المستخدمين</a></li>
<li class="@if(isset($proc_active)) {{ 'active '}} @endif"><a href="{{ url('admin/procedure') }}">الفحوصات الطبية</a></li>
<li class="@if(isset($dev_active)) {{ 'active '}} @endif"><a href="{{ url('admin/medical_device') }}">الأجهزة الطبية</a></li>
<li class="@if(isset($doc_active)) {{ 'active '}} @endif"><a href="{{ url('admin/doctor') }}">الأطباء</a></li>
<li class="@if(isset($dep_active)) {{ 'active '}} @endif"><a href="{{ url('admin/department') }}">الأقسام</a></li>
<li class="@if(isset($res_active)) {{ 'active '}} @endif"><a href="{{ url('admin/reservation_place') }}">أماكن الحجز</a></li>
