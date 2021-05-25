function newest_ticket(){
  var url = site_url+'dashboard/dash_ticket/newest_ticket';
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

  var url = site_url+'dashboard/dash_ticket/f_newest_ticket';
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
  var url = site_url+'dashboard/dash_ticket/compliance_count';
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



tpc_labels = tpc_values = tpc_bg= '';
function ticket_percat(){
    var st_date = $('#startdate').val();
    var end_date = $('#enddate').val();
    var url = site_url+'dashboard/dash_ticket/ticket_per_cat';
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
    var url = site_url+'dashboard/dash_ticket/ticket_per_staff';
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
}