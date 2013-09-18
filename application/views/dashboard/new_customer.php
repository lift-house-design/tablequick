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
	<?php echo form_field('Party Size','party_size','text',array(
		'required'=>TRUE,
		'value'=>isset($patron) ? $patron['party_size'] : '',
	)) ?>

	<?= form_field('Table Location','table_location','text',array(
		'value'=>isset($patron) ? $patron['table_location'] : '',
	)) ?>
	<div class="field">
		<label for="special_seating">Special Seating</label>
		<?php echo form_dropdown(
			'special_seating',
			array(''=>'','High Chair'=>'High Chair','Strap'=>'Strap','Booster'=>'Booster','Wheel Chair'=>'Wheel Chair','See Notes'=>'See Notes'),
			(isset($patron) ? $patron['party_size'] : '')
		) ?>
	</div>
	<?= form_field('Notes','notes','text',array(
		'value'=>isset($patron) ? $patron['table_location'] : '',
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