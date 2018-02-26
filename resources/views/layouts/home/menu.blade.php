<li class="@if(isset($patients_proc_menu_item_active)) {{ 'active '}} @endif">
    <a href="{{ route('ris.patient_proc_search') }}">Patients procedures</a>
</li>
<li class="@if(isset($patient_menu_item_active)) {{ 'active '}} @endif">
    <a href="{{ route('ris.patient_search') }}">Patients base</a>
</li>