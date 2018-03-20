<li class="@if(isset($patient_menu_item_active)) {{ 'active '}} @endif">
    <a href="{{ route('ris.patient.show') }}">بيانات المرضى</a>
</li>
@if($user_role == "Registration")
<li class="@if(isset($index_menu_item_active)) {{ 'active '}} @endif">
    <a href="{{ route('ris.patient') }}">
        تسجيل المرضى
    </a>
</li>
@else
<li class="@if(isset($patients_proc_menu_item_active)) {{ 'active '}} @endif">
    <a href="{{ route('ris.patient_proc_search') }}">
    @if($user_role=='Lab')
        تحاليل المرضى
    @else
        فحوصات المرضى
    @endif
    </a>
</li>
<li class="@if(isset($index_menu_item_active)) {{ 'active '}} @endif">
    <a href="{{ route('ris.home') }}">
        @if($user_role=='Lab')
            حجز تحليل
        @else
            حجز فحص
        @endif
    </a>
</li>
@endif