<? foreach($nav_pages as $url => $page){
		echo anchor('/dashboard'.$url, $page['name'],array('class'=>'button button-nav '.$page['active']));
	} ?>

<hr/>
<h1>Coming Soon</h1>

<?/*
<?php echo anchor('/dashboard/new_customer','New Customer',array('class'=>'new-customer button float-right')) ?>
<?php echo anchor('/dashboard/next_customer','Seat Next Customer',array('class'=>'seat-next-customer primary button float-right')) ?>
<div id="demo">
<div id="example_wrapper" class="dataTables_wrapper" role="grid"><div class="DTTT_container"><a class="DTTT_button DTTT_button_text" id="ToolTables_example_0"><span>Select all</span></a><a class="DTTT_button DTTT_button_text" id="ToolTables_example_1"><span>Deselect all</span></a></div><div class="clear"></div><div id="example_length" class="dataTables_length"><label>Show <select size="1" name="example_length" aria-controls="example"><option value="10" selected="selected">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div><div class="dataTables_filter" id="example_filter"><label>Search: <input type="text" aria-controls="example"></label></div>
<table cellpadding="0" cellspacing="0" border="0" class="display dataTable DTTT_selectable" id="example" aria-describedby="example_info">
	<thead>
		<tr role="row"><th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 128px;">Rendering engine</th><th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 179px;">Browser</th><th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 171px;">Platform(s)</th><th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 108px;">Engine version</th><th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 74px;">CSS grade</th></tr>
	</thead>
	<tfoot>
		<tr><th rowspan="1" colspan="1">Rendering engine</th><th rowspan="1" colspan="1">Browser</th><th rowspan="1" colspan="1">Platform(s)</th><th rowspan="1" colspan="1">Engine version</th><th rowspan="1" colspan="1">CSS grade</th></tr>
	</tfoot>
	
<tbody role="alert" aria-live="polite" aria-relevant="all"><tr class="even_gradeA odd">
			<td class=" sorting_1">Gecko</td>
			<td class=" ">Firefox 1.5</td>
			<td class=" ">Win 98+ / OSX.2+</td>
			<td class="center ">1.8</td>
			<td class="center ">A</td>
		</tr><tr class="odd_gradeA even">
			<td class=" sorting_1">Gecko</td>
			<td class=" ">Firefox 2.0</td>
			<td class=" ">Win 98+ / OSX.2+</td>
			<td class="center ">1.8</td>
			<td class="center ">A</td>
		</tr><tr class="even_gradeA odd">
			<td class=" sorting_1">Gecko</td>
			<td class=" ">Firefox 3.0</td>
			<td class=" ">Win 2k+ / OSX.3+</td>
			<td class="center ">1.9</td>
			<td class="center ">A</td>
		</tr><tr class="odd_gradeA even">
			<td class=" sorting_1">Gecko</td>
			<td class=" ">Camino 1.0</td>
			<td class=" ">OSX.2+</td>
			<td class="center ">1.8</td>
			<td class="center ">A</td>
		</tr><tr class="even_gradeA odd DTTT_selected">
			<td class=" sorting_1">Gecko</td>
			<td class=" ">Camino 1.5</td>
			<td class=" ">OSX.3+</td>
			<td class="center ">1.8</td>
			<td class="center ">A</td>
		</tr><tr class="odd_gradeA even">
			<td class=" sorting_1">Gecko</td>
			<td class=" ">Netscape 7.2</td>
			<td class=" ">Win 95+ / Mac OS 8.6-9.2</td>
			<td class="center ">1.7</td>
			<td class="center ">A</td>
		</tr><tr class="even_gradeA odd DTTT_selected">
			<td class=" sorting_1">Gecko</td>
			<td class=" ">Netscape Browser 8</td>
			<td class=" ">Win 98SE+</td>
			<td class="center ">1.7</td>
			<td class="center ">A</td>
		</tr><tr class="odd_gradeA even">
			<td class=" sorting_1">Gecko</td>
			<td class=" ">Netscape Navigator 9</td>
			<td class=" ">Win 98+ / OSX.2+</td>
			<td class="center ">1.8</td>
			<td class="center ">A</td>
		</tr><tr class="even_gradeA odd">
			<td class=" sorting_1">Gecko</td>
			<td class=" ">Mozilla 1.0</td>
			<td class=" ">Win 95+ / OSX.1+</td>
			<td class="center ">1</td>
			<td class="center ">A</td>
		</tr><tr class="odd_gradeA even">
			<td class=" sorting_1">Gecko</td>
			<td class=" ">Mozilla 1.1</td>
			<td class=" ">Win 95+ / OSX.1+</td>
			<td class="center ">1.1</td>
			<td class="center ">A</td>
		</tr></tbody></table><div class="dataTables_info" id="example_info">Showing 1 to 10 of 57 entries</div><div class="dataTables_paginate paging_two_button" id="example_paginate"><a class="paginate_disabled_previous" tabindex="0" role="button" id="example_previous" aria-controls="example">Previous</a><a class="paginate_enabled_next" tabindex="0" role="button" id="example_next" aria-controls="example">Next</a></div></div>
			</div>
			*/?>