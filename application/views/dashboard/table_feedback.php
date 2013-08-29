<? foreach($nav_pages as $url => $page){
		echo anchor('/dashboard'.$url, $page['name'],array('class'=>'button button-nav '.$page['active']));
	} ?>

<hr/>

<?php echo anchor('/dashboard/new_customer','New Customer',array('class'=>'new-customer button float-right')) ?>
<?php echo anchor('/dashboard/next_customer','Seat Next Customer',array('class'=>'seat-next-customer primary button float-right')) ?>
<table id="customer-table">
	<thead>
		<tr>
			<th>ID</td>
			<th class="datetime">Date/Time</th>
			<th class="patron-name">Patron Name</th>
			<th class="status">Status</th>
			<th class="response">Response</th>
			<th class="table">Table #</th>
			<th class="actions">Action</th>
		</tr>
	</thead>
	<tbody>
		<!--tr class="status-waiting">
			<td class="datetime"><?php echo date('m/d/Y / h:ia') ?></td>
			<td class="patron-name">Nick Niebaum</td>
			<td class="status">Waiting</td>
			<td class="response"></td>
			<td class="table">-</td>
			<td class="actions">
				<?php echo anchor('#','Seat Now',array('class'=>'seat-now button green')) ?>
				<?php echo anchor('#','Seat Ready',array('class'=>'seat-ready button blue')) ?>
				<?php echo anchor('#','Cancel',array('class'=>'cancel button')) ?>
				<?php echo anchor('#','New Request',array('class'=>'new-request button')) ?>
				<?php echo anchor('#','Remove',array('class'=>'remove button red')) ?>
			</td>
		</tr>
		<tr class="status-notified">
			<td class="datetime"><?php echo date('m/d/Y / h:ia') ?></td>
			<td class="patron-name">Nick Niebaum</td>
			<td class="status">Notified</td>
			<td class="response"></td>
			<td class="table">-</td>
			<td class="actions">
				<?php echo anchor('#','Seat Now',array('class'=>'seat-now button green')) ?>
				<?php echo anchor('#','Seat Ready',array('class'=>'seat-ready button blue')) ?>
				<?php echo anchor('#','Cancel',array('class'=>'cancel button')) ?>
				<?php echo anchor('#','New Request',array('class'=>'new-request button')) ?>
				<?php echo anchor('#','Remove',array('class'=>'remove button red')) ?>
			</td>
		</tr>
		<tr class="status-cancelled">
			<td class="datetime"><?php echo date('m/d/Y / h:ia') ?></td>
			<td class="patron-name">Somiyah Said</td>
			<td class="status">Cancelled</td>
			<td class="response">cancel bar</td>
			<td class="table">-</td>
			<td class="actions">
				<?php echo anchor('#','Seat Now',array('class'=>'seat-now button green')) ?>
				<?php echo anchor('#','Seat Ready',array('class'=>'seat-ready button blue')) ?>
				<?php echo anchor('#','Cancel',array('class'=>'cancel button')) ?>
				<?php echo anchor('#','New Request',array('class'=>'new-request button')) ?>
				<?php echo anchor('#','Remove',array('class'=>'remove button red')) ?>
			</td>
		</tr>
		<tr class="status-seated">
			<td class="datetime"><?php echo date('m/d/Y / h:ia') ?></td>
			<td class="patron-name">Nick Niebaum</td>
			<td class="status">Seated</td>
			<td class="response"></td>
			<td class="table">66</td>
			<td class="actions">
				<?php echo anchor('#','Seat Now',array('class'=>'seat-now button green')) ?>
				<?php echo anchor('#','Seat Ready',array('class'=>'seat-ready button blue')) ?>
				<?php echo anchor('#','Cancel',array('class'=>'cancel button')) ?>
				<?php echo anchor('#','New Request',array('class'=>'new-request button')) ?>
				<?php echo anchor('#','Remove',array('class'=>'remove button red')) ?>
			</td>
		</tr-->
	</tbody>
</table>
<div id="actions-template" class="hidden">
	<?php echo anchor('#','Seat Now',array('class'=>'seat-now button green')) ?>
	<?php echo anchor('#','Seat Ready',array('class'=>'seat-ready button blue')) ?>
	<?php echo anchor('#','Cancel',array('class'=>'cancel button')) ?>
	<?php echo anchor('#','New Request',array('class'=>'new-request button')) ?>
	<?php echo anchor('#','Remove',array('class'=>'remove button red')) ?>
</div>