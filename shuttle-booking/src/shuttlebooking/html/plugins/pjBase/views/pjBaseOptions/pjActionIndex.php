<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-10">
				<h2><?php __('plugin_base_infobox_general_title'); ?></h2>
			</div>
		</div>
		<p class="m-b-none"><i class="fa fa-info-circle"></i><?php __('plugin_base_infobox_general_desc'); ?></p>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<?php
	$error_code = $controller->_get->toString('err');
	if (!empty($error_code))
    {
    	$titles = __('plugin_base_error_titles', true);
    	$bodies = __('plugin_base_error_bodies', true);
    	switch (true)
    	{
    		case in_array($error_code, array('PBS01')):
    			?>
    			<div class="alert alert-success">
    				<i class="fa fa-check m-r-xs"></i>
    				<strong><?php echo @$titles[$error_code]; ?></strong>
    				<?php echo @$bodies[$error_code]?>
    			</div>
    			<?php 
    			break;
    		case in_array($error_code, array('')):	
    			?>
    			<div class="alert alert-danger">
    				<i class="fa fa-exclamation-triangle m-r-xs"></i>
    				<strong><?php echo @$titles[$error_code]; ?></strong>
    				<?php echo @$bodies[$error_code]?>
    			</div>
    			<?php
    			break;
    	}
    }
    ?>
    <div class="row">
    	<div class="col-lg-12">
    		<div class="ibox float-e-margins">
    			<div class="ibox-content">
    				<?php
    				if (isset($tpl['arr']) && is_array($tpl['arr']) && !empty($tpl['arr']))
    				{
                        ?>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseOptions&amp;action=pjActionOptionsUpdate" method="post" class="form-horizontal" id="frmGeneral">
                            <input type="hidden" name="options_update" value="1" />
                            <input type="hidden" name="next_action" value="pjActionIndex" />
                            <?php
                            foreach ($tpl['arr'] as $i => $option)
                            {
                                ?>
                                <div class="form-group">

                                    <label class="col-sm-3 control-label"><?php __('plugin_base_opt_' . $option['key']); ?></label>
                                    <div class="col-sm-9">
                                        <?php
                                        switch ($option['type'])
                                        {
                                            case 'string':
                                                if($option['key'] != 'o_timezone')
                                                {
                                                    ?><input type="text" name="value-<?php echo $option['type']; ?>-<?php echo $option['key']; ?>" class="form-control" value="<?php echo pjSanitize::html($option['value']); ?>"><?php
                                                }else{
                                                    $locations = array();
                                                    $zones = timezone_identifiers_list();
                                                    foreach ($zones as $zone_name)
                                                    {
                                                        $zone = explode('/', $zone_name);
                                                        if(in_array($zone[0], array('Africa','America','Antarctica','Arctic','Asia','Atlantic','Australia','Europe','Indian','Pacific')))
                                                        {
                                                            $location_keys = array();
                                                            $location_keys[] = $zone[0];
                                                            if (isset($zone[1]) != '')
                                                            {
                                                                $location_keys[] = $zone[1];
                                                                if (isset($zone[2]) != '')
                                                                {
                                                                    $location_keys[] = $zone[2];
                                                                    $locations[$zone[0]][join('/', $location_keys)] = str_replace('_', ' ', $zone[1] . '/' . $zone[2]) . ' (UTC' . pjTimezone::getTimezoneOffset($zone_name) . ')';
                                                                }else{
                                                                    $locations[$zone[0]][join('/', $location_keys)] = str_replace('_', ' ', $zone[1]) . ' (UTC' . pjTimezone::getTimezoneOffset($zone_name) . ')';
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <select name="value-<?php echo $option['type']; ?>-<?php echo $option['key']; ?>" class="form-control">
                                                        <?php
                                                        foreach($locations as $continent => $cities)
                                                        {
                                                            ?>
                                                            <optgroup label="<?php echo pjSanitize::html($continent);?>">
                                                                <?php
                                                                foreach($cities as $pair => $city)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $pair;?>"<?php echo $option['value'] == $pair ? ' selected="selected"' : NULL;?>><?php echo $city;?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </optgroup>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php
                                                }
                                                break;
                                            case 'text':
                                                ?><textarea name="value-<?php echo $option['type']; ?>-<?php echo $option['key']; ?>" class="form-control"><?php echo pjSanitize::html($option['value']); ?></textarea><?php
                                                break;
                                            case 'int':
                                                ?><input type="text" name="value-<?php echo $option['type']; ?>-<?php echo $option['key']; ?>" class="form-control field-int" value="<?php echo pjSanitize::html($option['value']); ?>"><?php
                                                break;
                                            case 'float':
                                                ?><input type="text" name="value-<?php echo $option['type']; ?>-<?php echo $option['key']; ?>" class="form-control field-float number" value="<?php echo number_format($option['value'], 2) ?>"><?php
                                                break;
                                            case 'enum':
                                                ?><select name="value-<?php echo $option['type']; ?>-<?php echo $option['key']; ?>" class="form-control">
                                                <?php
                                                $default = explode("::", $option['value']);
                                                $enum = explode("|", $default[0]);

                                                $enumLabels = array();
                                                if ($option['key'] == 'o_currency_place') {
                                                    $currency_places = __('plugin_base_currency_places', true);
                                                    $enumLabels = array($currency_places['front'], $currency_places['back']);
                                                } else {
                                                    if (!empty($option['label']) && strpos($option['label'], "|") !== false)
                                                    {
                                                        $enumLabels = explode("|", $option['label']);
                                                    }
                                                }
                                                $enum_arr = array();
                                                if($option['key'] == 'o_week_start')
                                                {
                                                    $enum_arr = __('days', true);
                                                }
                                                foreach ($enum as $k => $el)
                                                {
                                                    if ($default[1] == $el)
                                                    {
                                                        ?><option value="<?php echo $default[0].'::'.$el; ?>" selected="selected"><?php echo isset($enum_arr[$el]) ? $enum_arr[$el] : (array_key_exists($k, $enumLabels) ? pjSanitize::html($enumLabels[$k]) : pjSanitize::html($el)); ?></option><?php
                                                    } else {
                                                        ?><option value="<?php echo $default[0].'::'.$el; ?>"><?php echo isset($enum_arr[$el]) ? $enum_arr[$el] : (array_key_exists($k, $enumLabels) ? pjSanitize::html($enumLabels[$k]) : pjSanitize::html($el)); ?></option><?php
                                                    }
                                                }
                                                ?>
                                                </select>
                                                <?php
                                                break;
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="hr-line-dashed"></div>
                            <div class="clearfix">
                                <button class="ladda-button btn btn-primary btn-lg pull-left btn-phpjabbers-loader" data-style="zoom-in">
                                    <span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
                                    <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                                </button>
                            </div>
                        </form>
                        <?php
    				}
    				?>
    			</div><!-- /.ibox-content -->
    		</div><!-- /.ibox float-e-margins -->
    	</div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.wrapper wrapper-content animated fadeInRight -->