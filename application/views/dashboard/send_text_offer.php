<h1><?=$message?></h1>
<?php echo form_open('',array('id'=>'form-send-offer')) ?>
	<?php echo form_field('Text','text','textarea',array(
		'required'=>TRUE
	)) ?>
	<div class="buttons">
		<?php echo form_submit('send', 'Send Text') ?>
		<?php echo anchor('#','Cancel',array('class'=>'close button')) ?>
	</div>
<?php echo form_close() ?>