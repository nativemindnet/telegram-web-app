<?php
include $_SERVER['DOCUMENT_ROOT'] . "/db.php";
$user = $_COOKIE["huahinCurrentPost"];
$query = mysqli_query($link, "select * from market_posts_ru where ID = '$user'");
$result = mysqli_fetch_assoc($query);
$category = $result['Category'];
$message = $result['Message'];
$author = $result['Author'];
$image = $result['Image'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Huanhin</title>
	<link rel="stylesheet" href="/style/style.css">
</head>
<body class="space_bottom">
	<div class="loading" style="display: none;"></div>
	<div class="container post">
		<form method="post" action="query.php" id="form" enctype="multipart/form-data">
			<select name="Category" id="select">
				<option value="change">Категория</option>
				<?php $query = mysqli_query($link, "SELECT
						market_category_ru.ID, market_category_ru.Category as categ_ru
					FROM
					market_category_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option <?php if ($result['categ_ru'] == $category ) echo "selected" ?> value='<?php echo $result['ID'] ?>;<?php echo $result['categ_ru'] ?>'><?php echo $result['categ_ru'] ?></option>
				<?php } ?>
			</select>
			
			<textarea form="form" name="Message" id="message" maxlength="255" cols="30" rows="10"><?php echo $message ?></textarea>

			<label id="file-upload" class="selected">
			<input type="file" accept="image/*" name="FileToSave" id="FileToSave" onchange="fileChange()">
				<div id="currentImage">
					<img src="/src/<?php echo $image ?>" alt="" srcset="">
				</div>
				<p id="p1">Выбрать файл</p>
				<p id="p2"></p>
			</label>
			<input type="text" name="MsgID" id="msgHide">
			<input type="text" name="MessageTg" id="messageHide">
			<a class="centered" onclick="sendData()">Изменить</a>
		</form>
	</div>

	<div class="footer">
		<a class="navBtn" id="back" href="/"><span>🏠</span></a>
		<div class="navBtn" id="lang">
			<button class="langBtn" id="lang1" onclick="selectLanguage()"><span>🇷🇺</span></button>
			<button class="langBtn" id="lang2" onclick="deselectLanguage()"><span>❌</span></button>
			<button class="langBtn" id="lang3" onclick='changeLanguage("en-EN")'><span>🇬🇧</span></button>
			<button class="langBtn" id="lang4" onclick='changeLanguage("th-TH")'><span>🇹🇭</span></button>
		</div>
	</div>
	<script src="https://telegram.org/js/telegram-web-app.js"></script>
	<script src="/script/script.js"></script>
	<script src="/script/config.js"></script>

	<script type="text/javascript">
		function fileChange() {
			var image = document.getElementById("FileToSave").value;
			if (image != "") {
				document.getElementById("currentImage").style.display = "none";
				document.getElementById("p2").style.display = "block";
				document.getElementById("p2").innerHTML = image.slice(image.lastIndexOf("\\")+1);
			}
		}

		var answer;
		var msg;
		tg = window.Telegram.WebApp;

		function sendData() {
			var category = document.getElementById("select").value;
			var message = document.getElementById("message").value;
			var image = document.getElementById("FileToSave").value;

			if (category == "change" || message == "") {
				alert('Не все поля заполнены');
				return;
			}

			document.querySelector(".loading").style.display = "block";

			var messageId = "<?php $query = mysqli_query($link, "select MsgID from market_posts where ID = " . $_COOKIE['huahinCurrentPost']);
					$result = mysqli_fetch_assoc($query);
					echo $result['MsgID']; ?>";
			var url = 'https://api.telegram.org/bot' + token + '/deleteMessage?chat_id=' + chat_id + '&message_thread_id=' + market_message_thread_id + '&message_id=' + messageId;

			fetch(url).then(function (response) {
				if (response.ok) {
				} else {
					console.log(
					"Network request for" + url + "failed with response " +
						response.status +
						": " +
						response.statusText,
					);
				}
			});

			msg = "Категория: " + category.slice(category.indexOf(';') + 1)
			+ "%0A" + message
			+ "%0AАвтор поста: @" + "<?php echo $author; ?>";

			setTimeout(sendSubmit, 1000);
		 	}; 
			function sendSubmit() {
				document.getElementById("msgHide").value = answer;
				document.getElementById("messageHide").value = msg;
				document.getElementById("form").submit();
			}
	</script>
	<?php
		mysqli_close($link);
	?>
</body>
</html>