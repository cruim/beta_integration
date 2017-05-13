$(document).ready(function() {
	/*
	if ($.fn.dataTable.isDataTable('#table_id')) {
		detail_table = $('#table_id').DataTable();
		detail_table.destroy();
		$('#table_id body').empty();
	}
	*/
	
	$('#table_id').DataTable({
		"paging":		false,
		"searching":	false,
		//"ordering":		false,
		//"info":			false,
		"language": {
			"url": "js/i118n/russian.json"
		},
		ajax: {
			"url": 'step2_ctrl.php',
			"type": "POST",
			"data" : {
				"cmd" : "show_not_processed",
			}
		},
		columns: [
			{ data: 'import_order_order_number' },
			{ data: 'Error_Description' },
			{ data: 'Add_Info' }
		]
	});
	
});