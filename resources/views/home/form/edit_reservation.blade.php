@extends('home.index')
@section('forms')
{!! Form::model($patient,['method'=>'PATCH','id'=>'patient_form','route'=>['ris.update',$visit->id]]) !!}
@include('home.rad')
<div class="col-md-5">
	<div class="panel panel-default" >
		<div class="panel-heading">بيانات المريض</div>

		<div class="panel-body">
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
				   <div class="form-group">
					 {!! Form::label('الكود',null) !!}
					 {!! Form::text('id',null,array('class'=>'form-control','disabled','id'=>'pid','placeholder'=>'الكود','onkeypress'=>'return isNumber(event)')) !!}
					 @if ($errors->has('id'))<span class="help-block">{{ $errors->first('id') }}</span>@endif
				  </div>
				   <div class="form-group @if($errors->has('name')) {{ 'has-error'}} @endif">
					 {!! Form::label('الأسم',null,array('class'=>'required')) !!}
					 {!! Form::text('name',null,array('class'=>'form-control','id'=>'name','placeholder'=>'الأسم')) !!}
					 @if ($errors->has('name'))<span class="help-block">{{ $errors->first('name') }}</span>@endif
				   </div>
				   <div class="form-group @if($errors->has('sin')) {{ 'has-error'}} @endif">
					 {!! Form::label('الرقم القومي',null) !!}
					 {!! Form::text('sin',null,array('class'=>'form-control','id'=>'sin','placeholder'=>'الرقم القومي','onkeypress'=>'return isNumber(event)&&isForteen()')) !!}
					  @if ($errors->has('sin'))<span class="help-block">{{ $errors->first('sin') }}</span>@endif
				   </div>
				   <div class="form-group @if($errors->has('gender')) {{ 'has-error'}} @endif">
					 {!! Form::label('النوع',null,array('class'=>'required')) !!}
					 {!! Form::select('gender',[''=>'أختر النوع','M' => 'ذكر', 'F' => 'أنثى'], $patient->gender,['class'=>'form-control','id'=>'gender_select']); !!}
					  @if ($errors->has('gender'))<span class="help-block">{{ $errors->first('gender') }}</span>@endif
				   </div>
					 <div class="form-group @if($errors->has('phone_number')) {{ 'has-error'}} @endif">
					 {!! Form::label('رقم التليفون',null) !!}
					 {!! Form::text('phone_number',null,array('class'=>'form-control','id'=>'phone_number','placeholder'=>'رقم التليفون','onkeypress'=>'return isNumber(event)')) !!}
						@if ($errors->has('phone_number'))<span class="help-block">{{ $errors->first('phone_number') }}</span>@endif
					 </div>
				   <button type="submit" class="btn btn-primary" onclick="submitForm()">تعديل</button>

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
