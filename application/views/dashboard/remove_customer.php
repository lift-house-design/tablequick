<h1>Remove Customer</h1>
<?php echo form_open('',array('id'=>'remove-customer'),array('id'=>$patron['id'])) ?>
	<p>Are you sure you want to remove customer <strong><?php echo $patron['name'] ?></strong>?</p>
	<div class="buttons">
		<?php echo form_submit('remove_customer', 'Remove Customer') ?>
		<?php echo anchor('#','Cancel',array('class'=>'close button')) ?>
	</div>
<?php echo form_close() ?>
