<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo empty($meta_title)?'ETA Global':$meta_title.' | ETA Global'; //echo meta_title(); ?></title>

	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script type="text/javascript" language="javascript" src="<?php echo base_url('includes/js/jquery-1.11.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('includes/js/loaderjs.js');?>"></script>
<script>
ajaxindicatorstart();
</script>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<link href="<?php echo base_url('assets/plugin/select2/css/select2.min.css'); ?>" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugin/datatables/css/datatables.min.css'); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugin/datatables/css/datatables.yadcf.min.css'); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datepicker.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('includes/css/croppie.css'); ?>">
	<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('includes/telphone/css/icon/flag.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('includes/telphone/countrystuff/css/intlTelInput.css'); ?>" rel="stylesheet">
	
</head>
<body>
	
<div id="wrapper">
<header id="header">
	<div class="header">
		<div class="logoBanner">
			<a href="<?php echo site_url(); ?>" id="logo">
				<img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="Logo" />
			</a>
			
				<?php $userdata = $this->session->userdata('userdata');
				$ba = $this->generalmodel->getJoinData('m.ba_id,m.ba_image,m.ba_link,m.ba_target','banner_ads as m','user as b','m.ba_createdby = b.user_id',array('m.ba_roles_id'=>$userdata['urole_id'],'m.ba_bannertype'=>'Top','m.ba_status'=>1),'m.ba_id','desc','result_array');
				
				if($ba)
				{ ?>
				<a href="<?php echo $ba[0]['ba_link']; ?>" class="adsBanner" <?php if($ba[0]['ba_target']=='_blank'){echo "target= '_blank'";} ?>>
				<img src="<?php echo base_url() ?>uploads/banner/<?php echo $ba[0]['ba_image']; ?>" class="bn-img" alt="Ads" /></a>
			<?php	}
			else{ ?>
				<a href="#" class="adsBanner"></a>
			<?php }
			 ?>
			
		
			
		</div>
		<div class="headerLinks">
			<ul>
				<li><a href="<?php echo site_url();?>"><?php echo $userdata['username']; ?></a></li>
				<li><a href="<?php echo site_url('myprofile');?>">My Profile</a></li>	
				<li><a href="<?php echo site_url('logout'); ?>">Log Out</a></li>
			</ul>
		</div>
	</div>
</header>