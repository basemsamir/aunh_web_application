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
                {!! Form::open(['url' => 'admin/wsconfig']) !!}
                  <div class="form-group @if($errors->has('url')) has-error @endif">
                    {!! Form::label('Url') !!}
                    {!! Form::url('url',null,array('class'=>'form-control')) !!}
                    @if($errors->has('url')) <span class="help-block">{{ $errors->first('url') }}</span> @endif
                  </div>
                  <div class="form-group @if($errors->has('sending_app')) has-error @endif">
                    {!! Form::label('Sending Application') !!}
                    {!! Form::text('sending_app',null,array('class'=>'form-control')) !!}
                    @if($errors->has('sending_app')) <span class="help-block">{{ $errors->first('sending_app') }}</span> @endif
                  </div>
                  <div class="form-group @if($errors->has('sending_fac')) has-error @endif">
                    {!! Form::label('Sending Facility') !!}
                    {!! Form::text('sending_fac',null,array('class'=>'form-control')) !!}
                    @if($errors->has('sending_fac')) <span class="help-block">{{ $errors->first('sending_fac') }}</span> @endif
                  </div>
                  <div class="form-group @if($errors->has('receiving_app')) has-error @endif">
                    {!! Form::label('Receiving Application') !!}
                    {!! Form::text('receiving_app',null,array('class'=>'form-control')) !!}
                    @if($errors->has('receiving_app')) <span class="help-block">{{ $errors->first('receiving_app') }}</span> @endif
                  </div>
                  <div class="form-group @if($errors->has('receiving_fac')) has-error @endif">
                    {!! Form::label('Receiving Facility') !!}
                    {!! Form::text('receiving_fac',null,array('class'=>'form-control')) !!}
                    @if($errors->has('receiving_fac')) <span class="help-block">{{ $errors->first('receiving_fac') }}</span> @endif
                  </div>
                  <hr>
                  <div class="form-group">
                    <input type="submit" name="" value="تسجيل" class="btn btn-primary">
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
