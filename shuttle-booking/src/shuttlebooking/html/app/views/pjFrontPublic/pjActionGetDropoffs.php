<?php
$SEARCH = @$_SESSION[$controller->defaultStore]['search'];
$traveling = $controller->_get->toString('traveling'); 
$index = $controller->_get->toInt('index');
?>
<label class="pjSbsLocationLabel pjSbsLocation-from" style="display:<?php echo $traveling == 'from' ? '' : 'none';?>;"><?php __('front_avail_dropoff_locations');?>:</label>
<label class="pjSbsLocationLabel pjSbsLocation-to" style="display:<?php echo $traveling == 'from' ? 'none' : '';?>;"><?php __('front_avail_pickup_locations');?>:</label>	
<select id="pjSbsDropoffId_<?php echo $index;?>" name="dropoff_id" class="form-control required" data-msg-required="<?php __('front_required_field');?>">
	<option value="">-- <?php __('front_choose'); ?>--</option>
	<?php
	if(isset($tpl['pd_arr']))
	{
		foreach($tpl['pd_arr'] as $v)
		{
			?><option value="<?php echo $v['id'];?>"<?php echo isset($SEARCH['dropoff_id']) ? ($SEARCH['dropoff_id'] == $v['id'] ? ' selected="selected"' : NULL) : NULL;?> data-address="<?php echo pjSanitize::html($v['address']);?>" data-lat="<?php echo pjSanitize::html($v['lat']);?>" data-lng="<?php echo pjSanitize::html($v['lng']);?>"><?php echo pjSanitize::html($v['title']);?></option><?php
		}
	} 
	?>
</select>
<div class="help-block with-errors"><ul class="list-unstyled"></ul></div>