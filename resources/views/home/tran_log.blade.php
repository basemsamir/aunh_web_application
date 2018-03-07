@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row" >
      <div class="col-lg-12" style="    overflow-x: scroll;">
        <table id="log_tb" class="table table-bordered table-hover">
          <thead>
          <tr>
            <th style="text-align:center">Number</th>
            <th style="text-align:center">User ID</th>
            <th style="text-align:center">Loggable ID</th>
            <th style="text-align:center">Loggable Type</th>
            <th style="text-align:center">Action</th>
            <th style="text-align:center">Before</th>
            <th style="text-align:center">After</th>
            <th style="text-align:center">Created At</th>

          </tr>
          </thead>
          <tbody>
            @foreach($logdata as $row)
            <tr> <td> {{$row->id}} </td> <td> {{$row->user_id}} </td> <td> {{$row->loggable_id}} </td>
               <td> {{$row->loggable_type}} </td> <td> {{$row->action}} </td> <td> {{json_encode($row->before, JSON_UNESCAPED_UNICODE)}} </td>
               <td> {{json_encode($row->after, JSON_UNESCAPED_UNICODE)}} </td> <td> {{$row->created_at}} </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
    $("#log_tb").DataTable();
</script>
@stop
