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
			<th class="table">Party Size</th>
			<th class="status">Status</th>
			<th class="response">Response</th>
			<th class="table">Table #</th>
			<th class="actions">Action</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<div id="actions-template" class="hidden">
	<?php echo anchor('#','Seat Now',array('class'=>'seat-now button green')) ?>
	<?php echo anchor('#','Seat Ready',array('class'=>'seat-ready button blue')) ?>
	<?php echo anchor('#','Cancel',array('class'=>'cancel button')) ?>
	<?php echo anchor('#','New Request',array('class'=>'new-request button')) ?>
	<?php echo anchor('#','Remove',array('class'=>'remove button red')) ?>
</div>