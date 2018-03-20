@extends('home.index_registration')
@section('forms')
{!! Form::open(array('id'=>'patient_form','route'=>'ris.patient.store')) !!}
<div class="col-md-12">
	<div class="panel panel-default" >
		<div class="panel-heading">بيانات المريض</div>

		<div class="panel-body " >
			<div class="row ">

				<div class="col-md-6">
					 <div class="form-group @if($errors->has('birthdate')) {{ 'has-error'}} @endif">
						 {!! Form::label('تاريخ الميلاد',null,array('class'=>'required')) !!}
						 {!! Form::text('birthdate',null,array('class'=>'form-control','id'=>'datepicker','placeholder'=>'1900-01-01')) !!}
						 @if ($errors->has('birthdate'))<span class="help-block">{{ $errors->first('birthdate') }}</span>@endif
					 </div>
					 <div class="form-group">
						 {!! Form::label('السن',null,array('class'=>'required')) !!}
						 {!! Form::text('year_age',null,array('placeholder'=>'السن','class'=>'form-control','id'=>'year_age','onkeypress'=>'return isNumber(event)')) !!}
						 @if($errors->has('year_age'))<span class="help-block">{{$errors->first('year_age')}}</span>@endif
					 </div>
				   <div class="form-group @if($errors->has('address')) {{ 'has-error'}} @endif">
					 {!! Form::label('العنوان',null) !!}
					 {!! Form::text('address',null,array('class'=>'form-control','id'=>'address','placeholder'=>'العنوان')) !!}
					  @if ($errors->has('address'))<span class="help-block">{{ $errors->first('address') }}</span>@endif
				   </div>
				   <div class="form-group @if($errors->has('nationality')) {{ 'has-error'}} @endif">
					 {!! Form::label('الجنسية',null) !!}
					 {!! Form::text('nationality',null,array('class'=>'form-control','id'=>'nationality','placeholder'=>'الجنسية','v-model'=>'message')) !!}
					  @if ($errors->has('nationality'))<span class="help-block">{{ $errors->first('nationality') }}</span>@endif
				   </div>

				</div>
				<!-- col-md-6 -->
				<div class="col-md-6">
				   @include('layouts.patient_id_flash_msg')
				   <div class="form-group @if($errors->has('name')) {{ 'has-error'}} @endif">
					 {!! Form::label('الأسم',null,array('class'=>'required')) !!}
					 {!! Form::text('name',null,array('class'=>'form-control','id'=>'name','placeholder'=>'الأسم')) !!}
					 @if ($errors->has('name'))<span class="help-block">{{ $errors->first('name') }}</span>@endif
				   </div>
				   <div class="form-group @if($errors->has('sin')) {{ 'has-error'}} @endif">
					 {!! Form::label('الرقم القومي',null) !!}
					 {!! Form::text('sin',null,array('class'=>'form-control','id'=>'sin','placeholder'=>'الرقم القومي','onkeypress'=>'return isNumber(event)&&isForteen(event)')) !!}
					  @if ($errors->has('sin'))<span class="help-block">{{ $errors->first('sin') }}</span>@endif
				   </div>
				   <div class="form-group @if($errors->has('gender')) {{ 'has-error'}} @endif">
					 {!! Form::label('النوع',null,array('class'=>'required')) !!}
					 {!! Form::select('gender',[''=>'أختر النوع','M' => 'ذكر', 'F' => 'أنثى'], '',['class'=>'form-control','id'=>'gender_select']); !!}
					  @if ($errors->has('gender'))<span class="help-block">{{ $errors->first('gender') }}</span>@endif
				   </div>
					 <div class="form-group @if($errors->has('phone_num')) {{ 'has-error'}} @endif">
					 {!! Form::label('رقم التليفون',null) !!}
					 {!! Form::text('phone_num',null,array('class'=>'form-control','id'=>'phone_num','placeholder'=>'رقم التليفون','onkeypress'=>'return isNumber(event)')) !!}
						@if ($errors->has('phone_num'))<span class="help-block">{{ $errors->first('phone_num') }}</span>@endif
					 </div>
				   <button type="submit" class="btn btn-primary" >تسجيل</button>
				   <a class="btn btn-success" onclick="window.location='{{ url('/') }}'" >جديد</a>
				</div>
				<!-- col-md-6 -->

			</div>
			<!-- row -->
		</div>
		<!-- panel-body -->
	</div>
