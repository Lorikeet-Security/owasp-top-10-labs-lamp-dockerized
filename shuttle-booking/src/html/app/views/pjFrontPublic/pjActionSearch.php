<?php
include_once dirname(__FILE__) . '/elements/header.php';
$SEARCH = @$_SESSION[$controller->defaultStore]['search'];
$months = __('months', true);
$short_days = __('short_days', true);
ksort($months);
ksort($short_days);
$week_start = isset($tpl['option_arr']['o_week_start']) && in_array((int) $tpl['option_arr']['o_week_start'], range(0,6)) ? (int) $tpl['option_arr']['o_week_start'] : 0;
$traveling = 'from';
if(isset($SEARCH['traveling']) && $SEARCH['traveling'] == 'to')
{
	$traveling = 'to';
}
$index = $controller->_get->toString('index');
?>
<div class="pjSbs-body">
	<form id="pjSbsSearchForm_<?php echo $index;?>" action="#" method="post" class="pjSbsSearchForm">
		<input type="hidden" name="sbs_search" value="1" />
		<div id="pjSbsCalendarLocale" style="display: none;" data-months="<?php echo implode("_", $months);?>" data-days="<?php echo implode("_", $short_days);?>" data-fday="<?php echo $week_start;?>"></div>
		<div class="pjSbs-box pjSbs-box-main">
			<div class="pjSbs-action-controls">
				<label class="pjSbs-action-radio<?php echo isset($SEARCH['traveling']) ? ($SEARCH['traveling'] == 'from' ? ' active' : NULL) : ' active';?>">
					<input type="radio" name="traveling" value="from"<?php echo isset($SEARCH['traveling']) ? ($SEARCH['traveling'] == 'from' ? ' checked="checked"' : NULL) : ' checked="checked"';?>>
	
					<?php __('front_traveling_from');?>
	
					<span></span>
				</label><!-- /.pjSbs-action-radio -->
	
				<label class="pjSbs-action-radio<?php echo isset($SEARCH['traveling']) ? ($SEARCH['traveling'] == 'to' ? ' active' : NULL) : NULL;?>">
					<input type="radio" name="traveling" value="to"<?php echo isset($SEARCH['traveling']) ? ($SEARCH['traveling'] == 'to' ? ' checked="checked"' : NULL) : NULL;?>>
	
					<?php __('front_traveling_to');?>
	
					<span></span>
				</label><!-- /.pjSbs-action-radio -->
				<?php
				if(count($tpl['da_arr']) > 1)
				{ 
					?>
					<div class="pjSbs-action-select">
						<i class="glyphicon glyphicon-map-marker"></i>
		
						<select id="pjSbsLocationId_<?php echo $index;?>" name="location_id">
							<?php
							foreach($tpl['da_arr'] as $k => $v)
							{ 
								?>
								<option value="<?php echo $v['id'];?>"<?php echo isset($SEARCH['location_id']) ? ($SEARCH['location_id'] == $v['id'] ? ' selected="selected"' : NULL) : NULL;?> data-address="<?php echo pjSanitize::html($v['address']);?>" data-lat="<?php echo pjSanitize::html($v['lat']);?>" data-lng="<?php echo pjSanitize::html($v['lng']);?>"><?php echo pjSanitize::html($v['title']);?></option>
								<?php
							} 
							?>
						</select>
					</div><!-- /.pjSbs-action-select -->
					<?php
				}else if(count($tpl['da_arr']) == 1){
					?>
					<div class="pjSbs-action-select">
						<i class="glyphicon glyphicon-map-marker"></i>
						<label style="padding: 15px 10px 0 40px;"><?php echo pjSanitize::html($tpl['da_arr'][0]['title']);?></label>
						<select id="pjSbsLocationId_<?php echo $index;?>" name="location_id" style="display: none;">
							<?php
							foreach($tpl['da_arr'] as $k => $v)
							{ 
								?>
								<option value="<?php echo $v['id'];?>"<?php echo isset($SEARCH['location_id']) ? ($SEARCH['location_id'] == $v['id'] ? ' selected="selected"' : NULL) : NULL;?> data-address="<?php echo pjSanitize::html($v['address']);?>" data-lat="<?php echo pjSanitize::html($v['lat']);?>" data-lng="<?php echo pjSanitize::html($v['lng']);?>"><?php echo pjSanitize::html($v['title']);?></option>
								<?php
							} 
							?>
						</select>
					</div><!-- /.pjSbs-action-select -->
					<?php
				} 
				?>
			</div><!-- /.pjSbs-action-controls -->
	
			<div class="row">
				<div class="col-md-6 col-xs-12">
					<div id="pjSbsDropoffWrapper_<?php echo $index;?>" class="form-group">
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
					</div><!-- /.form-group -->
	
					<div class="row">
						<div class="col-xs-6">
							<label class="control-label"><?php __('front_departure');?></label>
	
							<div class="form-group">
								<div class="input-group date-pick">
									<input type="text" name="booking_date" value="<?php echo isset($SEARCH['booking_date']) ? $SEARCH['booking_date'] : NULL;?>" class="form-control required" readonly="readonly" data-msg-required="<?php __('front_required_field');?>"/>
	
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
									</span>
								</div>
								<div class="help-block with-errors"><ul class="list-unstyled"></ul></div>
							</div><!-- /.form-group -->
						</div><!-- /.col-sm-6 -->
	
						<div class="col-xs-6">
							<label class="control-label"><input id="pjSbsHasReturn_<?php echo $index;?>" name="has_return" value="T" type="checkbox"<?php echo isset($SEARCH['has_return']) ? ($SEARCH['has_return'] == 'T' ? ' checked="checked"' : NULL) : NULL;?>> <?php __('front_returning_on');?></label>
	
							<div class="form-group">
								<div id="pjSbsReturnDatePick" class="input-group return-date-pick<?php echo isset($SEARCH['has_return']) ? ($SEARCH['has_return'] == 'T' ? '' : '-disabled') : '-disabled';?>">
									<input type="text" name="return_date" value="<?php echo isset($SEARCH['has_return']) ? (isset($SEARCH['return_date']) ? $SEARCH['return_date'] : NULL) : NULL;?>" class="form-control<?php echo isset($SEARCH['has_return']) ? ($SEARCH['has_return'] == 'T' ? ' required' : NULL) : NULL;?>"<?php echo isset($SEARCH['has_return']) ? ($SEARCH['has_return'] == 'T' ? '' : ' disabled="disabled"') : ' disabled="disabled"';?> readonly="readonly" data-msg-required="<?php __('front_required_field');?>"/>
	
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
									</span>
								</div>
								<div class="help-block with-errors"><ul class="list-unstyled"></ul></div>
							</div><!-- /.form-group -->
						</div><!-- /.col-sm-6 -->
					</div><!-- /.row -->
	
					<div class="row">
						<div class="col-sm-6 col-xs-12">
							<label><?php __('front_passengers');?>:</label>
					
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
									</span>
							
									<div class="btn-group pjSbs-spinner" role="group" aria-label="...">
	            						<button type="button" class="btn pjSbs-spinner pjSbs-spinner-down">-</button>
							
										<input type="text" name="passengers" class="pjSbs-spinner-result digits" maxlength="3" value="<?php echo isset($SEARCH['passengers']) ? $SEARCH['passengers'] : 1;?>" data-msg-digits="<?php __('front_digits_validation');?>">
							
										<button type="button" class="btn pjSbs-spinner pjSbs-spinner-up">+</button>
									</div>
								</div>
								<div class="help-block with-errors"><ul class="list-unstyled"></ul></div>
							</div><!-- /.form-group -->
						</div><!-- /.col-sm-6 -->
					
						<div class="col-sm-6 col-xs-12">
							<label></label>
							<input id="pjSbsDistanceField" name="distance" value="<?php echo isset($SEARCH['distance']) ? $SEARCH['distance'] : NULL;?>" type="hidden">
							<input value="<?php __('front_btn_book');?>" class="btn btn-primary btn-block" type="submit">
						</div><!-- /.col-sm-3 -->
					</div><!-- /.row -->
				</div><!-- /.col-sm-6 -->
	
				<div class="col-md-6 col-xs-12">
					<label class="pjSbsLocationLabel pjSbsLocation-from" style="display:<?php echo $traveling == 'from' ? '' : 'none';?>;"><?php __('front_select_dropoff_lcoation');?>:</label>
					<label class="pjSbsLocationLabel pjSbsLocation-to" style="display:<?php echo $traveling == 'from' ? 'none' : '';?>;"><?php __('front_select_pickup_lcoation');?>:</label>
					<div class="pjSbs-map" id="pjSbsMapCanvas">
						
					</div><!-- /.pjSbs-map -->
				</div><!-- /.col-sm-6 -->
			</div><!-- /.row -->
		</div><!-- /.pjSbs-box -->
	</form>
</div><!-- /.pjSbs-body -->