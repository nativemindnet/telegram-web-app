<?php
	include $_SERVER['DOCUMENT_ROOT'] . "/db.php";
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
	<div class="loading" style="display: none;"></div>
	<div class="container post">
		<p class="centered">Вы действительно хотите удалить данный пост?</p>
		<a class="centered" onclick="sendData()">Удалить</a>
		<a class="centered" id="secondaryBtn" onclick="window.history.back()">Отмена</a>
	</div>

	<div class="footer">
		<a class="navBtn" id="back" href="/"><span>🏠</span></a>
	</div>
	<script src="https://telegram.org/js/telegram-web-app.js"></script>
	<script src="/script/script.js"></script>
	<script src="/script/config.js"></script>

	<script type="text/javascript">
		tg = window.Telegram.WebApp;

		var messageId = "<?php $query = mysqli_query($link, "select MsgID from market_posts where ID = " . $_COOKIE['huahinCurrentPost']);
				$result = mysqli_fetch_assoc($query);
				echo $result['MsgID']; ?>";
		var url = 'https://api.telegram.org/bot' + token + '/deleteMessage?chat_id=' + chat_id + '&message_thread_id=' + market_message_thread_id + '&message_id=' + messageId;

		function sendData() {
			document.querySelector(".loading").style.display = "block";
			fetch(url).then(function (response) {
				if (response.ok) {
					success();
				} else {
					console.log(
					"Network request for" + url + "failed with response " +
						response.status +
						": " +
						response.statusText,
					);
				}
			});
		 	}; 
			function success() {
				window.location.href = "success"
			}
	</script>
	
	<?php
		mysqli_close($link);
	?>
</body>
</html>