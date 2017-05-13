var files;

$(document).ready(function() {

	//Загрузка Стран
	var formData = {};
	formData['cmd'] = 'getCountries';
	$.ajax({
			url: 'step1_ctrl.php',
			type: 'POST',
			data: formData,
			success: function(data, textStatus, jqXHR) {
				if(typeof data.error === 'undefined') {
					
					
					
				} else {
					// Handle errors here
					console.log('ERRORS: ' + data.error);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
			
				console.log('ERRORS: ' + textStatus);
			
			}
	});

	//Импорт файла excel
	$('input:file').on('change', function(event) {
		
		files = event.target.files;
		if (files.length > 0) {
		//показываем крутилку
			
		//в скрытом поле сохраняем имя файла
		$('input[name="fileName"]').val(files[0].name);
		
		var formData = new FormData();
		
		$.each(files, function(key, value)
		{
			formData.append(key, value);
		});
		formData.append( 'cmd', 'uploadFile' );
		
		$.ajax({
			url: 'step1_ctrl.php',
			type: 'POST',
			data: formData,
			cache: false,
			dataType: 'json',
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			success: function(data, textStatus, jqXHR) {
				if(typeof data.error === 'undefined') {
					//после удачной загрузки файла на сервер, даем команду показать листы
					SelectWorkSheet();
					// Success so call function to process the form
					//submitForm(event, data);
				} else {
					// Handle errors here
					console.log('ERRORS: ' + data.error);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// Handle errors here
				console.log('ERRORS: ' + textStatus);
				// STOP LOADING SPINNER
			}
		});
		
		}
		
	});
	
	$('form').on('submit', function(event) {
	});
	
	$('button[name="import"]').on('click', function(event) {
		var fileName = $('input[name="fileName"]').val();
		if (fileName == '') {
			alert('Выберите файл для загрузки');
			return false;
		}
		
		var workSheet = $('select[name="selectWorkSheet"]').val();
		if (workSheet == '') {
			alert('Выберите лист');
			return false;
		}

		var data_obj = {cmd: 'importSheet', fileName: fileName, workSheet: workSheet};
		
		$.ajax({
			url: 'step1_ctrl.php',
			type: "POST",
			data: data_obj,
			//async: false,
			success: function(data) {
				var data_obj = $.parseJSON(data);
				table_data = $('table.dataTable tbody');
				table_data.empty();
				table_data.append('<tr><td>Успешно импортировано</td><td>'+data_obj.success_row+' строк</td></tr>');
				if (data_obj.not_success_row > 0) {
					table_data.append('<tr><td>Не импортировано</td><td>'+data_obj.not_success_row+' строк</td></tr>');
					for (var i=0; i<=data_obj.not_success_row-1; i++) {
						table_data.append('<tr><td colspan="2">'+data_obj.not_success[i]+'</td></tr>');
					}
				}
				return true;
			},
			error: function(data) {
				return false;
			}
		});
		
	});
	
	
});

function SelectWorkSheet() {
	var fileName = $('input[name="fileName"]').val();
	var data_obj = {cmd: 'getSheets', fileName: fileName};
	//var data_str = JSON.stringify(data_obj);
	
	$.ajax({
		url: 'step1_ctrl.php',
		type: "POST",
		data: data_obj,
		success: function(data) {
			console.log(data);
			var data_obj = $.parseJSON(data);
			$('select').empty();
			for (var i=0; i<=data_obj.length-1; i++) {
				$('select').append('<option value="'+data_obj[i]+'">'+data_obj[i]+'</option>');
			}
		},
		error: function(data) {
			
		}
	});
}