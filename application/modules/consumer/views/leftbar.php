<div class="aside">
<?php 
$uri1 = $this->uri->segment(1);
$uri2 = $this->uri->segment(2);
//echo $uri1.'<br>'.$uri2; 
 ?>
<?php if($uri1 =='consumer' && $uri2 =='ticket'){ ?>
<h3>Ticket</h3>
<ul>
	<li>
		<a href="<?php echo site_url('consumer/ticket/addticket'); ?>">Add New</a>
	</li>
</ul>

<?php }elseif($uri1 =='consumer' && $uri2 =='ticket'){ ?>
<h3>Staff</h3>
<ul>
	<li>
		<a href="<?php echo site_url(); ?>">My Profile</a>
	</li>
</ul>
<?php } ?>

</div>