<?php
	/*  
	 *  Этап второй, обработка ошибочных заказов
	 *  
	 */ 
	header("Content-Type: text/html; charset=utf-8");
	error_reporting(E_ALL);
	ini_set("display_errors", "on");
	ini_set("display_startup_errors", "on");
	ini_set('max_execution_time', 0);
	
	//$postdata = file_get_contents("php://input");
	//var_dump($postdata);
	
	//var_dump($_GET);
	//var_dump($_POST);
	
	
?>
<html>
<head>
	<title>Обработка заказов с ошибками</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
	
	<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/step2.js"></script>

</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<p>Данные заказы не подходят для доставки.
			Обновляя данную страницу, можно видеть прогресс обработки ошибок.</p>
			<p>Нажимая далее, Вы отправляете все заказы, кроме ошибочных.
			<a href="step33.php">
			<button type="button" class="btn btn-default">Далее</button>
			</a>
		</div>
	</div>
</div>
	
<div class="container">

	<div class="row">
		<div class="col-md-12">

<table id="table_id" class="display compact" cellspacing="0" width="100%">
    <thead>
        <tr>
			<th>Номер заказа</th>
			<th>Описание ошибки</th>
			<th>Дополнительная информация</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

		</div>
	</div>

</div>


</body>

</html>