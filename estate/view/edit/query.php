<?php
include $_SERVER['DOCUMENT_ROOT'] . "/db.php";

$query = mysqli_query($link, "select Image from estate_rent where ID = " . $_COOKIE['huahinCurrentPost']);
$result = mysqli_fetch_assoc($query);
$filename = $_SERVER['DOCUMENT_ROOT'] . "/src/" . $result['Image'];

if (($_FILES['FileToSave']['name']!="")){
	if (file_exists($filename)) {
		unlink($filename);
	}
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
	echo "Ошибка";
	}else{
	move_uploaded_file($temp_name, $path_filename_ext);
	}
	$image = $filename.".".$ext;
}
else {
	$image = $result['Image'];
}
$id = $_COOKIE['huahinCurrentPost'];
$category = substr($_POST['Category'], 0, strpos($_POST['Category'], ";"));
$type = substr($_POST['Type'], 0, strpos($_POST['Type'], ";"));
$rooms = $_POST['Rooms'];
$bathrooms = $_POST['Bathrooms'];
$size = $_POST['Size'];
$pool = substr($_POST['Pool'], 0, strpos($_POST['Pool'], ";"));
$children = substr($_POST['Children'], 0, strpos($_POST['Children'], ";"));
$pet = substr($_POST['Pet'], 0, strpos($_POST['Pet'], ";"));
$minPeriod = $_POST['MinPeriod'];
$unit = substr($_POST['Unit'], 0, strpos($_POST['Unit'], ";"));
$price = $_POST['Price'];
$location = $_POST['Location'];
$comment = $_POST['Comment'];
$msgID = $_POST['MsgID'];
$msg = $_POST['Message'];

$query = mysqli_query($link, "CALL estate_rent_update
($category, $type, $rooms, $bathrooms, $size, $pool, $children, $pet, $minPeriod, $unit, $price, '$location', '$comment', '$image', $id)");

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
		var message_thread_id = "3"

		var url = 'https://api.telegram.org/bot' + token
		+ '/sendPhoto?chat_id=' + chat_id
		+ '&message_thread_id=' + message_thread_id
		+ '&photo=' + window.location.protocol + '//' + window.location.hostname + '/src/<?php echo $image ?>'
		+ '&reply_markup={"inline_keyboard": [[{"text": "Изменить/Удалить", "url": "t.me/tkuikbot/huahin_estate"}]]}'
		+ '&caption=<?php echo $msg ?>'
		+ '&parse_mode=html';
		fetch(url).then(function (response) {
		if (response.ok) {
			response.json().then(function (json) {
				answer = json['result']['message_id'];
			});
			sendSubmit();
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
			document.getElementById("oldMsgID").value = <?php echo $msgID; ?>;
			document.getElementById("form").submit();
		}
	</script>
</body>
</html>