<?php
if (isset($tpl['arr']) && !empty($tpl['arr']))
{
	?>
	<div class="form pj-form">
		<p>
			<label class="title bold"><?php __('plugin_stripe_foreign_id'); ?></label>
			<span class="left"><?php echo $tpl['arr']['foreign_id']; ?></span>
		</p>
		<p>
			<label class="title bold"><?php __('plugin_stripe_stripe_id'); ?></label>
			<span class="left"><?php echo $tpl['arr']['stripe_id']; ?></span>
		</p>
		<p>
			<label class="title bold"><?php __('plugin_stripe_token'); ?></label>
			<span class="left"><?php echo $tpl['arr']['token']; ?></span>
		</p>
		<p>
			<label class="title bold"><?php __('plugin_stripe_amount'); ?></label>
			<span class="left"><?php echo $tpl['arr']['amount']; ?></span>
		</p>
		<p>
			<label class="title bold"><?php __('plugin_stripe_currency'); ?></label>
			<span class="left"><?php echo $tpl['arr']['currency']; ?></span>
		</p>
		<p>
			<label class="title bold"><?php __('plugin_stripe_description'); ?></label>
			<span class="left"><?php echo $tpl['arr']['description']; ?></span>
		</p>
		<p>
			<label class="title bold"><?php __('plugin_stripe_created'); ?></label>
			<span class="left"><?php echo $tpl['arr']['created']; ?></span>
		</p>
	</div>
	<?php
}
?>