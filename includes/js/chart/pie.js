function load_ticket_cat_chart(){
	var ctx = $('#ticket_per_cat');
	$('#ticketpercat_chart').show();

	tpc_data = {
	    labels: tpc_labels,
	    datasets: [{
	        data: tpc_values,
		    backgroundColor: tpc_bg
	    }],
	};

	var tpc_options = {
		showDatasetLabels : true,
		title : {
			display : false,
			position : "top",
			text : "",
			fontSize : 18,
			fontColor : "#111"
		},
		legend : {
			display : false,
			position : "bottom"
		},
	};

	tpc_chart=false;
	$.map(tpc_values, function(i, v) {
		if(parseFloat(i)>0){
			tpc_chart=true;
		}
	});
	if (parseFloat(tpc_values.length)>0 && tpc_chart !=false) {
		$('#ticketpercat_404').css('display','none');
		ctx.css('display','block');

		var chart = new Chart( ctx, {
			type : "pie",
			data : tpc_data,
			options : tpc_options
		});

		$('#ticketpercat_chart #ul_li').html(tcp_ul_li);

	}else{
		$('#ticketpercat_404').css('display','block');
		ctx.css('display','none');
		$('#ticketpercat_chart').hide();
	}

}
function load_ticket_staff_chart(){
	var ctxx = $('#ticket_per_staff');
	$('#ticketperstaff_chart').show();
	tps_data = {
	    labels: tps_labels,
	    datasets: [{
	        data: tps_values,
		    backgroundColor: tps_bg
	    }],
	};

	var tps_options = {
		showDatasetLabels : true,
		title : {
			display : false,
			position : "top",
			text : "",
			fontSize : 18,
			fontColor : "#111"
		},
		legend : {
			display : false,
			position : "bottom"
		},
	};
	

	var tps_chart=false;
	$.map(tps_values, function(i, v) {
		if(parseFloat(i)>0){
			tps_chart=true;
		}
	});
	if (tps_values.length>0 && tps_chart!=false) {
		$('#ticketperstaff_404').css('display','none');
		ctxx.css('display','block');
		var chart = new Chart( ctxx, {
			type : "pie",
			data : tps_data,
			options : tps_options
		});
		$('#ticketperstaff_chart #ul_li').html(tps_ul_li);

	}else{
		$('#ticketperstaff_404').css('display','block');
		ctxx.css('display','none');
		$('#ticketperstaff_chart').hide();
	}
}