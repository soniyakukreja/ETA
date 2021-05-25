<?php $this->load->view('include/header.php');
$carttotal = 0;
 ?>
<input type="hidden" id="abc" value=""/>
	<?php $this->load->view('include/footer.php'); ?>
</div>
</body>
</html>
<script>
function putinputvalue(){
	$('#abc').val('testimg');
}

$(document).on('change','.abc',function(){
	alert('new value');
});
putinputvalue();
</script>