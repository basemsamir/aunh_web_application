@extends('layouts.app')

@section('menu')
  @include('layouts.home.menu')
@stop

@section('content')
<div class="container" >
  <div class="row">
		<div class="col-md-12" style="direction: rtl;">
        <div class="panel panel-default">
            <div class="panel-heading" > بيانات المرضي </div>
            <div class="panel-body">
                {!! Form::open(array('id'=>'patient_form','route'=>'ris.patient_proc_search')) !!}
                  <div class="row">

                    <div class="col-lg-1">
                      <div class="form-inline">
                          <input type="submit" name="" value="بحث" class="btn btn-primary">
                      </div>
                    </div>
                    <div class="col-lg-5">
                      <div class="form-inline">
                        {!! Form::label('التاريخ',null) !!} &nbsp;&nbsp;
                        {!! Form::select('date_selection',[''=>'غير مستخدم','today'=>'اليوم','yestarday'=>'الأمس','last_week'=>'الأسبوع الماضي','date_selected'=>'تاريخ أختياري'],'',['id'=>'date_selection','class'=>'form-control']); !!}
                        <br><br>
                        {!! Form::label('الفترة من',null) !!}
                        {!! Form::text('duration_from',null,array('class'=>'form-control','id'=>'datepicker','disabled'=>'disabled','placeholder'=>'1900-01-01')) !!}
                        {!! Form::label('ألي',null) !!}
                        {!! Form::text('duration_to',null,array('class'=>'form-control','id'=>'datepicker2','disabled'=>'disabled','placeholder'=>'1900-01-01')) !!}

                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-inline">
                        {!! Form::label('أسم الجهاز',null) !!}
                        {!! Form::select('devices[]',$devices,null,['multiple'=>'multiple','class'=>'form-control']); !!}

                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-inline">
                        {!! Form::label('الكود',null) !!}
           						  {!! Form::text('pid',null,array('class'=>'form-control')) !!}
                      </div>
                      <br>
                      <div class="form-inline">
                        {!! Form::label('الأسم',null) !!}
           						  {!! Form::text('name',null,array('class'=>'form-control')) !!}

                      </div>
                    </div>
                  </div>

                {!! Form::close() !!}
                <br>
                <?php
                  if($user_role == 'Lab'){
                    $device_type='التحليل';
                    $doctor_type=$device_type;
                  }
                  else{
                    $device_type='الفحص';
                    $doctor_type='الأشعة';
                  }
                   
                ?>
                <table id="patient_search_tb" class="table table-bordered">
          				<thead >
          				<tr>
          				  <th style="text-align:center">الكود</th>
          				  <th style="text-align:center">الأسم</th>
                    <th style="text-align:center">الرقم القومي</th>
                    <th style="text-align:center">تاريخ الميلاد</th>
                    <th style="text-align:center">العنوان</th>
                    <th style="text-align:center">تاريخ {{ $device_type }}</th>
                    <th style="text-align:center">أسم الجهاز</th>
                    <th style="text-align:center">نوع {{ $device_type }}</th>
                    <th style="text-align:center">حالة {{ $device_type }}</th>
                    <th style="text-align:center">القسم</th>
                    <th style="text-align:center">طبيب {{ $doctor_type }}</th>
                    <th style="text-align:center">تعديل الحجز</th>
                    <th style="text-align:center">حجز جديد</th>
          				</tr>
          				</thead>
          				<tbody>

                      @foreach($orders as $order)
                        @if(!is_null($order->visit))
                          <tr>
                            <td>{{ 'N'.$order->visit->patient->id }}</td>
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
                            <td>
                              <a href="{{ route('ris.edit',$order->visit->id) }}" class="btn btn-info 
                                @if($order->procedure_date != \Carbon\Carbon::today()->format('Y-m-d') ) disabled @endif">
                                <i class="fa fa-edit"></i>
                              </a>
                            </td>
                            <td>
                              <a href="{{ route('ris.show',$order->visit->patient->id) }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i>
                              </a>
                            </td>
                          </tr>
                        @endif
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
      if($("#date_selection").val() == "date_selected") {
          toggleDisabledDatepicker(false);
      }
      else{
         toggleDisabledDatepicker(true);
      }
      $("#datepicker").datepicker({
        format:"yyyy-mm-dd",
        startDate: '-100y',
        todayHighlight: true
      });

      $("#datepicker2").datepicker({
        format:"yyyy-mm-dd",
        startDate: '-100y',
        todayHighlight: true
      });
      $("#patient_search_tb").DataTable({
          "searching": false,
          "bLengthChange": false,
          "columnDefs": [
            { "targets": [2,3,4,5,6,7,8,9,10,11,12], "searchable": false, "orderable": false, "visible": true }
          ]
      });

      // functions
      $("#date_selection").change(function(){

        if($(this).val()=="date_selected"){
            toggleDisabledDatepicker(false);
        }
        else{
           toggleDisabledDatepicker(true);
        }
      });
     
  });
function toggleDisabledDatepicker(disabled){
  if(!disabled){
    $("#datepicker").removeAttr('disabled');
    $("#datepicker2").removeAttr('disabled');
  }
  else{
    $("#datepicker").attr('disabled',true);
    $("#datepicker2").attr('disabled',true);
  }
 
}

</script>
@stop
