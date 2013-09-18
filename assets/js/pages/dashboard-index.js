function addPatron(data)
{
	var dataTable=$('#customer-table').dataTable();

	var actions=$('#actions-template').clone().removeAttr('id').removeClass('hidden').html();
	data.push(actions);
	dataTable.fnAddData(data);
}

function refreshTable(callback)
{
	$.ajax({
		url: '/dashboard/refresh_assign_seating',
		type: 'post',
		dataType: 'json',
		data: {

		},
		success: function(data,textStatus,jqXHR){
			var dataTable=$('#customer-table').dataTable();
			dataTable.fnClearTable();

			for(var i in data)
				addPatron(data[i]);

			if(typeof callback == 'function')
				callback();
		}
	});
}

setInterval(function(){
	/*$('<div class="refresh-notice">')
		.html('Refreshing data...')
		.prependTo('#contents');*/

	refreshTable(/*function(){
		$('.refresh-notice').remove();
	}*/);
},50000);

$(function(){
	$('#customer-table').dataTable({
		sPaginationType: 'full_numbers',
		aaSorting: [],
		sDom: '<"dataTables_options"lf>rtip',
		aoColumnDefs: [
			{
				bSortable: false,
				aTargets: [-1]
			},
			{
				bVisible: false,
				aTargets: [0]
			},
			{
				sClass: 'datetime',
				aTargets: [1]
			},
			{
				sClass: 'patron-name',
				aTargets: [2]
			},
			{
				sClass: 'table',
				aTargets: [3]
			},
			{
				sClass: 'status',
				aTargets: [4]
			},
			{
				sClass: 'response',
				aTargets: [5]
			},
			{
				sClass: 'table',
				aTargets: [6]
			},
			{
				sClass: 'table',
				aTargets: [7]
			},
			{
				sClass: 'table',
				aTargets: [8]
			},
			{
				sClass: 'table',
				aTargets: [9]
			},
			{
				sClass: 'actions',
				aTargets: [10]
			}
		],
		fnCreatedRow: function(row,data,i){
			// Add class to row
			var status=data[4];

			switch(status)
			{
				case 'Waiting':
					$(row).addClass('status-waiting');
					break;
				case 'Notified':
					$(row).addClass('status-notified');
					break;
				case 'Notified/Replied':
					$(row).addClass('status-replied');
					break;
				case 'Seated':
					$(row).addClass('status-seated');
					break;
				case 'Cancelled/Left':
				case 'Cancelled/At Bar':
					$(row).addClass('status-cancelled');
					break;
			}

			// Add classes to cells
			/*var cellClasses=[
				'datetime',
				'patron-name',
				'status',
				'response',
				'table',
				'actions'
			];

			$(row)
				.children('td')
				.each(function(i){
					$(this).addClass(cellClasses[i]);
				});*/
		}
	});

	$('.new-customer.button, .seat-next-customer.button').appendTo('.dataTables_options');

	$('.new-customer.button')
		.appendTo('.dataTables_options')
		.click(function(e){
			$.fancybox.open({
				type: 'ajax',
				href: '/dashboard/new_customer',
				afterShow: function(){
					$('.fancybox-inner .phone').mask('(999) 999-9999');	
					$('.fancybox-inner input[name="name"]').focus();
				}
			});

			return e.preventDefault();
		});

	$(document)
		.on('click','.fancybox-inner .close.button',function(e){
			$.fancybox.close();
			return e.preventDefault();
		})
		.on('click','#customer-table .remove.button',function(e){
			var dataTable=$('#customer-table').dataTable();
			var tr=$(this).parents('tr').get(0);
			var data=dataTable.fnGetData(tr);
			var id=data[0];

			$.fancybox.open({
				type: 'ajax',
				href: '/dashboard/remove_customer/'+id
			});

			return e.preventDefault();
		})
		.on('submit','.fancybox-inner #remove-customer',function(e){
			// Disable buttons
			$(this)
				.find('.buttons')
				.html('Please wait...');

			var id=$(this)
				.find('input[name="id"]')
				.val();
			
			// Send the request
			$.ajax({
				url: $(this).attr('action'),
				type: 'post',
				data: {
					id: id
				},
				success: function(data,textStatus,jqXHR){
					refreshTable(function(){
						$.fancybox.close();
					});
				}
			});

			return e.preventDefault();
		})
		.on('click','#customer-table .cancel.button',function(e){
			var dataTable=$('#customer-table').dataTable();
			var tr=$(this).parents('tr').get(0);
			var data=dataTable.fnGetData(tr);
			var id=data[0];

			$.fancybox.open({
				type: 'ajax',
				href: '/dashboard/cancel_customer/'+id
			});

			return e.preventDefault();
		})
		.on('submit','.fancybox-inner #cancel-customer',function(e){
			// Disable buttons
			$(this)
				.find('.buttons')
				.html('Please wait...');

			var id=$(this)
				.find('input[name="id"]')
				.val();
			
			// Send the request
			$.ajax({
				url: $(this).attr('action'),
				type: 'post',
				data: {
					id: id
				},
				success: function(data,textStatus,jqXHR){
					refreshTable(function(){
						$.fancybox.close();
					});
				}
			});

			return e.preventDefault();
		})
		.on('click','#customer-table .new-request.button',function(e){
			var dataTable=$('#customer-table').dataTable();
			var tr=$(this).parents('tr').get(0);
			var data=dataTable.fnGetData(tr);
			var id=data[0];

			$.fancybox.open({
				type: 'ajax',
				href: '/dashboard/new_customer/'+id,
				afterShow: function(){
					$('.fancybox-inner .phone').mask('(999) 999-9999');	
					$('.fancybox-inner input[name="name"]').focus();
				}
			});

			return e.preventDefault();
		})
		.on('submit','.fancybox-inner #new-customer',function(e){
			// Disable buttons
			$(this)
				.find('.buttons')
				.html('Please wait...');

			var data = {
				name: $(this).find('input[name="name"]').val(),
				phone: $(this).find('input[name="phone"]').val(),
				time_in: $(this).find('input[name="time_in"]').val(),
				party_size: $(this).find('input[name="party_size"]').val(),
				table_location: $(this).find('input[name="table_location"]').val(),
				special_seating: $(this).find('select[name="special_seating"]').val(),
				notes: $(this).find('input[name="notes"]').val()
			};
			
			// Send the request
			$.ajax({
				url: $(this).attr('action'),
				type: 'post',
				data: data,
				success: function(data,textStatus,jqXHR){
					refreshTable(function(){
						$.fancybox.close();
					});
				}
			});

			return e.preventDefault();
		})
		.on('click','#customer-table .seat-now.button',function(e){
			var dataTable=$('#customer-table').dataTable();
			var tr=$(this).parents('tr').get(0);
			var data=dataTable.fnGetData(tr);
			var id=data[0];

			$.fancybox.open({
				type: 'ajax',
				href: '/dashboard/seat_customer/'+id,
				afterShow: function(){
					$('.fancybox-inner input[name="table_number"]').focus();
				}
			});

			return e.preventDefault();
		})
		.on('submit','.fancybox-inner #seat-customer',function(e){
			// Disable buttons
			$(this)
				.find('.buttons')
				.html('Please wait...');

			var id=$(this)
				.find('input[name="id"]')
				.val();
			var table_number=$(this)
				.find('input[name="table_number"]')
				.val();
			
			// Send the request
			$.ajax({
				url: $(this).attr('action'),
				type: 'post',
				data: {
					id: id,
					table_number: table_number
				},
				success: function(data,textStatus,jqXHR){
					console.log(data);
					refreshTable(function(){
						$.fancybox.close();
					});
				}
			});

			return e.preventDefault();
		})
		.on('click','#customer-table .seat-ready.button',function(e){
			var dataTable=$('#customer-table').dataTable();
			var tr=$(this).parents('tr').get(0);
			var data=dataTable.fnGetData(tr);
			var id=data[0];

			$.fancybox.open({
				type: 'ajax',
				href: '/dashboard/seat_ready/'+id
			});

			return e.preventDefault();
		})
		.on('submit','.fancybox-inner #notify-customer',function(e){
			// Disable buttons
			$(this)
				.find('.buttons')
				.html('Please wait...');

			var id=$(this)
				.find('input[name="id"]')
				.val();
			
			// Send the request
			$.ajax({
				url: $(this).attr('action'),
				type: 'post',
				data: {
					id: id
				},
				success: function(data,textStatus,jqXHR){
					console.log(data);
					refreshTable(function(){
						$.fancybox.close();
					});
				}
			});

			return e.preventDefault();
		})
		.on('click','.seat-next-customer.button',function(e){
			$.fancybox.open({
				type: 'ajax',
				href: '/dashboard/seat_next_customer'
			});

			return e.preventDefault();
		});

	// Load initial data
	refreshTable();
});