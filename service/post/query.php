<?php
	$category = substr($_POST['Category'], 0, strpos($_POST['Category'], ";"));
	$type = substr($_POST['Type'], 0, strpos($_POST['Type'], ";"));
	$type2 = substr($_POST['Type2'], 0, strpos($_POST['Type2'], ";"));
	$price = $_POST['Price'];
	$message = $_POST['Message'];
	$author = $_POST['Author'];
	$authorID = $_POST['AuthorID'];
	$msgID = $_POST['MsgID'];

	include $_SERVER['DOCUMENT_ROOT'] . "/db.php";

	$link = mysqli_connect($server, $login, $pass, $name_db);
	if ($link == FALSE) {
		echo "Error";
	}
	mysqli_query($link, "SET NAMES utf8");

	$query = mysqli_query($link, "CALL service_posts_insert
	($category, $type, $type2, '$price', '$message', '$author', '$authorID', $msgID);");
	mysqli_close($link);
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
		<a class="button centered" id="btn1" href="https://t.me/tkuik_group/321/<?php echo $msgID; ?>">Пост был успешно создан, вы можете просмотреть его, нажав на эту кнопку</a>
	</div>

	<div class="footer">
		<a class="navBtn" id="back" href="/"><span>🏠</span></a>
	</div>
	<script src="https://telegram.org/js/telegram-web-app.js"></script>
</body>
</html>