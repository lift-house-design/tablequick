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
		url: '/dashboard/refresh_table_feedback',
		type: 'post',
		dataType: 'json',
		data: {},
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


$(document).ready( function () {
	$('#customer-table').dataTable( {
		sPaginationType: 'full_numbers',
		aaSorting: [],
		sDom: '<"dataTables_options"lf>rtip',
		aoColumnDefs: [
			/*{
				bSortable: false,
				aTargets: [-1],
				sClass: 'datetime'
			},*/
			{
				bVisible: false,
				aTargets: [0]
			},
			{
				sClass: 'datetime2',
				aTargets: [1]
			},
			{
				sClass: 'datetime2',
				aTargets: [2]
			},
			{
				sClass: 'datetime2',
				aTargets: [3]
			}
		],
		"oTableTools": {
			"aButtons": []
		}
	} );
	refreshTable();
	setInterval(function(){
		refreshTable();
	},60000);
} );

function param_encode(str)
{
	return $.base64.encode(str).replace(/\=/g,'');
}		

function qr_print()
{
	$('#qr-print').printElement();
}

function qr_code()
{
	var table_number = $('#qr-table-number').val().trim();
	var server_name = $('#qr-server-name').val().trim();
	var file_name = 'QR-'+table_number+'-'+server_name;
	if(!table_number)
	{
		alert("Table Number is required. (Server Name is optional.)")
		return;
	}
	var target_url = "http://"+document.domain+"/site/customer_feedback/"+param_encode(user_id)+"/"+param_encode(table_number)+"/"+param_encode(server_name);
	var qr_url = "http://chart.apis.google.com/chart?cht=qr&chs=200x200&chl="+encodeURI(target_url)+"&chld=H|0";
	$('#qr-print-img').attr('src',qr_url);
	$('#qr-print-table-number').html('Table: '+table_number);
	if(server_name)
		$('#qr-print-server-name').html('Server: '+server_name);
	else
		$('#qr-print-server-name').html('');
	$.fancybox.open({
		type: 'ajax',
		content: 
			'Table: '+table_number+'<span style="float:right;margin-left:20px">Server: '+server_name+'</span><hr/>'+
			'URL: <a target="_blank" href="'+target_url+'">'+target_url+'</a><hr/>'+
			//'QR URL: <a target="_blank" href="'+qr_url+'">'+qr_url+'</a><hr/>'+
			'<div style="text-align:center"><img src="'+qr_url+'" id="qr-image"/></div><hr/>'+
			'<a href="'+qr_url+'" download="'+file_name+'.png" title="'+file_name+'" class="button">Download</a>'+
			'<a href="javascript:qr_print()" class="button" style="float:right">Print</a>'
	});
}
$(function(){$('.qr-wrap').appendTo('.dataTables_options');});