</div>
{!! Form::close() !!}
@stop
@section('javascript')
<script>
$(document).ready(function(){
	$("#patient_form").submit(function(){
		$("#saveing_state b").text('جاري حفظ البيانات .....');
		$("#saveing_state").show();
	});

	$("#datepicker").datepicker({
		format:"yyyy-mm-dd",
		startDate: '-100y',
		endDate: '+0d'
	});

	$("#datepicker2").datepicker({
		format:"yyyy-mm-dd",
		startDate: '+0d',
		todayHighlight: true
	});
	var today=new Date();
	$("#datepicker2").datepicker('setDate',today);

	$('#year_age').keyup(function(){
		if($('#year_age').val() != ""){

			birthdate_year=today.getFullYear()-$('#year_age').val();
			$("#datepicker").val(birthdate_year+"-"+(today.getMonth()+1)+"-"+today.getDate());
		}
		else{
			$("#datepicker").val("");
		}
	});
	$('#datepicker').change(function(){
		if($('#datepicker').val() != ""){
			birthdate=new Date($('#datepicker').val());
			diffYears = today.getFullYear() - birthdate.getFullYear();
			diffMonths = today.getMonth() - birthdate.getMonth();
			diffDays = today.getDate() - birthdate.getDate();
			if(isNaN(diffDays)){
				$("#year_age").val('');
				$("#datepicker").val('');
				return;
			}
			if(diffDays < 0){
				diffMonths--;
				diffDays+=30;
			}
			if(isNaN(diffMonths)){
				$("#age").val('');
				$("#datepicker").val('');
				return;
			}
			if(diffMonths < 0){
				diffMonths+=12;
				diffYears--;
			}
			$("#year_age").val(diffYears);
		}
		else{
			$("#year_age").val("");
		}
	});

	$('#sin').on('change paste',function(){
		$("#sin").parent().removeClass('has-error');
		if($("#sin").next().length > 0)
			$("#sin").next().remove();
		$("#datepicker").val('');
		$("#datepicker").change();
		if( $("#sin").val() != 0)
			calculateBOD($(this).val());
	});
});

// Function accepts numbers only
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
// Function limits the size of SIN field
function isForteen(event){
	if(event.target.value.length >= 14)
		return false;
	return true;
}
// Function calculates the age field
function calculateBOD(sid){
	var sid_string=sid;
	var prifx_year="";
	if(sid_string[0] == 2)
		prifx_year="19";
	else if(sid_string[0] == 3)
		prifx_year="20";
	else{
    $("#sin").parent().addClass('has-error');
		$("#sin").after('<span class="help-block">الرقم القومي غير صحيح</span>');
		return;
	}
	var year=prifx_year+""+sid_string[1]+""+sid_string[2];
	var month=sid_string[3]+""+sid_string[4];
	var day=sid_string[5]+""+sid_string[6];
	var date=year+"-"+month+"-"+day;

	var birthdate = new Date(date);
	var today = new Date();
	var diffYears = today.getFullYear() - birthdate.getFullYear();
	var diffMonths = today.getMonth() - birthdate.getMonth();
	var diffDays = today.getDate() - birthdate.getDate();
	if(diffMonths < 0){
		diffMonths+=12;
		diffYears--;
	}
	if(diffDays < 0){
		diffMonths--;
		diffDays+=30;
	}
	if( isNaN(diffYears) || diffYears < 0 || isNaN(diffMonths) || isNaN(diffDays) ){
		$("#sin").parent().addClass('has-error');
		$("#sin").after('<span class="help-block">الرقم القومي غير صحيح</span>');
		return;
	}
	else{
		$("#datepicker").val(year+'-'+month+'-'+day);
    	$('#datepicker').change();
	}
}
</script>
@stop
