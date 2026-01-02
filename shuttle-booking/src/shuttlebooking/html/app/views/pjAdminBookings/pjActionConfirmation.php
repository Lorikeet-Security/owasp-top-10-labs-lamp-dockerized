<?php
if (isset($tpl['arr']) && !empty($tpl['arr']))
{
    ?>
	<form action="" method="post" class="">
		<input type="hidden" name="send_email" value="1" />
		<input type="hidden" name="id" value="<?php echo $tpl['arr']['id']; ?>" />
		
		<div class="form-group">
			<label class="control-label"><?php __('lblReminderSubject');?></label>
			<input type="text" name="subject" id="confirm_subject" class="form-control required" value="<?php echo pjSanitize::html($tpl['arr']['subject']); ?>" />
		</div>
		<div class="form-group">
			<label class="control-label"><?php __('lblReminderMessage');?></label>
			<div id="crMessageEditorWrapper">
				<textarea name="message" id="mceEditor" class="form-control mceEditor required"><?php echo stripslashes(str_replace(array('\r\n', '\n'), '&#10;', $tpl['arr']['message'])); ?></textarea>
			</div>			
		</div>
		<?php if (!empty($tpl['arr']['client_email'])) : ?>
		<div class="form-group">
			<label class="control-label"><?php __('lblReminderTo'); ?> (<?php echo pjSanitize::html($tpl['arr']['client_email']); ?>)</label>
	
			<input type="hidden" name="to" value="<?php echo pjSanitize::html($tpl['arr']['client_email']); ?>"/>
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