
			$(document).ready( function () {
				$('#example').dataTable( {
					"sDom": 'T<"clear">lfrtip',
					"oTableTools": {
						"sRowSelect": "multi",
						"aButtons": [ "select_all", "select_none" ]
					}
				} );
			} );
		