<h1>New Customer</h1>
<?php echo form_open('',array('id'=>'new-customer')) ?>
	<?php echo form_field('Name','name','text',array(
		'required'=>TRUE,
		'value'=>isset($patron) ? $patron['name'] : '',
	)) ?>
	<?php echo form_field('Phone','phone','phone',array(
		'required'=>TRUE,
		'confirm_sms'=>FALSE,
		'value'=>isset($patron) ? $patron['phone'] : '',
	)) ?>
	<?php echo form_field('Time In','time_in','readonly',array(
		'value'=>date('Y-m-d H:i:s'),
		'display'=>date('m/d/Y / h:ia'),
	)) ?>
	<div class="buttons">
		<?php echo form_submit('add_customer', 'Add Customer') ?>
		<?php echo anchor('#','Cancel',array('class'=>'close button')) ?>
	</div>
<?php echo form_close() ?>