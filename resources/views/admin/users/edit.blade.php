@extends('layouts.app')

@section('menu')
  @include('layouts.admin.menu')
@stop

@section('content')
<div class="container">
    <div class="row" dir="rtl">
      <div class="col-md-12" style="direction: rtl;">
          <div class="panel panel-default">
              <div class="panel-heading" > {{ $panel_title }} </div>
              <div class="panel-body">
                {!! Form::model($user,['url' => "admin/user/{$user->id}",'method'=>'patch']) !!}
                  <div class="form-group @if($errors->has('name')) has-error @endif">
                    {!! Form::label('الأسم') !!}
                    {!! Form::text('name',null,array('class'=>'form-control')) !!}
                    @if($errors->has('name')) <span class="help-block">{{ $errors->first('name') }}</span> @endif
                  </div>
                  <div class="form-group @if($errors->has('email')) has-error @endif">
                    {!! Form::label('البريد الألكتروني') !!}
                    {!! Form::email('email',null,array('class'=>'form-control')) !!}
                    @if($errors->has('email')) <span class="help-block">{{ $errors->first('email') }}</span> @endif
                  </div>
                  <div class="form-group @if($errors->has('role_id')) has-error @endif">
                    {!! Form::label('الدور') !!}
                    {!! Form::select('role_id',$roles,$user->role_id,array('class'=>'form-control')) !!}
                    @if($errors->has('role_id')) <span class="help-block">{{ $errors->first('role_id') }}</span> @endif
                  </div>
                  <div class="form-group @if($errors->has('password')) has-error @endif">
                    {!! Form::label('كلمة المرور') !!}
                    {!! Form::password('password',['class'=>'form-control']) !!}
                    @if($errors->has('password')) <span class="help-block">{{ $errors->first('password') }}</span> @endif
                  </div>
                  <div class="form-group">
                    {!! Form::label('تأكيد كلمة المرور') !!}
                    {!! Form::password('password_confirmation',['class'=>'form-control']) !!}
                  </div>
                  <hr>
                  <div class="form-group">
                    <input type="submit" name="" value="تعديل" class="btn btn-primary">
                  </div>
                {!! Form::close() !!}
              </div>
          </div>
      </div>
    </div>
</div>
@endsection
@section('javascript')

@stop
