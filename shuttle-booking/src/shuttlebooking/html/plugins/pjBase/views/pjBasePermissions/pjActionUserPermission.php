<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-10">
                <h2><?php __('plugin_base_infobox_user_permissions_title'); ?> <?php echo pjSanitize::html($tpl['user']['name']); ?></h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseUsers&amp;action=pjActionIndex"><?php __('plugin_base_infobox_users_title'); ?></a>
                    </li>
                    <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseUsers&amp;action=pjActionUpdate&amp;id=<?php echo $tpl['user']['id']; ?>"><?php __('plugin_base_infobox_update_user_title'); ?></a></li>
                    <li class="active">
                        <strong><?php __('plugin_base_infobox_permissions_title'); ?></strong>
                    </li>
                </ol>
            </div>
        </div><!-- /.row -->

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php __('plugin_base_infobox_user_permissions_desc');?></p>
    </div><!-- /.col-md-12 -->
</div>

<div class="row wrapper wrapper-content animated fadeInRight">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div id="loader" class="sk-spinner sk-spinner-double-bounce"><div class="sk-double-bounce1"></div><div class="sk-double-bounce2"></div></div>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBasePermisssions&amp;action=pjActionRolePermission" method="post" id="frmRolePermission" class="form-horizontal" autocomplete="off">
                    <input type="hidden" id="user_id" name="user_id" value="<?php echo pjSanitize::html($tpl['user']['id']);?>" />

                    <div class="form-group">
                        <div class="col-md-4">
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBasePermisssions&amp;action=pjActionResetPermission" class="btn btn-warning btn-outline" id="btnResetPermission"><i class="fa fa-key"></i> <?php __('plugin_base_reset_permissions') ?></a>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <?php
                    list($column_one, $column_two) = array_chunk($tpl['arr'], ceil(count($tpl['arr']) / 2));
                    $arr[] = $column_one;
                    $arr[] = $column_two;
                    
                    $api_keys_arr = array();
                    if (isset($GLOBALS['CONFIG'], $GLOBALS['CONFIG']["api_keys"])
                        && is_array($GLOBALS['CONFIG']["api_keys"])
                        && !empty($GLOBALS['CONFIG']["api_keys"]))
                    {
                        $api_keys_arr = $GLOBALS['CONFIG']["api_keys"];
                    }
                    ?>
                    <div class="row">
                        <?php
                        foreach($arr as $column)
                        {
                            ?>
                            <div class="col-md-6">
                                <?php
                                foreach($column as $first)
                                {
                                    if((int) $first['inherit_id'] > 0)
                                    {
                                        continue;
                                    }
                                    ?>
                                    <div class="dd">
                                        <ol class="dd-list">
                                            <li class="dd-item">
                                                <div class="dd-handle">
                                                    <div class="clearfix">
                                                        <label class="pull-left m-t-xs"><?php __($first['key']);?></label>

                                                        <div class="pull-right m-t-xs">
                                                            <div class="switch onoffswitch-data">
                                                                <div class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox"<?php echo in_array($first['id'], $tpl['permission_id_arr']) ? ' checked' : NULL;?> name="permission_<?php echo $first['id'];?>" id="permission_<?php echo $first['id'];?>" data-id="<?php echo $first['id'];?>">
                                                                    <label class="onoffswitch-label" for="permission_<?php echo $first['id'];?>">
                                                                        <span class="onoffswitch-inner" data-on="<?php __('plugin_base_yesno_ARRAY_T', false, true); ?>" data-off="<?php __('plugin_base_yesno_ARRAY_F', false, true); ?>"></span>
                                                                        <span class="onoffswitch-switch"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php
                                                if(isset($tpl['second_level'][$first['id']]) && !empty($tpl['second_level'][$first['id']]))
                                                {
                                                    $second_level = $tpl['second_level'][$first['id']];
                                                    ?>
                                                    <ol class="dd-list permission-row-<?php echo $first['id'];?>"style="display:<?php echo in_array($first['id'], $tpl['permission_id_arr']) ? 'block' : 'none';?>;">
                                                        <?php
                                                        foreach($second_level as $second)
                                                        {
                                                            if($second['key'] == 'pjBaseOptions_pjActionApiKeys' && $api_keys_arr['google_api_key'] == false)
                                                            {
                                                                continue;
                                                            }
                                                            ?>
                                                            <li class="dd-item">
                                                                <div class="dd-handle clearfix">
                                                                    <label class="pull-left m-t-xs"><?php __($second['key']);?></label>
                                                                
                                                                    <div class="pull-right m-t-xs">
                                                                        <div class="switch onoffswitch-data">
                                                                            <div class="onoffswitch">
                                                                                <input type="checkbox" class="onoffswitch-checkbox"<?php echo in_array($second['id'], $tpl['permission_id_arr']) ? ' checked' : NULL;?> name="permission_<?php echo $second['id'];?>" id="permission_<?php echo $second['id'];?>" data-id="<?php echo $second['id'];?>">
                                                                                <label class="onoffswitch-label" for="permission_<?php echo $second['id'];?>">
                                                                                    <span class="onoffswitch-inner" data-on="<?php __('plugin_base_yesno_ARRAY_T', false, true); ?>" data-off="<?php __('plugin_base_yesno_ARRAY_F', false, true); ?>"></span>
                                                                                    <span class="onoffswitch-switch"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div><!-- /.dd-handle -->

                                                                <?php
                                                                if(isset($tpl['third_level'][$second['id']]) && !empty($tpl['third_level'][$second['id']]))
                                                                {
                                                                    $third_level = $tpl['third_level'][$second['id']];
                                                                    ?>
                                                                    <ol class="dd-list permission-row-<?php echo $second['id'];?>" style="display:<?php echo in_array($second['id'], $tpl['permission_id_arr']) ? 'block' : 'none';?>;">
                                                                        <li class="dd-item">
                                                                            <?php
                                                                            foreach($third_level as $third)
                                                                            {
                                                                                ?>
                                                                                <div class="dd-handle clearfix">
                                                                                    <label class="pull-left m-t-xs"><?php __($third['key']);?></label>
                                                                                
                                                                                    <div class="pull-right m-t-xs">
                                                                                        <div class="switch onoffswitch-data">
                                                                                            <div class="onoffswitch">
                                                                                                <input type="checkbox" class="onoffswitch-checkbox"<?php echo in_array($third['id'], $tpl['permission_id_arr']) ? ' checked' : NULL;?> name="permission_<?php echo $third['id'];?>" id="permission_<?php echo $third['id'];?>" data-id="<?php echo $third['id'];?>">
                                                                                                <label class="onoffswitch-label" for="permission_<?php echo $third['id'];?>">
                                                                                                    <span class="onoffswitch-inner" data-on="<?php __('plugin_base_yesno_ARRAY_T', false, true); ?>" data-off="<?php __('plugin_base_yesno_ARRAY_F', false, true); ?>"></span>
                                                                                                    <span class="onoffswitch-switch"></span>
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </li>
                                                                    </ol>
                                                                    <?php
                                                                }

                                                                ?>
                                                            
                                                            </li>

                                                            <?php
                                                        }
                                                        ?>
                                                    </ol>
                                                    <?php
                                                }

                                                ?>
                                            </li>
                                        </ol>

                                        <div class="hr-line-dashed"></div>
                                    </div>

                                    <?php 
                                }
                                ?>
                            </div><!-- /.col-md-6 -->
                            <?php
                        }
                        ?>
                    </div><!-- /.row -->
                </form>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->
</div>

<script type="text/javascript">
var myLabel = myLabel || {};
myLabel.reset_permission_title = <?php x__encode('plugin_base_reset_user_permissions_title'); ?>;
myLabel.reset_permission_text = <?php x__encode('plugin_base_reset_user_permissions_text'); ?>;
myLabel.btn_reset = <?php x__encode('plugin_base_btn_reset'); ?>;
myLabel.btn_cancel = <?php x__encode('plugin_base_btn_cancel'); ?>;
</script>