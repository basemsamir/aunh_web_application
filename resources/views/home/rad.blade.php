<div class="col-md-3">
	<div class="panel panel-default">
		<div class="panel-heading">بيانات الأشعة</div>

		<div class="panel-body">
			@if($errors->has('proc_device'))
			<div class="alert alert-danger">
				{{ $errors->first('proc_device') }}
			</div>
			@endif
			<div class="form-group">
				{!! Form::label('مكان الحجز',null) !!}
				{!! Form::select('rs_place',$rs_places_list,null,['id'=>'rs_place','class' => 'form-control']); !!}
			</div>
			<div class="form-group">
				{!! Form::label('أسم الجهاز',null,array('class'=>'required')) !!}
				{!! Form::select('device',$devices,null,['id'=>'device','class' => 'form-control']); !!}
			</div>
			<div class="form-group" >
				{!! Form::label('نوع الفحص',null,array('class'=>'required')) !!}
				{!! Form::select('procedure',$device_procedures,null,['id'=>'procedure_name','class'=>'form-control','change'=>'changeDevice']) !!}
			</div>
			<button type="button" class="btn btn-primary" onclick="addProcedure()" >إضافة</button>

		</div>

	</div>
	<div class="panel panel-default">
		<div class="panel-heading">الأشعة التي تم حجزها</div>
		<div class="panel-body">
			<table id="proc_device_tb" class="table table-bordered">
				<thead >
				<tr>
				  <th style="text-align:center">أسم الجهاز</th>
				  <th style="text-align:center">نوع الفحص</th>
				  <th style="text-align:center">الغاء</th>
				</tr>
				</thead>
				<tbody>

					@if(Session::has('proc_devices'))

					<?php $dev_procs=Session::get('proc_devices'); ?>
						@foreach($dev_procs as $row)
							@foreach($row as $row1)
							<tr id="row_{{ $row1[1][0] }}_{{ $row1[0][0] }}">
								<td> {{ $row1[1][1] }} </td>
								<td> {{ $row1[0][1] }} </td>
								<td>
									<a nohref class="btn btn-danger"
									   onclick="delete_proc_device({{ $row1[1][0] }},{{ $row1[0][0] }})"><i class="fa fa-close"></i></a>
								</td>
							</tr>
							@endforeach
						@endforeach
					@endif
				</tbody>
			</table>
		</div>

	</div>
</div>
