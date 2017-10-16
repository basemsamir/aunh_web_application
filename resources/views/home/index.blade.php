@extends('layouts.app')

@section('content')
<div class="container" id="#d">
    <div class="row" dir="rtl">
		@include('layouts.flash_message')
		<div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading" > بيانات المرضي </div>
                <div class="panel-body">
                    <table id="patient_tb" class="table table-bordered">
						<thead >
						<tr>
						  <th style="text-align:center">الكود</th>
						  <th style="text-align:center">الأسم</th>
						  <th style="text-align:center">تحديد</th>
						</tr>
						</thead>
						<tbody>
							@if(isset($patients))
								@foreach($patients as $patient)
									<tr>
										<td>{{ $patient->id }}</td>
										<td>{{ $patient->name }}</td>
										<td align="center"><a nohref class="btn btn-info" 
											   onclick=""><i class="fa fa-edit"></i></a> </td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
                </div>
            </div>
        </div>
		@yield('forms')
		
    </div>
</div>
@endsection
@section('javascript')
<script>
$(document).ready(function(){

	$("#datepicker").datepicker({
		format:"yyyy-mm-dd",
		startDate: '-100y',
		endDate: '+0d'
	});
	$('#device').change(function(){
		if($('#device').val() != ""){
			var url = "{{ url('ajax/getProcedures') }}";
			
			$.ajax({
				type: "POST",
				url: url,
				data:{id:$("#device").val()},
				success: function (data) {
					$("#procedure_name option").remove();
					if(data['success']=='true'){
						for(i=0;i<data['procedures'].length;i++)
						{
							$('#procedure_name').append($('<option>', {value:data['procedures'][i].id, text:data['procedures'][i].name}));
						}
					}
				},
				error: function (data) {
					alert("Error");
				}
			});
		
		}
	});
	
});

// Function accepts numbers only
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
var proc_device=Array();
function addProcedure(){
	
	var row_id="row_"+$("#device option:selected").val()+"_"+$("#procedure_name option:selected").val();
	var id=$("#device option:selected").val()+"_"+$("#procedure_name option:selected").val();
	var flag=false;
	$("#proc_device_tb tr").each(function() {
	    if(this.id == row_id)
			flag=true;
	});
	if(!flag){
		var url = "{{ url('ajax/postProcDevice') }}";

		$.ajax({
			type: "POST",
			url: url,
			data:{proc_device:$("#device").val()+"_"+$("#procedure_name").val(),_token:"<?php echo csrf_token(); ?>" },
			success: function (data) {
				$("#proc_device_tb").append('<tr id='+row_id+'>'+
											'<td>'+$("#device option:selected").text()+'</td>'+
											'<td>'+$("#procedure_name option:selected").text()+'</td>'+
											'<td>'+'<a nohref class="btn btn-danger" onclick="delete_proc_device('+$("#device option:selected").val()+","+$("#procedure_name option:selected").val()+')"><i class="fa fa-close"></i></a>'+'</td>'+
										   '</tr>');
			},
			error: function (data) {
				alert("Error");
			}
		});
		
	}
}
function delete_proc_device(device_id,proc_id){
	
	var url = "{{ url('ajax/deleteProcDevice') }}";

	$.ajax({
		type: "POST",
		url: url,
		data:{proc_device:device_id+"_"+proc_id,_token:"<?php echo csrf_token(); ?>" },
		success: function (data) {
			$('#proc_device_tb #row_'+device_id+'_'+proc_id).remove();
		},
		error: function (data) {
			alert("Error");
		}
	});
}
function submitForm(){
	//$("#proc_device").val(proc_device);
}
</script>
@stop
