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
                {!! Form::open(['url' => 'admin/device_proc']) !!}
                  <div class="form-group @if($errors->has('dev_id')) has-error @endif">
                    {!! Form::label('أسم الجهاز') !!}
                    {!! Form::select('dev_id',$devices,null,array('class'=>'form-control')) !!}
                    @if($errors->has('dev_id')) <span class="help-block">{{ $errors->first('dev_id') }}</span> @endif
                  </div>
                  <div class="form-group @if($errors->has('proc_id')) has-error @endif">
                    {!! Form::label('أسم الفحص') !!}
                    {!! Form::select('proc_id[]',$procs,null,array('class'=>'form-control','multiple'=>'multiple')) !!}
                    @if($errors->has('proc_id')) <span class="help-block">{{ $errors->first('proc_id') }}</span> @endif
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
</div>
@endsection
@section('javascript')

@stop
