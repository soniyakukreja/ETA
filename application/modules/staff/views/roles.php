<option value="">Please Select</option>
<?php 
$this->userdata = $this->session->userdata('userdata');
$urole = $this->userdata['urole_id']; 
if($urole==1){ ?>
<option value="2">CTO</option>
<option value="10">I.T</option>
<option value="7">Compliance Officers</option>
<option value="3">Accounts</option>
<option value="9">Marketing</option>
<option value="8">Product Managers</option>
<option value="11">BDEs</option>
<option value="5">KAMs</option>
<option value="4">CSRs</option>

<?php }elseif($urole==2){ ?>
<option value="2">CTO</option>
<option value="3">Accounts</option>
<option value="9">Marketing</option>
<option value="11">BDEs</option>
<option value="5">KAMs</option>
<option value="4">CSRs</option>

<?php }elseif($urole==3){ ?>
<option value="2">CTO</option>
<option value="3">Accounts</option>
<option value="9">Marketing</option>
<option value="11">BDEs</option>
<option value="5">KAMs</option>
<option value="4">CSRs</option>
<?php } ?>

