<h1>Cancel Customer</h1>
<?php echo form_open('',array('id'=>'cancel-customer'),array('id'=>$patron['id'])) ?>
	<p>Are you sure you want to cancel customer <strong><?php echo $patron['name'] ?></strong>?</p>
	<div class="buttons">
		<?php echo form_submit('cancel_customer', 'Cancel Customer') ?>
		<?php echo anchor('#','Cancel',array('class'=>'close button')) ?>
	</div>
<?php echo form_close() ?>
