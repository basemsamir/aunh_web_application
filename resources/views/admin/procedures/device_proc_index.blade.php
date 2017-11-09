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
              <div class="panel-heading" > {{ $panel_title }} </div>
              <div class="panel-body">
                  <a href="{{ url('admin/device_proc/create') }}" class="btn btn-success">إضافة بيان جديد</a>
                  <br><br>
                  <table id="res_place_tb" class="table table-bordered">
            				<thead >
            				<tr>
            				  <th style="text-align:center">م</th>
                      <th style="text-align:center">أسم الجهاز</th>
                      <th style="text-align:center">أسم الفحص</th>
                      <th style="text-align:center">حذف</th>
            				</tr>
            				</thead>
                    <tbody>
                      <?php $i=1;?>
                      @foreach($device_procs as $device_proc)

                        @foreach($device_proc->procedures as $proc)

                          <tr>
                            <td>{{  $i++ }}</td>
                            <td>{{  $device_proc->name }}</td>
                            <td>{{  $proc->name }}</td>
                            <td>
                            {!! Form::open(['url'=>"admin/device_proc/{$device_proc->id}",'method'=>'delete']) !!}
                                <input type="hidden" name="proc_id" value="{{ $proc->id }}">
                                <button type="submit" class="btn btn-danger"><i class='fa fa-close'></i>
                                </button>
                            {!! Form::close() !!}
                            </td>
                          </tr>
                        @endforeach
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
