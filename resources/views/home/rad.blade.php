<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">بيانات الأشعة</div>

		<div class="panel-body">
				<div class="row ">
						@if($errors->has('proc_device'))
						<div class="alert alert-danger">
							{{ $errors->first('proc_device') }}
						</div>
						@endif

						<div class="col-lg-6">

							<div class="form-group" >
								{!! Form::label('تاريخ الفحص',null,array('class'=>'required')) !!}
								{!! Form::text('procedure_date',null,array('class'=>'form-control','disabled'=>'disabled','id'=>'datepicker2','placeholder'=>'1900-01-01')) !!}
							</div>

							<div class="form-group" >
								{!! Form::label('القسم',null,array('class'=>'required')) !!}
								{!! Form::select('department',$departments,null,['id'=>'department','class'=>'form-control']) !!}
							</div>
							<div class="form-group" >
								{!! Form::label('طبيب الأشعة',null,array('class'=>'required')) !!}
								{!! Form::select('xray_doctor',$ref_doctors,null,['id'=>'xray_doctor','class'=>'form-control']) !!}
							</div>

						</div>

						<div class="col-lg-6">
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
							<div class="form-group" >
								{!! Form::label('حالة الفحص',null,array('class'=>'required')) !!}
								{!! Form::select('procedure_status',['Arriving'=>'اليوم','Schedular'=>'مجدولة'],'Arriving',['id'=>'procedure_status','class'=>'form-control']) !!}
							</div>
							<button type="button" class="btn btn-primary" onclick="addProcedure()" >إضافة الفحص</button>
						</div>
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
					<th style="text-align:center">تاريخ الفحص</th>
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
								<td> {{ $row1[2][0] }} </td>
								<td>
									<a nohref class="btn btn-danger"
									   onclick="delete_proc_device({{ $row1[1][0] }},{{ $row1[0][0] }})"><i class="fa fa-close"></i>
									</a>
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
</div>
