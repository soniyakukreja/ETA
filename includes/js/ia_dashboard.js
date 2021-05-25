/*
function newest_ticket(){
  var url = site_url+'lic_dashboard/newest_ticket';
  $('#newest_ticket').dataTable({
      "serverSide": true,
      "responsive": true,
      "ajax": {
        "url": url,
        "type": "POST",
      }
  });   
}

function f_newest_ticket(){
  var st_date = $('#startdate').val();
  var end_date = $('#enddate').val();

  var url = site_url+'lic_dashboard/f_newest_ticket';
  $('#newest_ticket').dataTable({
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


function pending_audit(){
  var st_date = $('#startdate').val();
  var end_date = $('#enddate').val();

  var url = site_url+'lic_dashboard/pending_audit';
  $('#pending_audit').dataTable({
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

function compliance_count(){
  var st_date = $('#startdate').val();
  var end_date = $('#enddate').val();
  var url = site_url+'lic_dashboard/compliance_count';
  $.ajax({
    url: url,
    type: "POST",
    data:{'st_date':st_date,'end_date':end_date},
    dataType: "json",
    beforeSend:function(){
    },
    success: function(res){
      $('#openComp').html(res.openComp);
      $('#pendingComp').html(res.pendingComp);
      $('#resolvedComp').html(res.resolvedComp);
      $('#spamComp').html(res.spamComp);
    }
  });
}


function upcoming_abrs(){
	var st_date = $('#startdate').val();
	var end_date = $('#enddate').val();

	var url = site_url+'lic_dashboard/upcoming_abrs';
    $('#upcoming_abrs').dataTable({
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

function upcoming_qbrs(){
  var st_date = $('#startdate').val();
  var end_date = $('#enddate').val();

  var url = site_url+'lic_dashboard/upcoming_qbrs';
    $('#upcoming_qbrs').dataTable({
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

function upcoming_mbrs(){
  var st_date = $('#startdate').val();
  var end_date = $('#enddate').val();

  var url = site_url+'lic_dashboard/upcoming_mbrs';
    $('#upcoming_mbrs').dataTable({
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


newest_ticket();
pending_audit();
compliance_count();
upcoming_abrs();
upcoming_qbrs();
upcoming_mbrs();

//================pie charts================


tpc_labels = tpc_values = tpc_bg= '';
function ticket_percat(){
    var st_date = $('#startdate').val();
    var end_date = $('#enddate').val();
    var url = site_url+'lic_dashboard/ticket_percat';
    $.ajax({
        'async': false,
        url: url,
        type: "POST",
        data:{'st_date':st_date,'end_date':end_date},
        dataType: "json",
        success: function(res){
            tpc_labels = res.labels;
            tpc_values = res.values;
            tpc_bg = res.tpc_bg;
        }
    });
}
ticket_percat();

//===========

tps_labels = tps_values = tps_bg= '';


function ticket_per_staff(){
    var st_date = $('#startdate').val();
    var end_date = $('#enddate').val();
    var url = site_url+'lic_dashboard/ticket_per_staff';
    $.ajax({
        'async': false,
        url: url,
        type: "POST",
        data:{'st_date':st_date,'end_date':end_date},
        dataType: "json",
        success: function(res){
            tps_labels = res.labels;
            tps_values = res.values;
            tps_bg = res.tps_bg;
        }
    });
}

ticket_per_staff();

//================pie charts================
 */
 
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

top_suppliers();
top_consumers();
load_accountdata();
expiring_licensee();


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

producbycat();
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

sales_per_user();


$(document).on('click','#applyfilter',function(){
  $('#expiring_licensee, #top_suppliers,#top_consumers').DataTable().destroy();
 
  //f_newest_ticket();
  //pending_audit();
  //compliance_count();
  top_suppliers();
  top_consumers();
  load_accountdata();
  expiring_licensee();
  //upcoming_abrs();
  //upcoming_qbrs();
  //upcoming_mbrs();

  //ticket_percat();
  //ticket_per_staff();
  sales_per_user();
  producbycat();

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
  $('#expiring_licensee, #top_suppliers,#top_consumers').DataTable().destroy();
 
  //newest_ticket();
  //pending_audit();
  //compliance_count();
  top_suppliers();
  top_consumers();
  load_accountdata();
  expiring_licensee();
  //upcoming_abrs();
  //upcoming_qbrs();
  //upcoming_mbrs();

  //ticket_percat();
  //ticket_per_staff();
  sales_per_user();
  producbycat();

  $('#clearfilter').css('display','none');
});