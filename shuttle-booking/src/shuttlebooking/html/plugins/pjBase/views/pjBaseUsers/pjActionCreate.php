<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-10">
                <h2><?php __('plugin_base_infobox_add_user_title');?></h2>
                <ol class="breadcrumb">
					<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseUsers&amp;action=pjActionIndex"><?php __('plugin_base_menu_users'); ?></a></li>
					<li class="active">
						<strong><?php __('plugin_base_infobox_add_user_title');?></strong>
					</li>
				</ol>
            </div>
        </div><!-- /.row -->

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php __('plugin_base_infobox_add_user_desc');?></p>
    </div><!-- /.col-md-12 -->
</div>

<div class="row wrapper wrapper-content animated fadeInRight">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseUsers&amp;action=pjActionCreate" method="post" id="frmCreateUser" autocomplete="off">
					<input type="hidden" name="user_create" value="1" />
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('plugin_base_status');?></label>

                                <div class="clearfix">
                                    <div class="switch onoffswitch-data pull-left">
                                        <div class="onoffswitch">
                                            <input type="checkbox" class="onoffswitch-checkbox" id="status" name="status" checked>
                                            <label class="onoffswitch-label" for="status">
                                                <span class="onoffswitch-inner" data-on="<?php __('plugin_base_filter_ARRAY_active', false, true); ?>" data-off="<?php __('plugin_base_filter_ARRAY_inactive', false, true); ?>"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div><!-- /.clearfix -->
                            </div><!-- /.form-group -->
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('plugin_base_role');?></label>

                                <select name="role_id" id="role_id" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>">
    								<option value="">-- <?php __('plugin_base_choose');?>--</option>
    								<?php
    								foreach (__('plugin_base_role_arr', true) as $k => $v)
    								{
    									?><option value="<?php echo $k; ?>"><?php echo pjSanitize::html($v); ?></option><?php
    								}
    								?>
    							</select>
                            </div>
                        </div><!-- /.col-md-3 -->
                    </div><!-- /.row -->

                    <div class="hr-line-dashed"></div>

                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('plugin_base_email');?></label>

                                <div class="input-group">
    								<span class="input-group-addon"><i class="fa fa-at"></i></span>
    								<input type="text" name="email" id="email" class="form-control required email" maxlength="255" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" data-msg-email="<?php __('plugin_base_email_invalid', false, true);?>" data-msg-remote="<?php __('plugin_base_email_in_used', false, true);?>">
    							</div>
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('plugin_base_password');?></label>

                                <div class="input-group">
    								<span class="input-group-addon"><i class="fa fa-lock"></i></span> 
    								<input type="text" name="password" id="password" class="form-control required" maxlength="100" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>">
    							</div>
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('plugin_base_name');?></label>

                                <input type="text" name="name" id="name" class="form-control required" maxlength="255" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>">
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('plugin_base_phone');?></label>

                                <div class="input-group">
    								<span class="input-group-addon"><i class="fa fa-phone"></i></span> 
    								<input type="text" name="phone" id="phone" class="form-control" maxlength="255">
    							</div>
                            </div>
                        </div><!-- /.col-md-3 -->
                    </div><!-- /.row -->

                    <div class="hr-line-dashed"></div>
                    <div class="clearfix">
                        <button type="submit" class="ladda-button btn btn-primary btn-lg btn-phpjabbers-loader pull-left" data-style="zoom-in">
                            <span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
                            <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                        </button>

                        <button type="button" class="btn btn-white btn-lg pull-right" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjBaseUsers&action=pjActionIndex';"><?php __('plugin_base_btn_cancel'); ?></button>
                    </div><!-- /.clearfix -->
                </form>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->
</div>

<script type="text/javascript">
var myLabel = myLabel || {};
myLabel.invalid_password_title = <?php x__encode('plugin_base_invalid_password_title'); ?>;
myLabel.btn_ok = <?php x__encode('plugin_base_btn_ok'); ?>;
</script>