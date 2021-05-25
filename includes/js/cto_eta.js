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
producbycat();
sales_per_user();
ticket_percat();
ticket_per_staff();


$(document).on('click','#applyfilter',function(){
  $('.dataTable').DataTable().destroy();
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
  $('.dataTable').DataTable().destroy();
  $('.msgNote').show();

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