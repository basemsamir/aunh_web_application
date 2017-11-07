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
                {!! Form::model($proc,['url' => "admin/procedure/{$proc->id}",'method'=>'patch']) !!}
                  <div class="form-group @if($errors->has('name')) has-error @endif">
                    {!! Form::label('الأسم') !!}
                    {!! Form::text('name',null,array('class'=>'form-control')) !!}
                    @if($errors->has('name')) <span class="help-block">{{ $errors->first('name') }}</span> @endif
                  </div>
                  <div class="form-group @if($errors->has('type_id')) has-error @endif">
                    {!! Form::label('نوع الفحص') !!}
                    {!! Form::select('type_id',$proceduretypes,$proc->type_id,array('class'=>'form-control')) !!}
                    @if($errors->has('type_id')) <span class="help-block">{{ $errors->first('type_id') }}</span> @endif
                  </div>
                  <div class="form-group @if($errors->has('proc_ris_id')) has-error @endif">
                    {!! Form::label('كود ال RIS') !!}
                    {!! Form::text('proc_ris_id',null,array('class'=>'form-control')) !!}
                    @if($errors->has('proc_ris_id')) <span class="help-block">{{ $errors->first('proc_ris_id') }}</span> @endif
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
