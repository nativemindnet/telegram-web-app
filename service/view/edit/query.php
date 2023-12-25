<?php
include $_SERVER['DOCUMENT_ROOT'] . "/db.php";

$query = mysqli_query($link, "select Image from transport_rent where ID = " . $_COOKIE['huahinCurrentPost']);
$result = mysqli_fetch_assoc($query);

$id = $_COOKIE['huahinCurrentPost'];
$category = substr($_POST['Category'], 0, strpos($_POST['Category'], ";"));
$message = $_POST['Message'];
$msgID = $_POST['MsgID'];

$query = mysqli_query($link, "CALL service_posts_update
($category, '$message', $msgID, $id)");

mysqli_close($link)
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
		<a class="button centered" id="btn1" href="https://t.me/tkuik_group/321/<?php echo $msgID; ?>">Сообщение было успешно изменено, вы можете просмотреть его, нажав на эту кнопку</a>
	</div>

	<div class="footer">
		<a class="navBtn" id="back" href="/"><span>🏠</span></a>
	</div>
	<script src="https://telegram.org/js/telegram-web-app.js"></script>
</body>
</html>