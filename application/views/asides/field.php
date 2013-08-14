<div class="field">
	<?php echo form_label($label, $name) ?>
	<div class="element">
	<?php switch($type):
		/*
		|--------------------------------------------------------------------------
		| Phone
		|--------------------------------------------------------------------------
		*/
			case 'phone': ?>
				<?php echo call_user_func('form_'.$type,$params) ?>
				<div class="checkbox field">
					<?php echo form_checkbox(array(
						'checked'=>$data['phone_text_capable'],
					)) ?>
					<?php echo form_label('Is this phone text capable?','phone_text_capable') ?>
				</div>
			<?php break; ?>
	    <?php case '': ?>

			<?php break; ?>
		<?php
		/*
		|--------------------------------------------------------------------------
		| Default: Text
		|--------------------------------------------------------------------------
		*/
		?>
		<?php default: ?>
			<?php echo call_user_func('form_'.$type,$params) ?>
			<?php break; ?>
	<?php endswitch; ?>
	</div>
</div>

<div class="field">
	<?php echo form_label('Phone','phone') ?>
	<div class="element">


	</div>
</div>