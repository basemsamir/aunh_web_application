@extends('layouts.app')

@section('content')
<div class="container" >
  <div class="row">
		<div class="col-md-12" style="direction: rtl;">
        <div class="panel panel-default">
            <div class="panel-heading" > بيانات المرضي </div>
            <div class="panel-body">
                {!! Form::open(array('id'=>'patient_form','route'=>'ris.post_search')) !!}
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
                        <td>{{ $order->id }}</td>
                        <td>{{  $order->name }}</td>
                        <td>{{  $order->sin }}</td>
                        <td>{{ $order->birthdate}}</td>
                        <td>{{  $order->address }}</td>
                        <td>{{  $order->procedure_date }}</td>
                        <td>{{  $order->dev_name }}</td>
                        <td>{{  $order->proc_name }}</td>
                        <td>{{  $order->procedure_status }}</td>
                        <td>{{  isset($order->department->name)?$order->department->name:"" }}</td>
                        <td>{{   isset($order->ref_doctor->name)?$order->ref_doctor->name:"" }}</td>
                        <td><a href='{{ route("ris.edit",$order->vid) }}' title='تحديد'  class='btn btn-info'  >
            												   <i class='fa fa-edit'></i></a></td>
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
      });

      // functions
      $("#date_selection").change(function(){

        if($(this).val()=="date_selected"){
            $("#datepicker").removeAttr('disabled');
            $("#datepicker2").removeAttr('disabled');
        }
        else{
          $("#datepicker").attr('disabled',true);
          $("#datepicker2").attr('disabled',true);
        }
      });
  });

</script>
@stop
