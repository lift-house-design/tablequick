<div id="dashboard-controls">
	<div class="float-left">
		<?php echo anchor('#','Some Button',array('class'=>'button')) ?>
	</div>
	<div class="float-right">
		SOMETHING ON THE RIGHT
	</div>
</div>
<table id="customer-table">
	<thead>
		<tr>
			<th>Date/Time</th>
			<th>Patron Name</th>
			<th>Status</th>
			<th>Response</th>
			<th>Action</th>
			<th>Result</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo date('m/d/Y h:ia') ?></td>
			<td>Nick Niebaum</td>
			<td>Waiting</td>
			<td>ok on our way</td>
			<td>
				<?php echo anchor('#','Assign',array('class'=>'button')) ?>
				<?php echo anchor('#','Cancel',array('class'=>'button')) ?>
				<?php echo anchor('#','New Request',array('class'=>'button')) ?>
				<?php echo anchor('#','Move to Top',array('class'=>'button')) ?>
			</td>
		</tr>
	</tbody>
</table>