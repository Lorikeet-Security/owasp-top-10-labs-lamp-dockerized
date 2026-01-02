<?php
$titles = __('error_titles', true);
$bodies = __('error_bodies', true);
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-6">
                <h2><?php echo __('infoUpdateLineTitle', true);?></h2>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 btn-group-languages">
				<?php if ($tpl['is_flag_ready']) : ?>
				<div class="multilang"></div>
				<?php endif; ?>
			</div>
        </div>

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php echo __('infoUpdateLineDesc', true); ?></p>
    </div>
</div>

<div class="row wrapper wrapper-content animated fadeInRight">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminLines&amp;action=pjActionUpdate" method="post" id="frmUpdateLine" class="form pj-form" autocomplete="off" enctype="multipart/form-data">
				<input type="hidden" name="action_update" value="1" />
				<input type="hidden" name="id" value="<?php echo pjSanitize::html($tpl['arr']['id']);?>" />
            	<div class="ibox-content">
            		<div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblDepartureArrivalLocation');?></label>
								<select name="location_id" id="location_id" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required'); ?>">
            						<option value="">-- <?php __('lblChoose'); ?>--</option>
            						<?php
            						foreach($tpl['da_arr'] as $k => $v)
            						{
            							?><option value="<?php echo $v['id'];?>"<?php echo $v['id'] == $tpl['arr']['location_id'] ? ' selected="selected"' : NULL;?>><?php echo $v['title'];?></option><?php
            						} 
            						?>
            					</select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblTitle');?></label>
								<?php
								foreach ($tpl['lp_arr'] as $v)
								{
									?>
									<div class="<?php echo $tpl['is_flag_ready'] ? 'input-group ' : NULL;?>pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 1 ? NULL : 'none'; ?>">
										<input type="text" class="form-control<?php echo (int) $v['is_default'] === 0 ? NULL : ' required'; ?>" name="i18n[<?php echo $v['id']; ?>][title]" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['i18n'][$v['id']]['title'])); ?>" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>">	
										<?php if ($tpl['is_flag_ready']) : ?>
										<span class="input-group-addon pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="<?php echo pjSanitize::html($v['name']); ?>"></span>
										<?php endif; ?>
									</div>
									<?php 
								}
								?>
                            </div>
                        </div>
					</div>
					
					<div class="hr-line-dashed"></div>
					
					<?php
					if(!empty($tpl['line_detail_arr']))
					{
					    ?>
					    <div class="row">
    						<div class="col-lg-12 col-md-12 col-sm-12">
    							<table id="pjSbsLineTable" class="table table-striped table-hover pjSbsLineTable" style="width: 100%">
    								<thead>
                						<tr>
                							<th><?php __('lblLocation'); ?></th>
                							<th><?php __('lblDuration'); ?></th>
                							<th><?php __('lblPricePerPerson'); ?></th>
                							<th>&nbsp;</th>
                						</tr>
                					</thead>
                					<tbody>
                					    <?php
                					    foreach($tpl['line_detail_arr'] as $k => $item)
                					    {
                					        $index = (int) $item['id'];
                					        ?>
                					        <tr id="trLocation_<?php echo $index;?>">
                    							<td>
                    								<div class="form-group">
                    									<select id="pd_id_<?php echo $index;?>" name="pd_id[<?php echo $index;?>]" class="form-control required" data-index="<?php echo $index;?>">
                    										<option value="">-- <?php __('lblChoose'); ?>--</option>
                    										<?php
                    										foreach($tpl['pd_arr'] as $v)
                    										{
                    											?><option value="<?php echo $v['id']?>"<?php echo $v['id'] == $item['location_id'] ? ' selected="selected"' : NULL;?>><?php echo pjSanitize::html($v['title']);?></option><?php
                    										} 
                    										?>
                    									</select>
                    								</div>
                    							</td>
                    							<td>
                    								<div class="form-inline first">
                    									<div class="form-group">
                        									<span class="mr-sm-2"><?php __('lblIfPickup');?></span>
                        									<input name="duration_pickup[<?php echo $index;?>]" value="<?php echo pjSanitize::clean($item['duration_pickup'])?>" class="form-control w60 field-int required digits" />
                        									<span><?php __('lblMins');?></span>
                        								</div>
                    								</div>
                    								<div class="form-inline">
                    									<div class="form-group">
                        									<span class="mr-sm-2"><?php __('lblIfDropoff');?></span>
                        									<input name="duration_dropoff[<?php echo $index;?>]" value="<?php echo pjSanitize::clean($item['duration_dropoff'])?>" class="form-control w60  field-int required digits" />
                        									<span><?php __('lblMins');?></span>
                        								</div>
                    								</div>
                    							</td>
                    							<td>
                    								<div class="form-inline first">
                    									<div class="form-group">
                        									<span class="mr-sm-2"><?php __('lblIfPickup');?></span>
                        									<div class="input-group"> 
                                    							<input type="text" name="price_pickup[<?php echo $index?>]" value="<?php echo $item['price_pickup'];?>" class="form-control required"/> 
                                    						
                                    							<span class="input-group-addon"><?php echo pjCurrency::getCurrencySign($tpl['option_arr']['o_currency'], false) ?></span>
                                    						</div>
                                    					</div>
                    								</div>
                    								<div class="form-inline">
                    									<div class="form-group">
                        									<span class="mr-sm-2"><?php __('lblIfDropoff');?></span>
                        									<div class="input-group"> 
                                    							<input type="text" name="price_dropoff[<?php echo $index?>]" value="<?php echo $item['price_dropoff'];?>" class="form-control required"/> 
                                    						
                                    							<span class="input-group-addon"><?php echo pjCurrency::getCurrencySign($tpl['option_arr']['o_currency'], false) ?></span>
                                    						</div>
                                    					</div>
                    								</div>
                    							</td>
                    							<?php
            									if($k == 0)
            									{ 
            										?><td>&nbsp;</td><?php
            									}else{
            										?><td><a href="#" class="btn btn-danger btn-outline btn-sm m-l-xs linkRemoveRow"><i class="fa fa-trash"></i></a></td><?php
            									} 
            									?>
                    						</tr>
                					        <?php
                					    }
                					    ?>
                					</tbody>
        					    </table>
        					    <a href="#" class="btn btn-primary btn-outline btnAddLocation"><i class="fa fa-plus"></i> <?php __('btnAddDropoffLocation'); ?></a>			
    					    </div>
    					</div>
					    <?php
					}else{
    					$index = 'new_' . rand(1, 999999);
    					?>
    					<div class="row">
    						<div class="col-lg-12 col-md-12 col-sm-12">
    							<table id="pjSbsLineTable" class="table table-striped table-hover pjSbsLineTable" style="width: 100%">
    								<thead>
                						<tr>
                							<th><?php __('lblLocation'); ?></th>
                							<th><?php __('lblDuration'); ?></th>
                							<th><?php __('lblPricePerPerson'); ?></th>
                							<th>&nbsp;</th>
                						</tr>
                					</thead>
                					<tbody>
                						<tr id="trLocation_<?php echo $index;?>">
                							<td>
                								<div class="form-group">
                									<select id="pd_id_<?php echo $index;?>" name="pd_id[<?php echo $index;?>]" class="form-control required" data-index="<?php echo $index;?>">
                										<option value="">-- <?php __('lblChoose'); ?>--</option>
                										<?php
                										foreach($tpl['pd_arr'] as $v)
                										{
                											?><option value="<?php echo $v['id']?>"><?php echo pjSanitize::html($v['title']);?></option><?php
                										} 
                										?>
                									</select>
                								</div>
                							</td>
                							<td>
                								<div class="form-inline first">
                									<div class="form-group">
                    									<span class="mr-sm-2"><?php __('lblIfPickup');?></span>
                    									<input name="duration_pickup[<?php echo $index;?>]" class="form-control w60 field-int required digits" />
                    									<span><?php __('lblMins');?></span>
                    								</div>
                								</div>
                								<div class="form-inline">
                									<div class="form-group">
                    									<span class="mr-sm-2"><?php __('lblIfDropoff');?></span>
                    									<input name="duration_dropoff[<?php echo $index;?>]" class="form-control w60  field-int required digits" />
                    									<span><?php __('lblMins');?></span>
                    								</div>
                								</div>
                							</td>
                							<td>
                								<div class="form-inline first">
                									<div class="form-group">
                    									<span class="mr-sm-2"><?php __('lblIfPickup');?></span>
                    									<div class="input-group"> 
                                							<input type="text" name="price_pickup[<?php echo $index?>]" class="form-control required"/> 
                                						
                                							<span class="input-group-addon"><?php echo pjCurrency::getCurrencySign($tpl['option_arr']['o_currency'], false) ?></span>
                                						</div>
                                					</div>
                								</div>
                								<div class="form-inline">
                									<div class="form-group">
                    									<span class="mr-sm-2"><?php __('lblIfDropoff');?></span>
                    									<div class="input-group"> 
                                							<input type="text" name="price_dropoff[<?php echo $index?>]" class="form-control required"/> 
                                						
                                							<span class="input-group-addon"><?php echo pjCurrency::getCurrencySign($tpl['option_arr']['o_currency'], false) ?></span>
                                						</div>
                                					</div>
                								</div>
                							</td>
                							<td>&nbsp;</td>
                						</tr>
                					</tbody>
    							</table>
    							
    							<a href="#" class="btn btn-primary btn-outline btnAddLocation"><i class="fa fa-plus"></i> <?php __('btnAddDropoffLocation'); ?></a>							
    						</div>
    					</div><!-- /.row -->
    					<?php
					}
    				?>
					
					<div class="hr-line-dashed"></div>
					
                    <div class="row">
                    	<div class="col-lg-3 col-md-3 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblSeats');?></label>
								<input type="text" name="seats" id="seats" value="<?php echo pjSanitize::clean($tpl['arr']['seats'])?>" class="form-control field-int required" data-msg-required="<?php __('plugin_base_this_field_is_required'); ?>"/>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6">
                        
                        	<div class="form-group">
								<label class="control-label"><?php __('lblImage'); ?></label>
								<br/>
								<?php
								if (!empty($tpl['arr']['thumb_path']) && is_file($tpl['arr']['thumb_path']))
								{
									?>
									<div class="pj-type-image">
										<p class="m-b-md">
											<img src="<?php echo PJ_INSTALL_URL . $tpl['arr']['thumb_path'];?>" alt="" class="pj-scale">
										</p>
										<p class="m-b-md">
											<a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminLines&amp;action=pjActionDeleteImage&amp;id=<?php echo $tpl['arr']['id'];?>" data-id="<?php echo $tpl['arr']['id']; ?>" class="btn btn-xs btn-danger btn-outline btn-file pj-delete-image"><i class="fa fa-trash"></i> <?php __('btn_delete_image');?></a>
										</p>
									</div>
									<?php
								}
								?>
	                    		<div class="fileinput fileinput-new" data-provides="fileinput">
									<span class="btn btn-primary btn-outline btn-file">
										<span class="fileinput-new"><i class="fa fa-upload m-r-xs"></i> <?php __('lblSelectImage'); ?></span>
										<span class="fileinput-exists"><i class="fa fa-upload m-r-xs"></i> <?php __('lblChangeImage'); ?></span>
										<input type="file" name="image">
									</span>
									<span class="fileinput-filename"></span>
									<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
								</div>
							</div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                        	<div class="form-group">
                                <label class="control-label"><?php __('lblDescription');?></label>
								<?php
								foreach ($tpl['lp_arr'] as $v)
								{
									?>
									<div class="<?php echo $tpl['is_flag_ready'] ? 'input-group ' : NULL;?>pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 1 ? NULL : 'none'; ?>">
										<textarea name="i18n[<?php echo $v['id']; ?>][description]" rows="4" class="form-control" lang="<?php echo $v['id']; ?>" ><?php echo !empty($tpl['arr']['i18n'][$v['id']]['description']) ? htmlspecialchars(stripslashes(@$tpl['arr']['i18n'][$v['id']]['description'])) : NULL; ?></textarea>	
										<?php if ($tpl['is_flag_ready']) : ?>
										<span class="input-group-addon pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="<?php echo pjSanitize::html($v['name']); ?>"></span>
										<?php endif; ?>
									</div>
									<?php 
								}
								?>
                            </div>
                        </div>
                    </div>
                    
					<div class="hr-line-dashed"></div>
                    
					<div class="clearfix">
						<button type="submit" class="ladda-button btn btn-primary btn-lg btn-phpjabbers-loader pull-left" data-style="zoom-in">
							<span class="ladda-label"><?php __('btnSave', false, true); ?></span>
							<?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
						</button>
	
						<button type="button" class="btn btn-white btn-lg pull-right" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminLines&action=pjActionIndex';"><?php __('btnCancel'); ?></button>
					</div>
	            </div>
			</form>
        </div>
    </div>
