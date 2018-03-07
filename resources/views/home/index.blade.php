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
            <div class="panel-heading" >بيانات المرضي</div>
            <div class="panel-body">
                <table id="patient_tb" class="table table-bordered">
          				<thead >
          				<tr>
          				  <th style="text-align:center">الكود</th>
          				  <th style="text-align:center">الأسم</th>
                    <th style="text-align:center">الرقم القومي</th>
                    <th style="text-align:center">العنوان</th>
                    <th style="text-align:center">تاريخ  اخر حجز</th>
                    <th style="text-align:center">
                      @if($user_role == "Xray")
                        تاريخ أخر فحص تم حجزه
                      @else
                        تاريخ اخر تحليل تم حجزه
                      @endif    
                    </th>
          				  <th style="text-align:center">عمل حجز جديد</th>
                    <th style="text-align:center">تعديل الحجز</th>
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
var show_saving_state=false;
$(document).ajaxStart(function(){
    if(show_saving_state){
      $("#saveing_state b").text('جاري تحميل البيانات .....');
      $("#saveing_state").show();
    }
});
$(document).ajaxComplete(function(){
  if(show_saving_state){
    show_saving_state=false;
    $("#saveing_state").hide();
  }
});
$(document).ready(function(){
  $("#patient_form").submit(function(){
      $("#saveing_state b").text('جاري حفظ البيانات .....');
      $("#saveing_state").show();
  });
  $('#patient_tb').DataTable({
      "processing": true,
      "serverSide": true,
      "deferRender": true,
      "lengthMenu": [10],
      "ajax":{
        "url": "{{ url('ajax/getPatientsToday') }}",
        "dataType": "json",
        "type": "POST"
      },
      "columns": [
          { "data": "id" },
          { "data": "name" },
          { "data": "sin" },
          { "data": "address" },
          { "data": "visit_date" },
          { "data": "last_proc_date" },
          { "data": "patient_options" },
          { "data": "visit_options" },
      ],
      "columnDefs": [
          { "targets": [2,3,4,5,6,7], "searchable": false, "orderable": false, "visible": true }
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
      show_saving_state=true;

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
  $('#sin').on('change paste',function(){
      $("#sin").parent().removeClass('has-error');
      if($("#sin").next().length > 0)
          $("#sin").next().remove();
      $("#datepicker").val('');
      $("#datepicker").change();
      if( $("#sin").val() != 0)
        calculateBOD($(this).val());
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
// Function calculates the age field
function calculateBOD(sid){
	var sid_string=sid;
	var prifx_year="";
	if(sid_string[0] == 2)
		prifx_year="19";
	else if(sid_string[0] == 3)
		prifx_year="20";
	else{
    $("#sin").parent().addClass('has-error');
		$("#sin").after('<span class="help-block">الرقم القومي غير صحيح</span>');
		return;
	}
	var year=prifx_year+""+sid_string[1]+""+sid_string[2];
	var month=sid_string[3]+""+sid_string[4];
	var day=sid_string[5]+""+sid_string[6];
	var date=year+"-"+month+"-"+day;

	var birthdate = new Date(date);
	var today = new Date();
	var diffYears = today.getFullYear() - birthdate.getFullYear();
	var diffMonths = today.getMonth() - birthdate.getMonth();
	var diffDays = today.getDate() - birthdate.getDate();
	if(diffMonths < 0){
		diffMonths+=12;
		diffYears--;
	}
	if(diffDays < 0){
		diffMonths--;
		diffDays+=30;
	}
	if( isNaN(diffYears) || diffYears < 0 || isNaN(diffMonths) || isNaN(diffDays) ){
		$("#sin").parent().addClass('has-error');
		$("#sin").after('<span class="help-block">الرقم القومي غير صحيح</span>');
		return;
	}
	else{
		$("#datepicker").val(year+'-'+month+'-'+day);
    $('#datepicker').change();

	}
}
var proc_device=Array();
function addProcedure(){

  $("#proc_error_message").hide();
  show_saving_state=true;
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
											'<td>'+'<a nohref class="btn btn-danger" onclick="delete_proc_device('+$("#device option:selected").val()+","+$("#procedure_name option:selected").val()+",false"+')"><i class="fa fa-close"></i></a>'+'</td>'+
										   '</tr>');
			},
			error: function (data) {
				alert("Error");
			}
		});
	}
}
function delete_proc_device(device_id,proc_id,existrow=true){

  if(confirm('هل تريد الغاء هذا الفحص؟')){
    var url = "{{ url('ajax/deleteProcDevice') }}";
    var vid= $('#vid').val();
    var last_one=false;
    if($('#proc_device_tb tr').length < 3)
      last_one=true;
   // alert($('#proc_device_tb tr').length);
    $.ajax({
      type: "POST",
      url: url,
      data:{
          proc_device:device_id+"_"+proc_id,
          vid:vid,
          existrow:existrow,
          last_one:last_one,
          _token:"<?php echo csrf_token(); ?>" },
      success: function (data) {
        $('#proc_device_tb #row_'+device_id+'_'+proc_id).remove();
        if(last_one && existrow)
        {
           window.location.href="<?php {{ url('/'); }} ?>";
        }
      },
      error: function (data) {
        alert("Error");
      }
    });
  }
}

</script>
@stop
