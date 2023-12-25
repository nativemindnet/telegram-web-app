<?php
	if (($_FILES['FileToSave']['name']!="")){
		$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/src/";
		$file = $_FILES['FileToSave']['name'];
		$path = pathinfo($file);
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$filename = '';

		for ($i = 0; $i < 10; $i++) {
				$filename = $filename . $characters[rand(0, strlen($characters) - 1)];
		}

		$ext = $path['extension'];
		$temp_name = $_FILES['FileToSave']['tmp_name'];
		$path_filename_ext = $target_dir.$filename.".".$ext;

		if (file_exists($path_filename_ext)) {
			echo "Error";
		}
		else {
			move_uploaded_file($temp_name,$path_filename_ext);
		}
	}


	$location = $_POST['Location'];
	if ($_POST['Category'] == 'change') {
		$category = $_POST['Category'];
	}
	else {
		$category = substr($_POST['Category'], 0, strpos($_POST['Category'], ";"));
	}
	if ($_POST['Type'] == 'change') {
		$type = $_POST['Type'];
	}
	else {
		$type = substr($_POST['Type'], 0, strpos($_POST['Type'], ";"));
	}
	if ($_POST['Type2'] == 'change') {
		$type2 = $_POST['Type2'];
	}
	else {
		$type2 = substr($_POST['Type2'], 0, strpos($_POST['Type2'], ";"));
	}
	if ($_POST['Type3'] == 'change') {
		$type3 = $_POST['Type3'];
	}
	else {
		$type3 = substr($_POST['Type3'], 0, strpos($_POST['Type3'], ";"));
	}
	if ($_POST['Type4'] == 'change') {
		$type4 = $_POST['Type4'];
	}
	else {
		$type4 = substr($_POST['Type4'], 0, strpos($_POST['Type4'], ";"));
	}
	if ($_POST['Brand'] == 'change') {
		$brand = $_POST['Brand'];
	}
	else {
		$brand = substr($_POST['Brand'], 0, strpos($_POST['Brand'], ";"));
	}
	$model = $_POST['Model'];
	$mileage = $_POST['Mileage'];
	$ownersCount = $_POST['OwnersCount'];
	$born = $_POST['Born'];
	$price = $_POST['Price'];
	$message = $_POST['Message'];
	$author = $_POST['Author'];
	$authorID = $_POST['AuthorID'];
	$image = $filename.".".$ext;
	$msg = $_POST['MessageTg'];

	include $_SERVER['DOCUMENT_ROOT'] . "/db.php";

	$link = mysqli_connect($server, $login, $pass, $name_db);
	if ($link == FALSE) {
		echo "Error";
	}
	mysqli_query($link, "SET NAMES utf8");

	$query = mysqli_query($link, "CALL market_posts_insert
	('$location', '$category', '$type', '$type2', '$type3', '$type4', '$brand', '$model', '$mileage', '$ownersCount', '$born', $price, '$message', '$author', '$authorID', '$image', 'null');");
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
		<div class="loading"></div>
		<form id="form" action="success/index.php" method="POST">
			<input type="text" name="OldMsgID" id="oldMsgID">
			<input type="text" name="MsgID" id="msgID">
		</form>
	</div>

	<div class="footer">
		<a class="navBtn" id="back" href="/"><span>🏠</span></a>
	</div>
	<script src="https://telegram.org/js/telegram-web-app.js"></script>
	<script type="text/javascript">
		var answer;
		var token = "5633923018:AAGVaML4ay4FGcrOpBtmmJFdzTI1K7HYqTw";
		var chat_id = "@tkuik_group";
		var message_thread_id = "322"

		var url = 'https://api.telegram.org/bot' + token
		+ '/sendPhoto?chat_id=' + chat_id
		+ '&message_thread_id=' + message_thread_id
		+ '&photo=' + window.location.protocol + '//' + window.location.hostname + '/src/<?php echo $image ?>'
		+ '&reply_markup={"inline_keyboard": [[{"text": "Изменить/Удалить", "url": "t.me/tkuikbot/huahin_market"}]]}'
		+ '&caption=<?php echo $msg ?>'
		+ '&parse_mode=html';
		fetch(url).then(function (response) {
		if (response.ok) {
			response.json().then(function (json) {
				answer = json['result']['message_id'];
				sendSubmit();
			});
		} else {
			console.log(
			"Network request for" + url + "failed with response " +
				response.status +
				": " +
				response.statusText,
			);
		}
		});
		function sendSubmit() {
			document.getElementById("msgID").value = answer;
			document.getElementById("form").submit();
		}
	</script>
</body>
</html>