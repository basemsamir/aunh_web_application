@extends('layouts.app')

@section('menu')
  @include('layouts.admin.menu')
@stop

@section('content')
<div class="container">
    <div class="row" dir="rtl">
      <div class="col-md-12" style="direction: rtl;">
          @include('layouts.flash_message')
          <div class="panel panel-default">
              <div class="panel-heading" > بيانات الأقسام </div>
              <div class="panel-body">
                  <a href="{{ url('admin/department/create') }}" class="btn btn-success">إضافة بيان جديد</a>
                  <br><br>
                  <table id="res_place_tb" class="table table-bordered">
            				<thead >
            				<tr>
            				  <th style="text-align:center">م</th>
                      <th style="text-align:center">الأسم</th>
            				  <th style="text-align:center">تعديل</th>
                      <th style="text-align:center">حذف</th>
            				</tr>
            				</thead>
            				<tbody>
                      @foreach($deps as $dep)
                      <tr>
                        <td>{{ $dep->id }}</td>
                        <td>{{  $dep->name }}</td>
                        <td><a href='{{ url("admin/department/{$dep->id}/edit") }}' title='تعديل'  class='btn btn-info'  >
                              <i class='fa fa-edit'></i></a>
                        </td>
                        <td>
                        {!! Form::open(['url'=>"admin/department/{$dep->id}",'method'=>'delete']) !!}
                            <button type="submit" class="btn btn-danger"><i class='fa fa-close'></i>
                            </button>
                        {!! Form::close() !!}
                        </td>
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
    $("#res_place_tb").DataTable();
  });
</script>
@stop
