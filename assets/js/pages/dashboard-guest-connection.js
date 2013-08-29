function addPatron(data)
{
	var dataTable=$('#customer-table').dataTable();

	if(data.length==5)
	{
		var actions=$('#actions-template').clone().removeAttr('id').removeClass('hidden').html();
		data.push(actions);
		dataTable.fnAddData(data);
	}
}

function refreshTable(callback)
{
	$.ajax({
		url: '/dashboard/refresh_guest_connection',
		type: 'post',
		dataType: 'json',
		data: {},
		success: function(data,textStatus,jqXHR){
			console.log(data);
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
},5000);

$(function()
{

	$('#customer-table').dataTable({
		sPaginationType: 'full_numbers',
		aaSorting: [],
		sDom: '<"dataTables_options"lf>rtip',
		aoColumnDefs: [
			{
				bSortable: false,
				aTargets: [5]
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
				sClass: 'status',
				aTargets: [3]
			},
			{
				sClass: 'status',
				aTargets: [4]
			},
			{
				sClass: 'status',
				aTargets: [5]
			}
		],
		fnCreatedRow: function(row,data,i){}
	});

	$(document)
		.on('click','.fancybox-inner .close.button',function(e){
			$.fancybox.close();
			return e.preventDefault();
		})
		.on('click','#customer-table .visit-details.button',function(e){
			var dataTable=$('#customer-table').dataTable();
			var tr=$(this).parents('tr').get(0);
			var data=dataTable.fnGetData(tr);
			var id=data[0];

			$.fancybox.open({
				type: 'ajax',
				href: '/dashboard/visit_details/'+id
			});

			$('#visit-table').dataTable({
				sPaginationType: 'full_numbers',
				aaSorting: [],
				sDom: '<"dataTables_options"lf>rtip',
				aoColumnDefs: [
					{
						bSortable: false,
						aTargets: [-1]
					},
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

			return e.preventDefault();
		})


	$('.send-text-offer.button').appendTo('.dataTables_options');

	// Load initial data
	refreshTable();
});