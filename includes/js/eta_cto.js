/*function newest_ticket(){
  var url = site_url+'dashboard/newest_ticket';
  $('#newest_ticket').dataTable({
      "serverSide": true,
      "responsive": true,
      "lengthMenu": [10,20, 50, 100],
      "ajax": {
        "url": url,
        "type": "POST",
      }
  });   
}

function f_newest_ticket(){
  var st_date = $('#startdate').val();
  var end_date = $('#enddate').val();

  var url = site_url+'dashboard/f_newest_ticket';
  $('#newest_ticket').dataTable({
      "serverSide": true,
      "responsive": true,
      "order": [[0, "asc" ]],
      "lengthMenu": [10,20, 50, 100],
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
  var url = site_url+'dashboard/compliance_count';
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
*/

function load_accountdata(){
	var st_date = $('#startdate').val();
	var end_date = $('#enddate').val();
	var url = site_url+'dashboard/getAccountData';
	$.ajax({
		url: url,
		type: "POST",
		data:{'st_date':st_date,'end_date':end_date},
		dataType: "json",
		// beforeSend:function(){
		// 	ajaxindicatorstart();
		// },
		success: function(res){
			// console.log('res',res);
			// ajaxindicatorstop();
			$('#amount_reconcile').html(res.total_reconcile);
			$('#amount_disburse').html(res.total_disburse);

		}
	});
}


function expiring_licensee(filter=''){
	var st_date = $('#startdate').val();
	var end_date = $('#enddate').val();

	var url = site_url+'dashboard/get_expiring_licensee';
    $('#expiring_licensee').dataTable({
        "serverSide": true,
        "responsive": true,
        "order": [[0, "asc" ]],
        "lengthMenu": [10,20, 50, 100],
        "ajax": {
          "url": url,
          "type": "POST",
          "data":{'st_date':st_date,'end_date':end_date,'filter':filter},
        }
    });   
}

