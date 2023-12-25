<?php
	include $_SERVER['DOCUMENT_ROOT'] . "/db.php";

	$link = mysqli_connect($server, $login, $pass, $name_db);
	if ($link == FALSE) {
		echo "Error";
	}
	mysqli_query($link, "SET NAMES utf8");

	$msgID = $_POST['MsgID'];
	$oldMsgID = $_POST['OldMsgID'];
	$query = mysqli_query($link, "UPDATE market_posts
	SET MsgID = '$msgID'
	WHERE MsgID = '$oldMsgID';");
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
		<a class="button centered" id="btn1" href="https://t.me/tkuik_group/322/<?php echo $msgID; ?>">Сообщение было успешно изменено, вы можете просмотреть его, нажав на эту кнопку</a>
	</div>

	<div class="footer">
		<a class="navBtn" id="back" href="/"><span>🏠</span></a>
	</div>
	<script src="https://telegram.org/js/telegram-web-app.js"></script>
</body>
</html>