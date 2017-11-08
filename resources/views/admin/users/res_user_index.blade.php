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
                  <a href="{{ url('admin/reservation_user/create') }}" class="btn btn-success">إضافة بيان جديد</a>
                  <br><br>
                  <table id="res_place_tb" class="table table-bordered">
            				<thead >
            				<tr>
            				  <th style="text-align:center">م</th>
                      <th style="text-align:center">أسم المستخدم</th>
                      <th style="text-align:center">أسم مكتب الحجز</th>
                      <th style="text-align:center">حذف</th>
            				</tr>
            				</thead>
            				<tbody>
                      <?php $i=1;?>
                      @foreach($res_users as $res_user)

                        @foreach($res_user->users as $user)

                          <tr>
                            <td>{{  $i++ }}</td>
                            <td>{{  $user->name }}</td>
                            <td>{{  $res_user->name }}</td>
                            <td>
                            {!! Form::open(['url'=>"admin/reservation_user/{$res_user->id}",'method'=>'delete']) !!}
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
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
