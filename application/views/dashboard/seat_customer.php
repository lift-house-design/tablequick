<h1>Seat Customer</h1>
<?php echo form_open('',array('id'=>'seat-customer'),array('id'=>$patron['id'])) ?>
<p>Enter the table number for customer <strong><?php echo $patron['name'] ?></strong>.</p>
	<?php echo form_field('Table Number','table_number','text',array(
		'required'=>TRUE,
	)) ?>
	<div class="buttons">
		<?php echo form_submit('seat_customer', 'Seat Customer') ?>
		<?php echo anchor('#','Cancel',array('class'=>'close button')) ?>
	</div>
<?php echo form_close() ?>