<?php
	/*  
	 *  Этап первый, загружаем файл Excel с подобранными заказми, для отгрузки в Бета-пост
	 *  проверяем файл Excel, если несколько листов, даем выбор
	 */ 


	header("Content-Type: text/html; charset=utf-8");
	error_reporting(E_ALL);
	ini_set("display_errors", "on");
	ini_set("display_startup_errors", "on");
	ini_set('max_execution_time', 0);
	
	//require_once 'shared/functions.php';
	
	//$fileName = getInput($_POST, 'fileName');
	//$fileName = 'выгрузка бета без суст.xlsx';
	
	
	
	
?>


<html>
<head>
	<title>Выбор листа с данными</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

	<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/step1.js"></script>

</head>
<body>

<div class="container">

      <div class="page-header">
        <p class="lead"></p>
      </div>


			<form role="form" action="step2.php">
			<div class="row">
				<div class="col-md-12">
					 
					<label for="exampleInputFile">
						Выберите файл Excel
					</label>
					<input type="file" id="exampleInputFile" required="required" />
					<p class="help-block">
						Файл должен содержать 2 колонки: № заказа, № телефона (другие колонки также могут присутствовать, но в учет не берутся). Первая строка - заголовок таблицы.
					</p>
					<input type="hidden" name="fileName" />
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<label for="selectWorkSheet">
						Выберите лист
					</label>
					<select class="form-control" id="selectWorkSheet" name="selectWorkSheet" required="required">
						<option></option>
					</select>
				</div>
			</div>
				<!--
				<div class="form-group">
					 
					<label for="exampleInputPassword1">
						Password
					</label>
					<input type="password" class="form-control" id="exampleInputPassword1" />
				</div>
				-->
				<div class="checkbox">
					 
					<label>
						<input type="checkbox" checked="checked" /> Первая строка содержит заголовок таблицы
					</label>
				</div> 
				
				
			<div class="row">
				<button type="button" name="import" class="btn btn-default">
					Импорт
				</button>
			</div>
				
			<div class="row">
				<table class="table table-bordered dataTable">
					<thead>
						<tr>
						<th colspan="2">Результаты импорта</th>
						</tr>
					</thead>
					<tbody>
						<!-- <tr><td>&nbsp;</td></tr> -->
					</tbody>
				</table>
			</div>
			
			<div class="row">
				<button type="submit" class="btn btn-default">
					Далее
				</button>
			</div>
			
			</form>


</div>

</body>

</html>