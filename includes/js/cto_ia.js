/*
function load_accountdata(){
	var st_date = $('#startdate').val();
	var end_date = $('#enddate').val();
	var url = site_url+'dashboard/ia_dashboard/getAccountData';
	$.ajax({
		url: url,
		type: "POST",
		data:{'st_date':st_date,'end_date':end_date},
		dataType: "json",
		beforeSend:function(){
			ajaxindicatorstart();
		},
		success: function(res){
			console.log('res',res);
			ajaxindicatorstop();
			$('#amount_reconcile').html(res.total_reconcile);
			$('#amount_disburse').html(res.total_disburse);

		}
	});
}

function expiring_licensee(){
	var st_date = $('#startdate').val();
	var end_date = $('#enddate').val();

	var url = site_url+'dashboard/ia_dashboard/get_expiring_licensee';
    $('#expiring_licensee').dataTable({
        "serverSide": true,
        "responsive": true,
        "order": [[0, "asc" ]],
        "lengthMenu": [20, 50, 100],
        "ajax": {
          "url": url,
          "type": "POST",
          "data":{'st_date':st_date,'end_date':end_date},
        }
    });   
}

function top_suppliers(){
	var st_date = $('#startdate').val();
	var end_date = $('#enddate').val();

	var url = site_url+'dashboard/ia_dashboard/top_suppliers';
    $('#top_suppliers').dataTable({
        "serverSide": true,
        "responsive": true,
        "order": [[0, "asc" ]],
        "lengthMenu": [20, 50, 100],
        "ajax": {
          "url": url,
          "type": "POST",
          "data":{'st_date':st_date,'end_date':end_date},
        }
    });   
}

function top_consumers(){
  var st_date = $('#startdate').val();
  var end_date = $('#enddate').val();

  var url = site_url+'dashboard/ia_dashboard/top_consumers';
    $('#top_consumers').dataTable({
        "serverSide": true,
        "responsive": true,
        "order": [[0, "asc" ]],
        "lengthMenu": [20, 50, 100],
        "ajax": {
          "url": url,
          "type": "POST",
          "data":{'st_date':st_date,'end_date':end_date},
        }
    });   
}




//================bar charts================

productbycat_labels = '';
productbycat_values = '';

function producbycat(){
    var st_date = $('#startdate').val();
    var end_date = $('#enddate').val();
    var url = site_url+'dashboard/ia_dashboard/producbycat';
    $.ajax({
        'async': false,
        url: url,
        type: "POST",
        data:{'st_date':st_date,'end_date':end_date},
        dataType: "json",
        success: function(res){
            productbycat_labels = res.labels;
            productbycat_values = res.values;
        }
    });
}

//================bar charts================

saler_peruser_labels = '';
saler_peruser_values = '';
function sales_per_user(){

  var st_date = $('#startdate').val();
  var end_date = $('#enddate').val();
  var url = site_url+'dashboard/ia_dashboard/sales_per_user';
   
  $.ajax({
    url: url,
    type: "POST",
    data:{'st_date':st_date,'end_date':end_date},
    dataType: "json",
    success: function(res){
        saler_peruser_labels = res.labels;
        saler_peruser_values = res.values;
    }
  });
}
*/

top_suppliers();
top_consumers();
load_accountdata();
expiring_licensee();
producbycat();
sales_per_user();


$(document).on('click','#applyfilter',function(){
  $('.dataTable').DataTable().destroy();
  $('.msgNote').hide(); 

  top_suppliers();
  top_consumers();
  load_accountdata();
  expiring_licensee();
  producbycat();
  sales_per_user();

  $('#clearfilter').css('display','inline-block');
});

$(document).on('click','#clearfilter',function(){

  var date = new Date();
  var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
  var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
   
  var st_date = ((firstDay.getMonth() > 8) ? (firstDay.getMonth() + 1) : ('0' + (firstDay.getMonth() + 1))) + '/' + ((firstDay.getDate() > 9) ? firstDay.getDate() : ('0' + firstDay.getDate())) + '/' + firstDay.getFullYear();
  var end_date = ((lastDay.getMonth() > 8) ? (lastDay.getMonth() + 1) : ('0' + (lastDay.getMonth() + 1))) + '/' + ((lastDay.getDate() > 9) ? lastDay.getDate() : ('0' + lastDay.getDate())) + '/' + lastDay.getFullYear();

  $('#startdate').val(st_date);
  $('#enddate').val(end_date);
  $('.dataTable').DataTable().destroy();
  $('.msgNote').show();

  top_suppliers();
  top_consumers();
  load_accountdata();
  expiring_licensee();
  sales_per_user();
  producbycat();

  $('#clearfilter').css('display','none');
});