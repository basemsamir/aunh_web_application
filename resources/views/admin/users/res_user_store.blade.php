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
                {!! Form::open(['url' => 'admin/reservation_user']) !!}
                  <div class="form-group @if($errors->has('res_id')) has-error @endif">
                    {!! Form::label('أسم مكتب الحجز') !!}
                    {!! Form::select('res_id',$reservation_places,null,array('class'=>'form-control')) !!}
                    @if($errors->has('res_id')) <span class="help-block">{{ $errors->first('res_id') }}</span> @endif
                  </div>
                  <div class="form-group @if($errors->has('user_id')) has-error @endif">
                    {!! Form::label('أسم المستخدم') !!}
                    {!! Form::select('user_id',$users,null,array('class'=>'form-control')) !!}
                    @if($errors->has('user_id')) <span class="help-block">{{ $errors->first('user_id') }}</span> @endif
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
