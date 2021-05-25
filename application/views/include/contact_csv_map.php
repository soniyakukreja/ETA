
	<?php echo form_open('lead/business/import',array('class'=>'addForm','id'=>'import','autocomplete'=>'off')); ?>
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
	           				<td><input type="hidden" name="dbfield[0]"  value="contact_person" />Contact Person</td>
	           				<td><select class="form-control js-example-basic-single" name="dbvalue[0]" id="map">
									<option value="">Please select</option>';
								<?php $i=0;	foreach($fields as $v){  ?><option value="<?php echo $i; ?>"><?php echo $v; ?></option><?php $i++; } ?>
								</select></td>
	           				</tr>
	           				<tr>
	           				<td><input type="hidden" name="dbfield[1]"  value="contact_email" />Email</td>
	           				<td><select class="form-control js-example-basic-single" name="dbvalue[1]" id="map">
									<option value="">Please select</option>';
								<?php  $i=0; foreach($fields as $v){  ?><option value="<?php echo $i; ?>"><?php echo $v; ?></option><?php $i++; } ?>
								</select></td>
	           				</tr>
	           				
							<tr>
	           				<td><input type="hidden" name="dbfield[2]"  value="contact_phone" />Phone</td>
	           				<td><select class="form-control js-example-basic-single" name="dbvalue[2]" id="map">
									<option value="">Please select</option>';
								<?php $i=0;	foreach($fields as $v){  ?><option value="<?php echo $i; ?>"><?php echo $v; ?></option><?php $i++; } ?>
								</select></td>
	           				</tr>
	           				<tr>
	           				<td><input type="hidden" name="dbfield[3]"  value="business_name" />Business Name</td>
	           				<td><select class="form-control js-example-basic-single" name="dbvalue[3]" id="map">
									<option value="">Please select</option>';
								<?php $i=0;	foreach($fields as $v){  ?><option value="<?php echo $i; ?>"><?php echo $v; ?></option><?php $i++; } ?>
								</select></td>
	           				</tr>
	           				<tr>
	           				<td><input type="hidden" name="dbfield[4]"  value="business_street1" />Address</td>
	           				<td><select class="form-control js-example-basic-single" name="dbvalue[4]" id="map">
									<option value="">Please select</option>';
								<?php $i=0;	foreach($fields as $v){  ?><option value="<?php echo $i; ?>"><?php echo $v; ?></option><?php $i++; } ?>
								</select></td>
	           				</tr>

	           				<tr>
	           				<td><input type="hidden" name="dbfield[5]"  value="business_suburb" />Suburb</td>
	           				<td><select class="form-control js-example-basic-single" name="dbvalue[5]" id="map">
									<option value="">Please select</option>';
								<?php $i=0;	foreach($fields as $v){  ?><option value="<?php echo $i; ?>"><?php echo $v; ?></option><?php $i++; } ?>
								</select></td>
	           				</tr>

	           				<tr>
	           				<td><input type="hidden" name="dbfield[6]"  value="business_postalcode" />Postcode</td>
	           				<td><select class="form-control js-example-basic-single" name="dbvalue[6]" id="map">
									<option value="">Please select</option>';
								<?php $i=0;	foreach($fields as $v){  ?><option value="<?php echo $i; ?>"><?php echo $v; ?></option><?php $i++; } ?>
								</select></td>
	           				</tr>

							<td><input type="hidden" name="dbfield[7]"  value="business_country" />Country</td>
	           				<td><select class="form-control js-example-basic-single" name="dbvalue[7]" id="map">
									<option value="">Please select</option>';
								<?php $i=0;	foreach($fields as $v){  ?><option value="<?php echo $i; ?>"><?php echo $v; ?></option><?php $i++; } ?>
								</select></td>
	           				</tr>

	           				<?php /*

	           				$fname1="test['dbfield'][1]";
	           				$sname1="test['value'][1]";
	           				$html.= '<tr>
	           				<td><input type="hidden" name="'.$fname1.'"  value="contact_email" />Email</td>
	           				<td><select class="form-control js-example-basic-single" name="'.$sname1.'" id="map">
									<option value="0">Please select</option>';
									for ($j=0; $j <count($csvData) ; $j++) { $html.='<option value="'.$j.'">'.$csvData[$j].'</option>'; }
								$html.= '</select></td>
	           				</tr>';

	           		
	           				$fname2="test['dbfield'][2]";
	           				$sname2="test['value'][2]";
	           				$html.= '<tr>
	           				<td><input type="hidden" name="'.$fname2.'"  value="contact_phone" />Phone</td>
	           				<td><select class="form-control js-example-basic-single" name="'.$sname2.'" id="map">
									<option value="0">Please select</option>';
									for ($j=0; $j <count($csvData) ; $j++) { $html.='<option value="'.$j.'">'.$csvData[$j].'</option>'; }
								$html.= '</select></td>
	           				</tr>';

	           				$fname3="test['dbfield'][3]";
	           				$sname3="test['value'][3]";
	           				$html.= '<tr>
	           				<td><input type="hidden" name="'.$fname3.'"  value="business_name" />Business Name</td>
	           				<td><select class="form-control js-example-basic-single" name="'.$sname3.'" id="map">
									<option value="0">Please select</option>';
									for ($j=0; $j <count($csvData) ; $j++) { $html.='<option value="'.$j.'">'.$csvData[$j].'</option>'; }
								$html.= '</select></td>
	           				</tr>';

	           				$fname5="test['dbfield'][5]";
	           				$sname5="test['value'][5]";
	           				$html.= '<tr>
	           				<td><input type="hidden" name="'.$fname5.'"  value="business_street1" />Address</td>
	           				<td><select class="form-control js-example-basic-single" name="'.$sname5.'" id="map">
									<option value="0">Please select</option>';
									for ($j=0; $j <count($csvData) ; $j++) { $html.='<option value="'.$j.'">'.$csvData[$j].'</option>'; }
								$html.= '</select></td>
	           				</tr>';

	           				$fname6="test['dbfield'][6]";
	           				$sname6="test['value'][6]";
	           				$html.= '<tr>
	           				<td><input type="hidden" name="'.$fname6.'"  value="business_suburb" />Suburb</td>
	           				<td><select class="form-control js-example-basic-single" name="'.$sname6.'" id="map">
									<option value="0">Please select</option>';
									for ($j=0; $j <count($csvData) ; $j++) { $html.='<option value="'.$j.'">'.$csvData[$j].'</option>'; }
								$html.= '</select></td>
	           				</tr>';

	           				$fname7="test['dbfield'][7]";
	           				$sname7="test['value'][7]";
	           				$html.= '<tr>
	           				<td><input type="hidden" name="'.$fname7.'"  value="business_postalcode" />Postcode</td>
	           				<td><select class="form-control js-example-basic-single" name="'.$sname7.'" id="map">
									<option value="0">Please select</option>';
									for ($j=0; $j <count($csvData) ; $j++) { $html.='<option value="'.$j.'">'.$csvData[$j].'</option>'; }
								$html.= '</select></td>
	           				</tr>';

	           				$fname8="test['dbfield'][8]";
	           				$sname8="test['value'][8]";
	           				$html.= '<tr>
	           				<td><input type="hidden" name="'.$fname8.'"  value="business_country" />Country</td>
	           				<td><select class="form-control js-example-basic-single" name="'.$sname8.'" id="map">
									<option value="0">Please select</option>';
									for ($j=0; $j <count($csvData) ; $j++) { $html.='<option value="'.$j.'">'.$csvData[$j].'</option>'; }
								$html.= '</select></td>
	           				</tr>';
	           			*/ ?>
<tr><td><button type="submit">Import</button></td></tr>
</tbody></table></form>