function top_suppliers(){
	var st_date = $('#startdate').val();
	var end_date = $('#enddate').val();

	var url = site_url+'dashboard/top_suppliers';
    $('#top_suppliers').dataTable({
        "serverSide": true,
        "responsive": true,
        "order": [[0, "asc" ]],
        "lengthMenu": [10,20, 50, 100],
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

  var url = site_url+'dashboard/top_consumers';
    $('#top_consumers').dataTable({
        "serverSide": true,
        "responsive": true,
        "order": [[0, "asc" ]],
        "lengthMenu": [10,20, 50, 100],
        "ajax": {
          "url": url,
          "type": "POST",
          "data":{'st_date':st_date,'end_date':end_date},
        }
    });   
}

function top_ia(){
  var st_date = $('#startdate').val();
  var end_date = $('#enddate').val();

  var url = site_url+'dashboard/top_ia';
    $('#top_ia').dataTable({
        "serverSide": true,
        "responsive": true,
        "order": [[0, "asc" ]],
        "lengthMenu": [10,20, 50, 100],
        "ajax": {
          "url": url,
          "type": "POST",
          "data":{'st_date':st_date,'end_date':end_date},
        }
    });   
}


function top_lic(){
  var st_date = $('#startdate').val();
  var end_date = $('#enddate').val();

  var url = site_url+'dashboard/top_lic';
    $('#top_lic').dataTable({
        "serverSide": true,
        "responsive": true,
        "order": [[0, "asc" ]],
        "lengthMenu": [10,20, 50, 100],
        "ajax": {
          "url": url,
          "type": "POST",
          "data":{'st_date':st_date,'end_date':end_date},
        }
    });   
}

function upcoming_abrs(filter=''){
	var st_date = $('#startdate').val();
	var end_date = $('#enddate').val();

	var url = site_url+'dashboard/upcoming_abrs';
    $('#upcoming_abrs').dataTable({
        "serverSide": true,
        "responsive": true,
        "order": [[0, "asc" ]],
        "lengthMenu": [10,20, 50, 100],
        "ajax": {
          "url": url,
          "type": "POST",
          "data":{'st_date':st_date,'end_date':end_date,'filter':filter},
        }
    });   
}

function upcoming_qbrs(filter=''){
  var st_date = $('#startdate').val();
  var end_date = $('#enddate').val();

  var url = site_url+'dashboard/upcoming_qbrs';
    $('#upcoming_qbrs').dataTable({
        "serverSide": true,
        "responsive": true,
        "order": [[0, "asc" ]],
        "lengthMenu": [10,20, 50, 100],
        "ajax": {
          "url": url,
          "type": "POST",
          "data":{'st_date':st_date,'end_date':end_date,'filter':filter},
        }
    });   
}

function upcoming_mbrs(filter=''){
  var st_date = $('#startdate').val();
  var end_date = $('#enddate').val();

  var url = site_url+'dashboard/upcoming_mbrs';
    $('#upcoming_mbrs').dataTable({
        "serverSide": true,
        "responsive": true,
        "order": [[0, "asc" ]],
        "lengthMenu": [10,20, 50, 100],
        "ajax": {
          "url": url,
          "type": "POST",
          "data":{'st_date':st_date,'end_date':end_date,'filter':filter},
        }
    });   
}



function pending_audit(){
  var st_date = $('#startdate').val();
  var end_date = $('#enddate').val();

  var url = site_url+'dashboard/pending_audit';
  $('#pending_audit').dataTable({
      "serverSide": true,
      "responsive": true,
      "order": [[0, "asc" ]],
      "lengthMenu": [10,20, 50, 100],
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
top_suppliers();
top_consumers();
top_ia();
top_lic();
load_accountdata();
expiring_licensee();
upcoming_abrs();
upcoming_qbrs();
upcoming_mbrs();

//================bar charts================

productbycat_labels = '';
productbycat_values = '';

function producbycat(){
    var st_date = $('#startdate').val();
    var end_date = $('#enddate').val();
    var url = site_url+'dashboard/producbycat';
    $.ajax({
        url: url,
        type: "POST",
        data:{'st_date':st_date,'end_date':end_date},
        dataType: "json",
        success: function(res){
            productbycat_labels = res.labels;
            productbycat_values = res.values;
            product_sale_chart();
        }
    });
}

producbycat();
//================bar charts================

saler_peruser_labels = '';
saler_peruser_values = '';
function sales_per_user(filter=''){

  var st_date = $('#startdate').val();
  var end_date = $('#enddate').val();
  var url = site_url+'dashboard/sales_per_user';
   
  $.ajax({
    url: url,
    type: "POST",
    data:{'st_date':st_date,'end_date':end_date,'filter':filter},
    dataType: "json",
    success: function(res){
      console.log(res.values);
        saler_peruser_labels = res.labels;
        saler_peruser_values = res.values;
        sales_chart();
    }
  });
}

sales_per_user();
//================pie charts================
/*

tpc_labels = tpc_values = tpc_bg= '';
function ticket_percat(){
    var st_date = $('#startdate').val();
    var end_date = $('#enddate').val();
    var url = site_url+'dashboard/ticket_percat';
    $.ajax({
        url: url,
        type: "POST",
        data:{'st_date':st_date,'end_date':end_date},
        dataType: "json",
        success: function(res){
            tpc_labels = res.labels;
            tpc_values = res.values;
            tpc_bg = res.tpc_bg;
            load_ticket_cat_chart();
        }
    });
}

//===========

tps_labels = tps_values = tps_bg= '';


function ticket_per_staff(){
    var st_date = $('#startdate').val();
    var end_date = $('#enddate').val();
    var url = site_url+'dashboard/ticket_per_staff';
    $.ajax({
        url: url,
        type: "POST",
        data:{'st_date':st_date,'end_date':end_date},
        dataType: "json",
        success: function(res){

            tps_labels = res.labels;
            tps_values = res.values;
            tps_bg = res.tps_bg;
            load_ticket_staff_chart();
        }
    });
}*/

ticket_percat();
ticket_per_staff();

//================pie charts================

$(document).on('click','#applyfilter',function(){
  $('#pending_audit,#newest_ticket,#upcoming_mbrs,#upcoming_qbrs,#expiring_licensee, #top_suppliers,#top_consumers, #top_ia,#top_lic,#upcoming_abrs').DataTable().destroy();
  $('.msgNote').hide();

  f_newest_ticket();
  pending_audit();
  compliance_count();
  top_suppliers();
  top_consumers();
  top_ia();
  top_lic();
  load_accountdata();
  expiring_licensee('true');
  upcoming_abrs('true');
  upcoming_qbrs('true');
  upcoming_mbrs('true');

  ticket_percat();
  ticket_per_staff();
  sales_per_user('true');
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
  $('#pending_audit,#newest_ticket,#upcoming_mbrs,#upcoming_qbrs,#expiring_licensee, #top_suppliers,#top_consumers, #top_ia,#top_lic,#upcoming_abrs').DataTable().destroy();
  $('#exp_lic_note,#abr_note,#qbr_note,#mbr_note,.msgNote').show();

  newest_ticket();
  pending_audit();
  compliance_count();
  top_suppliers();
  top_consumers();
  top_ia();
  top_lic();
  load_accountdata();
  expiring_licensee();
  upcoming_abrs();
  upcoming_qbrs();
  upcoming_mbrs();

  ticket_percat();
  ticket_per_staff();
  sales_per_user();
  producbycat();

  $('#clearfilter').css('display','none');
});