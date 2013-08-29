<h1><?=$name?> <span style="float:right"><?=$phone?></span></h1>
<table id="visit-table">
	<thead>
		<th class='datetime'>Time In</th>
		<th class='datetime2'>Time Seated</th>
		<th class='datetime3'>Employee</th>
	</thead>
	<tbody>
		<? foreach($visits as $v){ ?>
			<tr>
				<td><?=$v['time_in']?></td>
				<td><?=$v['time_seated']?></td>
				<td><?=$v['employee']?></td>
			</tr>
		<? } ?>
	</tbody>
</table>
<script>
	$('#visit-table').dataTable({
		sPaginationType: 'full_numbers',
		sDom: '<"dataTables2_options"lf>rtip',
		aaSorting: [],
		"bFilter": false,
		"bInfo": false,
		"bPaginate": false,
		aoColumnDefs: [
			{
				sClass: 'datetime',
				aTargets: [0]
			},
			{
				sClass: 'datetime2',
				aTargets: [1]
			},
			{
				sClass: 'patron-name',
				aTargets: [2]
			}
		],
		fnCreatedRow: function(row,data,i){}
	});
</script>