<h1>Forgotten Password</h1>
<p>Enter your e-mail address below and you will be sent a link to retrieve your password.</p>
<?php echo form_open('forgot-password',array('class'=>'aligned')) ?>
	<?php echo form_field('E-mail','email','text',array(
		'value'=>set_value('email'),
		'required'=>TRUE,
	)) ?>
	<div class="buttons">
		<?php echo form_submit('retrieve_password', 'Retrieve Password') ?>
	</div>
<?php echo form_close() ?>