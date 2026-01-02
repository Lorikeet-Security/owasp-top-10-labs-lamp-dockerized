<?php
$titles = __('error_titles', true);
$bodies = __('error_bodies', true);
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-6">
                <h2><?php echo __('infoUpdateLocationTitle', true);?></h2>
                <ol class="breadcrumb">
					<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminLocations&amp;action=pjActionIndex"><?php __('menuLocations'); ?></a></li>
					<li class="active">
						<strong><?php echo __('infoUpdateLocationTitle', true);?></strong>
					</li>
				</ol>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 btn-group-languages">
				<?php if ($tpl['is_flag_ready']) : ?>
				<div class="multilang"></div>
				<?php endif; ?>
			</div>
        </div>

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php echo __('infoUpdateLocationDesc', true); ?></p>
    </div>
</div>

<div class="row wrapper wrapper-content animated fadeInRight">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminLocations&amp;action=pjActionUpdate" method="post" id="frmUpdateLocation" class="form pj-form" autocomplete="off" enctype="multipart/form-data">
				<input type="hidden" name="action_update" value="1" />
				<input type="hidden" name="id" value="<?php echo $tpl['arr']['id'];?>" />
        		<input type="hidden" name="lat" value="<?php echo $tpl['arr']['lat'];?>" />
        		<input type="hidden" name="lng" value="<?php echo $tpl['arr']['lng'];?>" />
            	<div class="ibox-content">
            		<div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6">
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
                        <div class="col-lg-8 col-md-8 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblAddress');?></label>
								<?php
								foreach ($tpl['lp_arr'] as $v)
								{
									?>
									<div class="<?php echo $tpl['is_flag_ready'] ? 'input-group ' : NULL;?>pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 1 ? NULL : 'none'; ?>">
										<input type="text" class="form-control<?php echo (int) $v['is_default'] === 0 ? NULL : ' required'; ?>" id="i18n_<?php echo $v['id']; ?>_address" name="i18n[<?php echo $v['id']; ?>][address]" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['i18n'][$v['id']]['address'])); ?>" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>">	
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
					
                    <div class="row">
                    	<div class="col-lg-4 col-md-4 col-sm-6">
                    		<div class="form-group">
                                <label class="control-label"><?php __('lblType');?></label>
								<select name="type" id="type" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required');?>">
            						<option value="">-- <?php __('lblChoose'); ?> --</option>
            						<?php
            						foreach (__('location_types') as $k => $v)
            						{
            							?><option value="<?php echo $k; ?>"<?php echo $tpl['arr']['type']==$k ? ' selected="selected"' : NULL;?>><?php echo stripslashes($v); ?></option><?php
            						}
            						?>
            					</select>
                            </div>
                    	</div>
                    </div>
                    
					<div class="hr-line-dashed"></div>
                    
					<div class="clearfix">
						<button type="submit" class="ladda-button btn btn-primary btn-lg btn-phpjabbers-loader pull-left" data-style="zoom-in">
							<span class="ladda-label"><?php __('btnSave', false, true); ?></span>
							<?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
						</button>
	
						<button type="button" class="btn btn-white btn-lg pull-right" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminLocations&action=pjActionIndex';"><?php __('btnCancel'); ?></button>
					</div>
	            </div>
			</form>
        </div>
    </div>
</div>

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
<?php if ($tpl['is_flag_ready']) : ?>
var pjCmsLocale = pjCmsLocale || {};
pjCmsLocale.langs = <?php echo $tpl['locale_str']; ?>;
pjCmsLocale.flagPath = "<?php echo PJ_FRAMEWORK_LIBS_PATH; ?>pj/img/flags/";
<?php endif; ?>
</script>