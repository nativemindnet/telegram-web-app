<?php
	include $_SERVER['DOCUMENT_ROOT'] . "/db.php";
	$id = $_COOKIE['huahinCurrentPost'];
	
	$link = mysqli_connect($server, $login, $pass, $name_db);
	if ($link == FALSE) {
		echo "Error";
	}
	mysqli_query($link, "SET NAMES utf8");

	$query = mysqli_query($link, "select Image from transport_rent where ID = " . $id);
	$result = mysqli_fetch_assoc($query);
	$filename = $_SERVER['DOCUMENT_ROOT'] . "/src/" . $result['Image'];

	if (file_exists($filename)) {
		unlink($filename);
	}

	$query = mysqli_query($link, "DELETE FROM transport_rent WHERE ID = '$id'");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Huanhin</title>
	<link rel="stylesheet" href="/style/style.css">
</head>
<body>
	<a class="mainBtn" href="https://burohh.com/transport/view">Пост был успешно удален!</a>

	<div class="footer">
		<a class="navBtn" id="back" href="/"><span>🏠</span></a>
	</div>

	<script src="https://telegram.org/js/telegram-web-app.js"></script>
	<script src="/script/script.js"></script>
	<script src="/script/transl_ru.js"></script>

</body>
</html>