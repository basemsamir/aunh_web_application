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
                {!! Form::model($medical_device,['url' => "admin/medical_device/{$medical_device->id}",'method'=>'patch']) !!}
                  <div class="form-group @if($errors->has('name')) has-error @endif">
                    {!! Form::label('الأسم') !!}
                    {!! Form::text('name',null,array('class'=>'form-control')) !!}
                    {!! Form::hidden('id',$medical_device->id) !!}
                    @if($errors->has('name')) <span class="help-block">{{ $errors->first('name') }}</span> @endif
                  </div>
                  <div class="form-group @if($errors->has('medical_device_category_id')) has-error @endif">
                    {!! Form::label('الفئة') !!}
                    {!! Form::select('medical_device_category_id',$categories,$medical_device->medical_device_type->category->id,array('class'=>'form-control','onchange'=>'getTypes(event)')) !!}
                    @if($errors->has('medical_device_category_id')) <span class="help-block">{{ $errors->first('medical_device_category_id') }}</span> @endif
                  </div>
                  <div class="form-group @if($errors->has('medical_device_type_id')) has-error @endif">
                    {!! Form::label('النوع') !!}
                    {!! Form::select('medical_device_type_id',$types,$medical_device->medical_device_type_id,array('id'=>'medical_device_types','class'=>'form-control')) !!}
                    @if($errors->has('medical_device_type_id')) <span class="help-block">{{ $errors->first('medical_device_type_id') }}</span> @endif
                  </div>
                  <div class="form-group @if($errors->has('location')) has-error @endif">
                    {!! Form::label('المكان') !!}
                    {!! Form::text('location',null,array('class'=>'form-control')) !!}
                    @if($errors->has('location')) <span class="help-block">{{ $errors->first('location') }}</span> @endif
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
  <script>
    function getTypes(event){

      $.ajax({
        url: "{{ route('api.medical_device_types') }}",
        type: "POST",
        data:{
          category_id: event.target.value
        },
        success:function(response){
            $("#medical_device_types").empty();
            for(i=0;i<response.types.length;i++){
              $("#medical_device_types").append("<option value="+response.types[i].id+">"+response.types[i].name+"</option>");
            }
        },
        error:function(error){
          console.log(error);
        }
      });
    }
  </script>
@stop
