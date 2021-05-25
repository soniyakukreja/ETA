
	<?php echo form_open('audience/import',array('class'=>'addForm','id'=>'import','autocomplete'=>'off')); ?>
	<table class="table">
		<input type="hidden" name="csv" value="<?php echo $filename; ?>">
  <thead>
    <tr>
      <th scope="col">Column Name</th>
      <th scope="col">Map to Field</th>
     
    </tr>
  </thead>
  <tbody>
  	<tr>
	           				<td><input type="hidden" name="dbfield[0]"  value="name" />Name</td>
	           				<td><select class="form-control js-example-basic-single" name="dbvalue[0]" id="map">
									<option value="">Please select</option>';
								<?php $i=0;	foreach($fields as $v){  ?><option value="<?php echo $i; ?>"><?php echo $v; ?></option><?php $i++; } ?>
								</select></td>
	           				</tr>
	           				<tr>
	           				<td><input type="hidden" name="dbfield[1]"  value="email" />Email</td>
	           				<td><select class="form-control js-example-basic-single" name="dbvalue[1]" id="map">
									<option value="">Please select</option>';
								<?php  $i=0; foreach($fields as $v){  ?><option value="<?php echo $i; ?>"><?php echo $v; ?></option><?php $i++; } ?>
								</select></td>
	           				</tr>
	           				
							<tr>
	           				<td><input type="hidden" name="dbfield[2]"  value="business_name" />Business Name</td>
	           				<td><select class="form-control js-example-basic-single" name="dbvalue[2]" id="map">
									<option value="">Please select</option>';
								<?php $i=0;	foreach($fields as $v){  ?><option value="<?php echo $i; ?>"><?php echo $v; ?></option><?php $i++; } ?>
								</select></td>
	           				</tr>
	           				

<tr><td><button type="submit">Import</button></td></tr>
</tbody></table></form>