</div>

<table id="pjSbsLineTableClone" style="display: none">
	<tr id="trLocation_{INDEX}">
		<td>
			<div class="form-group">
				<select id="pd_id_{INDEX}" name="pd_id[{INDEX}]" class="form-control required" data-index="{INDEX}">
					<option value="">-- <?php __('lblChoose'); ?>--</option>
					<?php
					foreach($tpl['pd_arr'] as $v)
					{
						?><option value="<?php echo $v['id']?>"><?php echo pjSanitize::html($v['title']);?></option><?php
					} 
					?>
				</select>
			</div>
		</td>
		<td>
			<div class="form-inline first">
				<div class="form-group">
					<span class="mr-sm-2"><?php __('lblIfPickup');?></span>
					<input name="duration_pickup[{INDEX}]" class="form-control w60 {SPINNER} required digits" />
					<span><?php __('lblMins');?></span>
				</div>
			</div>
			<div class="form-inline">
				<div class="form-group">
					<span class="mr-sm-2"><?php __('lblIfDropoff');?></span>
					<input name="duration_dropoff[{INDEX}]" class="form-control w60 {SPINNER} required digits" />
					<span><?php __('lblMins');?></span>
				</div>
			</div>
		</td>
		<td>
			<div class="form-inline first">
				<div class="form-group">
					<span class="mr-sm-2"><?php __('lblIfPickup');?></span>
					<div class="input-group"> 
						<input type="text" name="price_pickup[{INDEX}]" class="form-control required"/> 
					
						<span class="input-group-addon"><?php echo pjCurrency::getCurrencySign($tpl['option_arr']['o_currency'], false) ?></span>
					</div>
				</div>
			</div>
			<div class="form-inline">
				<div class="form-group">
					<span class="mr-sm-2"><?php __('lblIfDropoff');?></span>
					<div class="input-group"> 
						<input type="text" name="price_dropoff[{INDEX}]" class="form-control required"/> 
					
						<span class="input-group-addon"><?php echo pjCurrency::getCurrencySign($tpl['option_arr']['o_currency'], false) ?></span>
					</div>
				</div>
			</div>
		</td>
		<td>
			<a href="#" class="btn btn-danger btn-outline btn-sm m-l-xs linkRemoveRow"><i class="fa fa-trash"></i></a>
		</td>
	</tr>
</table>

<script type="text/javascript">
var myLabel = myLabel || {};
var locale_array = new Array(); 
<?php
foreach ($tpl['lp_arr'] as $v)
{
	?>locale_array.push(<?php echo $v['id'];?>);<?php
}
?>
myLabel.locale_array = locale_array;
myLabel.field_required = <?php x__encode('tr_field_required', false, true); ?>;
myLabel.positive_number = <?php x__encode('lblPositiveNumber', false, true); ?>;
myLabel.isFlagReady = "<?php echo $tpl['is_flag_ready'] ? 1 : 0;?>";
myLabel.choose = <?php x__encode('lblChoose', false, true); ?>;
myLabel.alert_title = <?php x__encode('lblDeleteImage');?>;
myLabel.alert_text = <?php x__encode('lblDeleteConfirmation');?>;
<?php if ($tpl['is_flag_ready']) : ?>
var pjCmsLocale = pjCmsLocale || {};
pjCmsLocale.langs = <?php echo $tpl['locale_str']; ?>;
pjCmsLocale.flagPath = "<?php echo PJ_FRAMEWORK_LIBS_PATH; ?>pj/img/flags/";
<?php endif; ?>
</script>