<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-10">
                <h2><?php __('infoAddClientTitle', false, true);?></h2>
            </div>
        </div><!-- /.row -->

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php __('infoAddClientDesc', false, true);?></p>
    </div><!-- /.col-md-12 -->
</div>
<?php
$u_statarr = __('u_statarr', true)
?>
<div class="row wrapper wrapper-content animated fadeInRight">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminClients&amp;action=pjActionCreate" method="post" id="frmCreateClient">
                	<input type="hidden" name="client_create" value="1" />
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblStatus'); ?></label>

                                <div class="clearfix">
                                    <div class="switch onoffswitch-data pull-left">
                                        <div class="onoffswitch">
                                            <input type="checkbox" class="onoffswitch-checkbox" id="status" name="status" checked>
                                            <label class="onoffswitch-label" for="status">
                                                <span class="onoffswitch-inner" data-on="<?php echo $u_statarr['T'];?>" data-off="<?php echo $u_statarr['F'];?>"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div><!-- /.clearfix -->
                            </div><!-- /.form-group -->
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingTitle'); ?></label>

                                <select name="title" id="title" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>">
                					<option value="">-- <?php __('lblChoose'); ?>--</option>
                					<?php
                					$name_titles = __('personal_titles', true, false);
                					foreach ($name_titles as $k => $v)
                					{
                						?><option value="<?php echo $k; ?>"><?php echo $v; ?></option><?php
                					}
                					?>
                				</select>
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingFname'); ?></label>

                                <input type="text" id="fname" name="fname" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" maxlength="255">
                            </div>
                        </div><!-- /.col-md-3 -->
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingLname'); ?></label>

                                <input type="text" id="lname" name="lname" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" maxlength="255">
                            </div>
                        </div><!-- /.col-md-3 -->
                    </div><!-- /.row -->

                    <div class="hr-line-dashed"></div>

                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('email'); ?></label>

								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-at"></i></span>
                                	<input type="text" name="email" id="email" class="form-control email required" placeholder="info@domain.com" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" maxlength="255">
                                </div>
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('pass'); ?></label>
								
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                	<input type="text" name="password" id="password" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" maxlength="255">
                                </div>
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblPhone'); ?></label>
								
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                	<input type="text" name="phone" id="phone" class="form-control" placeholder="(123) 456-7890" maxlength="255">
                                </div>
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingCompany'); ?></label>

                                <input type="text" name="company" id="company" class="form-control" maxlength="255">
                            </div>
                        </div><!-- /.col-md-3 -->
                    </div><!-- /.row -->

                    <div class="hr-line-dashed"></div>
                    
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingAddress'); ?></label>

                                <input type="text" name="address" id="address" class="form-control" maxlength="255">
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingCity'); ?></label>

                                <input type="text" name="city" id="city" class="form-control" maxlength="255">
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingState'); ?></label>

                                <input type="text" name="state" id="state" class="form-control" maxlength="255">
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingZip'); ?></label>

                                <input type="text" name="zip" id="zip" class="form-control" maxlength="255">
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingCountry'); ?></label>

                                <select name="country_id" id="country_id" class="form-control select-item">
                					<option value="">-- <?php __('lblChoose'); ?>--</option>
                					<?php
                					foreach ($tpl['country_arr'] as $v)
                					{
                						?><option value="<?php echo $v['id']; ?>"><?php echo pjSanitize::html($v['country_title']); ?></option><?php
                					}
                					?>
                				</select>
                            </div>
                        </div><!-- /.col-md-3 -->
                    </div><!-- /.row -->

                    <div class="hr-line-dashed"></div>

                    <div class="clearfix">
                        <button type="submit" class="ladda-button btn btn-primary btn-lg btn-phpjabbers-loader pull-left" data-style="zoom-in" style="margin-right: 15px;">
                            <span class="ladda-label"><?php __('btnSave'); ?></span>
                            <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                        </button>
                        <a class="btn btn-white btn-lg pull-right" href="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminClients&action=pjActionIndex"><?php __('btnCancel'); ?></a>
                    </div><!-- /.clearfix -->
                </form>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->
</div>
<script type="text/javascript">
var myLabel = myLabel || {};
myLabel.email_exists = <?php x__encode('email_taken'); ?>;
myLabel.choose = <?php x__encode('lblChoose'); ?>;
</script>