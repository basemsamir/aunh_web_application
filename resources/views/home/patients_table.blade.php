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
                {!! Form::open(array('id'=>'patient_form','route'=>'ris.patient_search')) !!}
                  <div class="row">

                    <div class="col-lg-3">
                      <div class="form-inline">
                          <input type="submit" name="" value="بحث" class="btn btn-primary">
                      </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-inline">
                          {!! Form::label('الرقم القومي',null) !!}
                          {!! Form::text('sin',null,array('class'=>'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-lg-3">
                       <div class="form-inline">
                        {!! Form::label('الأسم',null) !!}
           						  {!! Form::text('name',null,array('class'=>'form-control')) !!}

                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-inline">
                        {!! Form::label('الكود',null) !!}
           						  {!! Form::text('pid',null,array('class'=>'form-control')) !!}
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
                    <th style="text-align:center">السن</th>
                    <th style="text-align:center">العنوان</th>
                    <th style="text-align:center">رقم التليفون</th>
                    <th style="text-align:center">الجنسية</th>
                    <th style="text-align:center">حجز</th>
          				</tr>
          				</thead>
          				<tbody>
                      @if(isset($patients))
                        @foreach($patients as $patient)
                            <tr>
                              <td>{{ 'N'.$patient->id }}</td>
                              <td>{{  $patient->name }}</td>
                              <td>{{  $patient->sin }}</td>
                              <td>{{  $patient->birthdate}}</td>
                              <td>{{  calculateAge($patient->birthdate)}}</td>
                              <td>{{  $patient->address }}</td>
                              <td>{{  $patient->phone_num }}</td>
                              <td>{{  $patient->nationality }}</td>
                              <td align="center">
                                <a href="{{ route('ris.show',$patient->id) }}" class="btn btn-success">
                                  <i class="fa fa-plus"></i>
                                </a>
                              </td>
                              
                            </tr>
                        @endforeach
                      @endif
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
    $("#patient_search_tb").DataTable({
          "searching": false,
          "bLengthChange": false,
          "columnDefs": [
            { "targets": [2,3,4,5,6,7,8], "searchable": false, "orderable": false, "visible": true }
          ]
    });
</script>
@stop
