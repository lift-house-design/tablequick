<? foreach($nav_pages as $url => $page){ ?>
	<?=anchor('/dashboard'.$url, $page['name'],array('class'=>'button button-nav '.$page['active']))?>
<? } ?>

<hr/>

<a href="javascript:send_text_offer_popup()" class="send-text-offer primary button float-right" style="margin:1px 0px">Send Text Offer</a>
<table id="customer-table" style="width:99%">
	<thead>
		<tr>
			<th>ID</td>
			<th class="datetime">Last In</th>
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
	<a href="javascript:void(0)" class="visit-details button blue">Visit Details</a>
</div>