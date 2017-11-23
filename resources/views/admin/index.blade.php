@extends('layouts.app')
@section('chart')
<script>
window.onload = function () {
  var order_data;
  $.ajax({
    "url": "{{ url('ajax/getNumberOfReservationsPerDeviceToday') }}",
    "dataType": "json",
    "type": "GET",
    success:function(data){
      if(data['data']){
        var chart = new CanvasJS.Chart("chartContainer", {
        	animationEnabled: true,
        	theme: "light1", // "light1", "light2", "dark1", "dark2"
        	title:{
        		text: "Number of reseravations per modality type today "
        	},
        	axisY: {
        		title: "Number or reservations"
        	},
        	data: [{
        		type: "column",
        		showInLegend: false,
        		legendMarkerColor: "grey",
        		legendText: "1",
        		dataPoints: data['data']
        	}]
        });
        chart.render();
      }
    },
    error:function(){
      alert("Error");
    }
  });


}
</script>
@stop
@section('content')
<div class="container">
    <div class="row" >
      <div class="col-lg-12">
        <div id="chartContainer"></div>
      </div>

    </div>
</div>
@endsection
@section('javascript')
<script type="text/javascript" src="{{asset('js/CanvasJs.js')}}"></script>
@stop
