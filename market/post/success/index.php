<?php
	include $_SERVER['DOCUMENT_ROOT'] . "/db.php";
	$msgID = $_POST['MsgID'];

	$mysqli = new mysqli($server, $login, $pass, $name_db);

	if ($mysqli->connect_error) {
			die("Ошибка подключения: " . $mysqli->connect_error);
	}

	$result = $mysqli->query("SELECT @maxID := MAX(ID) FROM market_posts");

	if (!$result) {
			die("Ошибка в запросе: " . $mysqli->error);
	}

	$result = $mysqli->query("UPDATE market_posts SET MsgID = '$msgID' WHERE ID = @maxID");

	if (!$result) {
			die("Ошибка в запросе: " . $mysqli->error);
	}

	$mysqli->close();
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
	<div class="body">
		<a class="button centered" id="btn1" href="https://t.me/tkuik_group/322/<?php echo $msgID; ?>">Пост был успешно размещен, вы можете просмотреть его, нажав на эту кнопку</a>
	</div>

	<div class="footer">
		<a class="navBtn" id="back" href="/"><span>🏠</span></a>
	</div>
	<script src="https://telegram.org/js/telegram-web-app.js"></script>
</body>
</html>