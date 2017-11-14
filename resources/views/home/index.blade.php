@extends('layouts.app')
@section('content')
<div class="container" >
  <div class="row" dir="rtl">

    <div class="alert alert-warning" id="saveing_state" style="display:none" >
			<a href="#" class="close" style="float:left">&times;</a>
			<b></b>
		</div>
		@include('layouts.flash_message')

		@yield('forms')

  </div>
  <div class="row">
		<div class="col-md-12" style="direction: rtl;">
        <div class="panel panel-default">
            <div class="panel-heading" > بيانات المرضي </div>
            <div class="panel-body">
                <table id="patient_tb" class="table table-bordered">
          				<thead >
          				<tr>
          				  <th style="text-align:center">الكود</th>
          				  <th style="text-align:center">الأسم</th>
                    <th style="text-align:center">الرقم القومي</th>
          				  <th style="text-align:center">تحديد</th>
          				</tr>
          				</thead>
          				<tbody>

          				</tbody>
			          </table>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
$(document).ajaxStart(function(){
    $("#overlay").show();
});
$(document).ajaxComplete(function(){
    $("#overlay").hide();
});
$(document).ready(function(){
  $("#patient_form").submit(function(){
      $("#saveing_state b").text('جاري حفظ البيانات .....');
      $("#saveing_state").show();
  });
  $('#patient_tb').DataTable({
          "processing": true,
          "serverSide": true,
          "lengthMenu": [10],
          "ajax":{
                   "url": "{{ url('ajax/getPatientsToday') }}",
                   "dataType": "json",
                   "type": "POST",
                   "data":{ _token: "{{csrf_token()}}"}
                 },
          "columns": [
              { "data": "id" },
              { "data": "name" },
              { "data": "sin" },
              { "data": "options" },
          ],
          "columnDefs": [
              { "targets": [3], "searchable": false, "orderable": false, "visible": true }
          ]

      });

  var today=new Date();
  $("#device").prop("selectedIndex",0);
  $("#procedure_name").prop("selectedIndex",0);
  $("#procedure_status").prop("selectedIndex",0);

	$("#datepicker").datepicker({
		format:"yyyy-mm-dd",
		startDate: '-100y',
		endDate: '+0d'
	});

  $("#datepicker2").datepicker({
		format:"yyyy-mm-dd",
		startDate: '+0d',
    todayHighlight: true
	});
  $("#datepicker2").datepicker('setDate',today);
	$('#device').change(function(){
		if($('#device').val() != ""){
      $("#saveing_state b").text('جاري تحميل البيانات .....');
      $("#saveing_state").show();
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
      $("#saveing_state").hide();
		}
	});
  $('#year_age').keyup(function(){
      if($('#year_age').val() != ""){

          birthdate_year=today.getFullYear()-$('#year_age').val();
          $("#datepicker").val(birthdate_year+"-"+(today.getMonth()+1)+"-"+today.getDate());
      }
      else{
        $("#datepicker").val("");
      }
  });
  $('#datepicker').change(function(){
      if($('#datepicker').val() != ""){
          birthdate=new Date($('#datepicker').val());
          diffYears = today.getFullYear() - birthdate.getFullYear();
          diffMonths = today.getMonth() - birthdate.getMonth();
          diffDays = today.getDate() - birthdate.getDate();
          if(isNaN(diffDays)){
            $("#year_age").val('');
            $("#datepicker").val('');
            return;
          }
          if(diffDays < 0){
            diffMonths--;
            diffDays+=30;
          }
          if(isNaN(diffMonths)){
            $("#age").val('');
            $("#datepicker").val('');
            return;
          }
          if(diffMonths < 0){
            diffMonths+=12;
            diffYears--;
          }
          $("#year_age").val(diffYears);
      }
      else{
        $("#year_age").val("");
      }
  });

  $("#procedure_status").change(function(){
    if($(this).val()!="Arriving"){
      $("#datepicker2").removeAttr('disabled');
      var current_date = $('#datepicker2').datepicker('getDate');
      current_date.setDate(current_date.getDate()+1);
      $("#datepicker2").datepicker('setDate',current_date);

    }
    else{
        $("#datepicker2").attr('disabled','disabled');
        $("#datepicker2").datepicker('setDate',today);
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
// Function limits the size of SIN field
function isForteen(event){
	if(event.target.value.length >= 14)
		return false;
	return true;
}
var proc_device=Array();
function addProcedure(){

  $("#saveing_state b").text('جاري إضافة الفحص .....');
  $("#saveing_state").show();
	var row_id="row_"+$("#device option:selected").val()+"_"+$("#procedure_name option:selected").val();
	var id=$("#device option:selected").val()+"_"+$("#procedure_name option:selected").val();
	var flag=false;
	$("#proc_device_tb tr").each(function() {
	    if(this.id == row_id)
			flag=true;
	});
	if(!flag){
    if($("#datepicker2").val() == "")
    {
       today=new Date();
       if($("#procedure_status").val() == "Arriving"){

         $("#datepicker2").datepicker('setDate',today);
       }
       else{
         today.setDate(today.getDate()+1);
         $("#datepicker2").datepicker('setDate',today);
       }
    }
		var url = "{{ url('ajax/postProcDevice') }}";

		$.ajax({
			type: "POST",
			url: url,
			data:{
        proc_device:$("#device").val()+"_"+$("#procedure_name").val(),
        proc_date:$("#datepicker2").val(),
        proc_status:$("#procedure_status").val(),
        proc_dep:$("#department").val(),
        proc_doctor:$("#xray_doctor").val(),
        _token:"<?php echo csrf_token(); ?>"
      },
			success: function (data) {
				$("#proc_device_tb").append('<tr id='+row_id+'>'+
											'<td>'+$("#device option:selected").text()+'</td>'+
											'<td>'+$("#procedure_name option:selected").text()+'</td>'+
                      '<td>'+$("#datepicker2").val()+'</td>'+
											'<td>'+'<a nohref class="btn btn-danger" onclick="delete_proc_device('+$("#device option:selected").val()+","+$("#procedure_name option:selected").val()+')"><i class="fa fa-close"></i></a>'+'</td>'+
										   '</tr>');
			},
			error: function (data) {
				alert("Error");
			}
		});

	}
  $("#saveing_state").hide();
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

</script>
@stop
