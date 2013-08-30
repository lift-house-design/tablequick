var patron_numbers = [];

function send_text_offer_popup()
{
	var oTT = TableTools.fnGetInstance( 'customer-table' );
    var patrons = oTT.fnGetSelectedData();
    switch(patrons.length)
    {
    	case 0: alert('Please select a patron to receive your text offer.');
    	        return;
    	case 1: var message = "Send text to "+patrons[0][2];
    		    break;
    	case 2: var message = "Send text to "+patrons[0][2]+" and "+patrons[1][2];
    		    break;
    	default:var message = "Send text to "+patrons[0][2]+" and "+(patrons.length-1)+" others";
    }

    patron_numbers = [];
    $.each(patrons, function(i,p){
    	if(p[3])
    		patron_numbers.push(p[3]);

    });

    $.fancybox.open({
		type: 'ajax',
		href: '/dashboard/send_text_offer/',
		ajax: { 
			type: 'post',
			data: {
				patrons: patrons, 
				message: message
			}
		}
	});
}

function addPatron(data,patrons)
{
	var dataTable=$('#customer-table').dataTable();
	var oTT = TableTools.fnGetInstance( 'customer-table' );

	if(data.length==5)
	{
		var actions=$('#actions-template').clone().removeAttr('id').removeClass('hidden').html();
		data.push(actions);
		dataTable.fnAddData(data);

		// reselect selected rows
		$.each(patrons,function(i,p){
			if(data[2] === p[2] && data[3] === p[3])
    			oTT.fnSelect( $('#customer-table tbody tr:last') );
		});
	}
}


function refreshTable(callback)
{
	var oTT = TableTools.fnGetInstance( 'customer-table' );
    var patrons = oTT.fnGetSelectedData();

	$.ajax({
		url: '/dashboard/refresh_guest_connection',
		type: 'post',
		dataType: 'json',
		data: {},
		success: function(data,textStatus,jqXHR){
			var dataTable=$('#customer-table').dataTable();
			dataTable.fnClearTable();

			for(var i in data)
				addPatron(data[i],patrons);

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
},60000);

$(function()
{

	$('#customer-table').dataTable({
		sPaginationType: 'full_numbers',
		aaSorting: [],
//		sDom: '<"dataTables_options"lf>rtip',
		oTableTools: {
			sRowSelect: "multi",
			aButtons: [ "select_all", "select_none" ]
		},
		"sDom": 'T<"dataTables_options">lfrtip',
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
				sClass: 'datetime',
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
		.on('submit','.fancybox-inner #form-send-offer',function(e){

			// get data
			var text=$(this)
				.find('textarea[name="text"]')
				.val();
			text = $.trim(text);
			if(!text)
				return e.preventDefault();

			// Disable buttons
			$(this)
				.find('.buttons')
				.html('Please wait...');
				
			// Send the request
			$.ajax({
				url: $(this).attr('action'),
				type: 'post',
				data: {
					text: text,
					numbers: patron_numbers
				},
				success: function(data,textStatus,jqXHR){
					$('#form-send-offer').html('<div class="notifications"><ul><li>'+data+'</li></ul></div>');
					return e.preventDefault();
				},
				error: function(data,textStatus,jqXHR){
					alert("Error sending message.");
					$.fancybox.close();
					return e.preventDefault();
				}
			});

			return e.preventDefault();
		})
		.on('click','#customer-table .visit-details.button',function(e){
			var dataTable=$('#customer-table').dataTable();
			var tr=$(this).parents('tr').get(0);
			var data=dataTable.fnGetData(tr);
			var id=data[0];

			// undo TableTool's auto select stupidity (actually this might be fixed by giving this function a name and setting the onclick function in the html)
			if($(tr).hasClass('DTTT_selected'))
				$(tr).removeClass('DTTT_selected');
			else
				$(tr).addClass('DTTT_selected');

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
	$('.DTTT_container').appendTo('.dataTables_options');
	$('.DTTT_button').appendTo('.dataTables_options');

	// Load initial data
	refreshTable();
});