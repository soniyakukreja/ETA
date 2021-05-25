$(document).ready(function(){
	$('.datPik').datepicker({
	    weekStart: 0,
	    todayBtn: "linked",
	    language: "en",
	    orientation: "bottom auto",
	    keyboardNavigation: false,
	    autoclose: true
	});


});
// $(document).ready(function() {
//     $('#example').DataTable();
// } );
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});

$(function() {
	    $('div.aside ul li ul li a').filter(function(){
	    	return this.href==location.href}).addClass('active').siblings().removeClass('active');

  	    $( 'div.aside ul li ul li a' ).on( 'click', function() {
			$(this).addClass('active').siblings().removeClass('active');
      });
});

$(function() {
	    $('div.aside ul li a').filter(function(){
	    	return this.href==location.href}).addClass('active').siblings().removeClass('active');
		
  	    $( 'div.aside ul li a' ).on( 'click', function() {
			$(this).addClass('active').siblings().removeClass('active');
      });
});
