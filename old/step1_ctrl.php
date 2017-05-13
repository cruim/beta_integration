<?php

	header("Content-Type: text/html; charset=utf-8");
	error_reporting(E_ALL);
	ini_set("display_errors", "on");
	ini_set("display_startup_errors", "on");
	ini_set('max_execution_time', 0);
	
	$uploaddir = 'Upload/';
	require_once 'shared/functions.php';
	
	//var_dump($_POST);
	$cmd = getInput($_POST, 'cmd');
	
	//комманда загрузить файл на сервер
	if ($cmd == 'uploadFile') {
		
		$error = false;
		$files = array();
		//var_dump($_FILES);
		foreach($_FILES as $file) {
			$convert_file_name = basename($file['name']);
			//для винды надо конвертировать кодировку имени файла
			//$convert_file_name =  mb_convert_encoding(basename($file['name']), 'CP1251', 'UTF-8');
			if(move_uploaded_file($file['tmp_name'], $uploaddir.$convert_file_name)) {
				$files[] = $file['name'];
			} else {
				$error = true;
			}
		}
		$data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
		
		echo json_encode($data);
		
		$file_dump = 'dump.log';
		$content_dump = print_r($_FILES, TRUE);
		file_put_contents($file_dump, $content_dump);
	}
	
	//комманда получить листы в EXCEL файле
	if ($cmd == 'getSheets') {
		$fileName = getInput($_POST, 'fileName');
		
		require_once 'Classes/PHPExcel/IOFactory.php';
		$file = $uploaddir.$fileName;
		//какого-то хрена винда требует чтобы имя файла кодировалось в Windows-1251
		//т.е. имя файла пробуем конвертонуть
		//$file =  mb_convert_encoding($file, 'CP1251', 'UTF-8');
		

		
		//mb_internal_encoding("UTF-8");
		//var_dump(mb_internal_encoding() );


	
		/*
		$files = scandir('Upload/');
		foreach ($files as $file_name) {
			$encoding = mb_detect_encoding($file_name);
			var_dump($encoding);
			$file_name =  mb_convert_encoding($file_name, 'UTF-8', 'CP1251');
			
			//$file_name =  mb_convert_encoding($file_name, 'UTF-8', $encoding);
			var_dump($file_name);
		}
		*/
		
		
		$objPHPExcel = \PHPExcel_IOFactory::load($file);
		//var_dump($objPHPExcel);


		if ($objPHPExcel) {
			//узнаем кол-во листов, если больше одного, даем выбор
			$sheets_count = $objPHPExcel->getSheetCount();

			$titles = array ();
			//if ($sheets_count > 1)
			foreach ($objPHPExcel->getAllSheets() as $workSheet) {
				$title = $workSheet->getTitle();
				//$encoding = mb_detect_encoding($title);
				//$converted_title = mb_convert_encoding($title, 'UTF-8', $encoding);
				//var_dump($converted_title);
				$titles[] = $title;
			}
			$result = json_encode($titles);
			echo $result;
		}

	}

	//комманда загрузить из EXCEL файла определенный лист в таблицу mySQL
	if ($cmd == 'importSheet' /*or $cmd == ''*/) {

		$fileName = getInput($_POST, 'fileName');
		$workSheet = getInput($_POST, 'workSheet');
		//$fileName = 'выгрузка бета без суст.xlsx';
		//$workSheet = 'Simple'; //'Лист1';
		
		$serverSQL = 'zdorov.local.mySQL.Server'; //'5.167.96.63'; //

		$mysqli_ssl = mysqli_init();
		$mysqli_ssl->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, TRUE);
		$mysqli_ssl->ssl_set(
					__DIR__.'/../shared/certs/client-key.pem',
					__DIR__.'/../shared/certs/client-cert.pem',
					__DIR__.'/../shared/certs/ca.pem',
					NULL,
					NULL);
	
		$mysqli_ssl->options(MYSQLI_OPT_CONNECT_TIMEOUT, 10);
		$result_connect = $mysqli_ssl->real_connect($serverSQL, 'landing', '123', 'integration_betapost', NULL, NULL, MYSQLI_CLIENT_SSL);
		$mysqli_ssl->set_charset("utf8");
		
		require_once 'Classes/PHPExcel/IOFactory.php';
		$file = $uploaddir.$fileName;
		//какого-то хрена винда требует чтобы имя файла кодировалось в Windows-1251
		//т.е. имя файла пробуем конвертонуть
		//$file =  mb_convert_encoding($file, 'CP1251', 'UTF-8');
		$objPHPExcel = \PHPExcel_IOFactory::load($file);
		$objWorksheet = $objPHPExcel->getSheetByName($workSheet);
		
		foreach ($objWorksheet->getRowIterator() as $idx => $row) {
			if ($idx == 1) continue;

        $rowData = array();

        $cellIterator = $row->getCellIterator();
        //$cellIterator->setIterateOnlyExistingCells();

        foreach ($cellIterator as $cell) {
            $value = $cell->getValue();

            if (substr($value, 0, 1) === '=' && strlen($value) > 1){
                $value = $cell->getCalculatedValue();
            }

            if(PHPExcel_Shared_Date::isDateTime($cell)) {
                $value = date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($value));
            }

            if (!is_null($value)) $rowData[] = $value;

        }

        if (!array_filter($rowData)) {
            break;
        }

        $fileData[] = $rowData;
    }
		
		//var_dump($fileData);
		
		$query_str = " TRUNCATE `import_order` ";
		$query_result = $mysqli_ssl->query($query_str);
		
		$not_success = array ();
		$not_success_row = 0;
		$success_row = 0;
		foreach ($fileData as $idx => $row) {
			$query_str = 
			" INSERT INTO `import_order` (`import_order_order_number`, `import_order_order_phone`) ".
			" VALUES ('".$row[0]."', '".$row[1]."') ";
			$query_result = $mysqli_ssl->query($query_str);
			if ($query_result) {
				$success_row++;
			}
			else {
				$not_success_row++;
				$not_success[] = $row;
			}
		}	

		$mysqli_ssl->close();
		
		$result = array('success' => 'true', 'success_row' => $success_row, 'not_success_row' => $not_success_row, 'not_success' => $not_success );
		echo json_encode($result);
	}
		
