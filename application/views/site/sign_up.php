<h1>Sign Up</h1>
<p>Fill in the form below for your free 30-day trial! During your trial, you may use TableQuick as you would a normal user. At the end of your trial period, your account will be billed according to your usage of the service and you may choose to pay to continue using the service, or disregard it and your account will eventually be removed.</p>
<?php echo form_open('sign-up',array('class'=>'aligned')) ?>
	<?php echo form_field('E-mail','email','text',array(
		'value'=>set_value('email'),
	)) ?>
	<?php echo form_field('First Name','first_name','text',array(
		'value'=>set_value('first_name'),
	)) ?>
	<?php echo form_field('Last Name','last_name','text',array(
		'value'=>set_value('last_name'),
	)) ?>
	<?php echo form_field('Phone','phone','text',array(
		'value'=>set_value('phone'),
	)) ?>
	<?php echo form_field('Password','password','password') ?>
</form>