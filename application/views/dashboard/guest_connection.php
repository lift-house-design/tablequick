<? foreach($nav_pages as $url => $page){ ?>
	<?=anchor('/dashboard'.$url, $page['name'],array('class'=>'button button-nav '.$page['active']))?>
<? } ?>

<hr/>

<?php echo anchor('javascript:void(0)','Send Text Offer',array('class'=>'send-text-offer primary button float-right')) ?>
<table id="customer-table" style="width:99%">
	<thead>
		<tr>
			<th>ID</td>
			<th class="datetime">Last Seated</th>
			<th class="patron-name">Patron Name</th>
			<th class="phone">Mobile Number</th>
			<th class="total-visits">Total Visits</th>
			<th class="actions">Action</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<div id="actions-template" class="hidden">
	<?php echo anchor('javascript:void(0)','Visit Details',array('class'=>'visit-details button blue')) ?>
</div>