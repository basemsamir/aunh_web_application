@extends('layouts.app')

@section('content')
<div class="container" >
  <div class="row">
		<div class="col-md-12" style="direction: rtl;">
        <div class="panel panel-default">
            <div class="panel-heading" > بيانات المرضي </div>
            <div class="panel-body">
                <table id="patient_search_tb" class="table table-bordered">
          				<thead >
          				<tr>
          				  <th style="text-align:center">الكود</th>
          				  <th style="text-align:center">الأسم</th>
                    <th style="text-align:center">الرقم القومي</th>
                    <th style="text-align:center">تاريخ الميلاد</th>
                    <th style="text-align:center">العنوان</th>
                    <th style="text-align:center">تاريخ الفحص</th>
                    <th style="text-align:center">أسم الجهاز</th>
                    <th style="text-align:center">نوع الفحص</th>
                    <th style="text-align:center">حالة الفحص</th>
                    <th style="text-align:center">القسم</th>
                    <th style="text-align:center">طبيب الأشعة</th>
          				  <th style="text-align:center">تحديد</th>
          				</tr>
          				</thead>
          				<tbody>

                      @foreach($orders as $order)
                      <tr>
                        <td>{{ $order->visit->patient->id }}</td>
                        <td>{{  $order->visit->patient->name }}</td>
                        <td>{{  $order->visit->patient->sin }}</td>
                        <td>{{ $order->visit->patient->birthdate}}</td>
                        <td>{{  $order->visit->patient->address }}</td>
                        <td>{{  $order->procedure_date }}</td>
                        <td>{{  $order->medical_device_proc->device_order_item->name }}</td>
                        <td>{{  $order->medical_device_proc->proc_order_item->name }}</td>
                        <td>{{  $order->procedure_status }}</td>
                        <td>{{  $order->department->name }}</td>
                        <td>{{  $order->ref_doctor->name }}</td>
                      </tr>
                      @endforeach
          				</tbody>
			          </table>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
  $(document).ready(function(){
      $("#patient_search_tb").DataTable();
  });
</script>
@stop
