<?php
if (isset($tpl['arr']) && !empty($tpl['arr']))
{
    ?>
	<form action="" method="post" class="">
		<input type="hidden" name="send_sms" value="1" />
		<input type="hidden" name="id" value="<?php echo $tpl['arr']['id']; ?>" />
		
		<div class="form-group">
			<label class="control-label"><?php __('lblReminderMessage');?></label>
			<div id="crMessageEditorWrapper">
				<textarea name="message" id="mceEditor" rows="5" class="form-control required"><?php echo stripslashes(str_replace(array('\r\n', '\n'), '&#10;', $tpl['arr']['message'])); ?></textarea>
			</div>			
		</div>
		<?php if (!empty($tpl['arr']['client_phone'])) : ?>
		<div class="form-group">
			<label class="control-label"><?php __('lblReminderTo'); ?> (<?php echo pjSanitize::html($tpl['arr']['client_phone']); ?>)</label>
	
			<input type="hidden" name="to" value="<?php echo pjSanitize::html($tpl['arr']['client_phone']); ?>"/>
		</div>
		<?php endif; ?>
	</form>
	<?php
}else{
    ?>
    <div id="pjResendAlert" class="alert alert-warning">
   		<?php __('lblEmailNotificationNotSet')?>
    </div>
    <?php    
}
?>