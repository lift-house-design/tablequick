<h1>Notify Customer</h1>
<?php echo form_open('',array('id'=>'notify-customer'),array('id'=>$patron['id'])) ?>
	<p>Are you sure you want to send the customer <strong><?php echo $patron['name'] ?></strong> a text message notifying them that their table is ready?</p>
	<div class="buttons">
		<?php echo form_submit('notify_customer', 'Send Text Message Notification') ?>
		<?php echo anchor('#','Cancel',array('class'=>'close button')) ?>
	</div>
<?php echo form_close() ?>
