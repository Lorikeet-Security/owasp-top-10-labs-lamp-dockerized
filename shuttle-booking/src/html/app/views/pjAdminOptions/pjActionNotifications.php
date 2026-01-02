<?php 
$titles = __('error_titles', true);
$bodies = __('error_bodies', true);
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-6">
                <h2><?php __('script_infobox_notifications_title');?></h2>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 btn-group-languages">
				<?php if ($tpl['is_flag_ready']) : ?>
				<div class="multilang"></div>
				<?php endif; ?>
			</div>
        </div>

        <p class="m-b-none"><i class="fa fa-info-circle"></i><?php __('script_infobox_notifications_desc');?></p>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight" id="boxNotificationsWrapper">
	<div class="ibox float-e-margins settings-box">
		<div class="ibox-content ibox-heading">
			<h3><?php __('notifications_main_title'); ?></h3>
			<small><?php __('notifications_main_subtitle'); ?></small>
		</div>

		<div class="ibox-content">
			<div class="row">
				<div class="col-lg-3 col-sm-5">
					<div class="m-b-sm">
						<div class="row">
							<div class="col-sm-12">
							<h3><?php __('notifications_recipient'); ?></h3>
							</div>
						</div>
					</div>
			
					<div class="form-group">
						<div class="radio radio-primary">
							<input type="radio" id="recipient_client" name="recipient" value="client"<?php echo !isset($tpl['query']['recipient']) || $tpl['query']['recipient'] == 'client' ? ' checked' : NULL; ?>>
							<label for="recipient_client"><?php __('recipients_ARRAY_client'); ?></label>
						</div>
					</div>

					<div class="form-group">
						<div class="radio radio-primary">
							<input type="radio" id="recipient_admin" name="recipient" value="admin"<?php echo isset($tpl['query']['recipient']) && $tpl['query']['recipient'] == 'admin' ? ' checked' : NULL; ?>>
							<label for="recipient_admin"><?php __('recipients_ARRAY_admin'); ?></label>
						</div>
					</div>
				</div>

				<div class="col-lg-9 col-sm-7" id="boxNotificationsMetaData">
				
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-9" id="boxNotificationsContent">
		   
		</div>
	
		<div class="col-lg-3">
			<div class="ibox float-e-margins settings-box">
				<div class="ibox-content ibox-heading">
					<h3><?php __('notifications_tokens'); ?></h3>
	
					<small><?php __('notifications_tokens_note'); ?></small>
				</div>
	
				<div class="ibox-content">
					<div class="row">
						<div class="col-xs-6">
                            <div><small>{Title}</small></div>
                            <div><small>{FirstName}</small></div>
                            <div><small>{LastName}</small></div>
                            <div><small>{Email}</small></div>
                            <div><small>{Password}</small></div>
                            <div><small>{Phone}</small></div>
                            <div><small>{Notes}</small></div>
                            <div><small>{Country}</small></div>
                            <div><small>{City}</small></div>
                            <div><small>{State}</small></div>
                            <div><small>{Zip}</small></div>
                            <div><small>{Address}</small></div>
                            <div><small>{Company}</small></div>
                            <div><small>{DateTime}</small></div>
                            <div><small>{ReturnDateTime}</small></div>
                            <div><small>{From}</small></div>
                            <div><small>{To}</small></div>
                        </div>
                        <div class="col-xs-6">
                            <div><small>{Line}</small></div>
                            <div><small>{ReturnLine}</small></div>                            
                            <div><small>{Passengers}</small></div>
                            <div><small>{Distance}</small></div>
                            <div><small>{Duration}</small></div>
                            <div><small>{ReturnDuration}</small></div>
                            <div><small>{UniqueID}</small></div>
                            <div><small>{SubTotal}</small></div>
                            <div><small>{Tax}</small></div>
                            <div><small>{Total}</small></div>
                            <div><small>{Deposit}</small></div>
                            <div><small>{Airline}</small></div>
                            <div><small>{FlightNumber}</small></div>
                            <div><small>{ArrivalTime}</small></div>
                            <div><small>{Terminal}</small></div>
                            <div><small>{PaymentMethod}</small></div>
                            <div><small>{CancelURL}</small></div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php if ($tpl['is_flag_ready']) : ?>
<script type="text/javascript">
var pjCmsLocale = pjCmsLocale || {};
pjCmsLocale.langs = <?php echo $tpl['locale_str']; ?>;
pjCmsLocale.flagPath = "<?php echo PJ_FRAMEWORK_LIBS_PATH; ?>pj/img/flags/";
</script>
<?php endif; ?>