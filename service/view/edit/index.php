<?php
include $_SERVER['DOCUMENT_ROOT'] . "/db.php";
$user = $_COOKIE["huahinCurrentPost"];
$query = mysqli_query($link, "select * from service_posts_ru where ID = '$user'");
$result = mysqli_fetch_assoc($query);
$category = $result['Category'];
$type = $result['Type'];
$type2 = $result['Type2'];
$message = $result['Message'];
$author = $result['Author'];
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
						service_category_ru.ID, service_category_ru.Category as categ_ru
					FROM
					service_category_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option <?php if ($result['categ_ru'] == $category ) echo "selected" ?> value='<?php echo $result['ID'] ?>;<?php echo $result['categ_ru'] ?>'><?php echo $result['categ_ru'] ?></option>
				<?php } ?>
			</select>
			<select name="Type" id="select1" onchange="select1Change()">
				<option value="change">Тип</option>
				<?php $query = mysqli_query($link, "SELECT
						service_type_ru.ID, service_type_ru.Type as type_ru
					FROM
					service_type_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option <?php if ($result['type_ru'] == $type ) echo "selected" ?> value='<?php echo $result['ID'] ?>;<?php echo $result['type_ru'] ?>'><?php echo $result['type_ru'] ?></option>
				<?php } ?>
			</select>
			<select name="Type2" id="select2">
    <option value="change">Подтип</option>
    <?php 
        $query = mysqli_query($link, "SELECT
				service_type2_ru.ID, service_type2_ru.Type2 as type2_ru
		FROM
				service_type2_ru
		JOIN
				service_type_ru ON service_type2_ru.Type = service_type_ru.ID
		WHERE
				service_type_ru.Type = '$type'");
        while ($result = mysqli_fetch_assoc($query)) { 
    ?>
        <option <?php if ($result['type2_ru'] == $type2 ) echo "selected" ?> value='<?php echo $result['ID'] ?>;<?php echo $result['type2_ru'] ?>'><?php echo $result['type2_ru'] ?></option>
    <?php } ?>
</select>

			<input type="text" name="Price" id="text" placeholder="Цена">
			<textarea form="form" placeholder="Коментарий" name="Message" id="message" maxlength="255" cols="30" rows="10"></textarea>
			<input type="text" name="MsgID" id="msgHide">
			<a class="centered" onclick="sendData()">Изменить</a>
		</form>
	</div>

	<div class="footer">
		<a class="navBtn" id="back" href="/"><span>🏠</span></a>
	</div>
	<script src="https://telegram.org/js/telegram-web-app.js"></script>
	<script src="/script/script.js"></script>
	<script src="/script/config.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<script type="text/javascript">
		function select1Change() {
			var data = $('#select1').val();
			switch (data.slice(0, data.indexOf(';'))) {
				case '1':
				case '2':
				case '3':
				case '4':
				case '5':
				case '6':
				case '7':
				case '8':
				case '9':
				case '10':
				case '11':
				case '12':
				case '13':
				case '14':
				case '15':
				case '16':
					$.ajax({
						type: 'POST',
						url: 'db_type.php',
						data: { data: data.slice(0, data.indexOf(';')) },
						success: function(response) {
							$("#select2").empty();
							const data = JSON.parse(response);
							var option = $("<option></option>");
							option.val('change');
							option.text('Подтип');
							$("#select2").append(option);
							for (let i = 0; i < data.length; i++) {
								var option = $("<option></option>");
								option.val(data[i].id);
								option.text(data[i].type);
								$("#select2").append(option);
							}
							$("#select2").css("display", "inline-block");
						}
					});
					break;
				default:
					$("#select2").css("display", "none");
			}
		}

		var answer;
		tg = window.Telegram.WebApp;

		function sendData() {
			var category = document.getElementById("select").value;
			var message = document.getElementById("message").value;

			if (category == "change" || message == "") {
				alert('Not all fields are filled in');
				return;
			}

			document.querySelector(".loading").style.display = "block";

			var messageId = "<?php $query = mysqli_query($link, "select MsgID from service_posts where ID = " . $_COOKIE['huahinCurrentPost']);
					$result = mysqli_fetch_assoc($query);
					echo $result['MsgID']; ?>";
			var url = 'https://api.telegram.org/bot' + token + '/deleteMessage?chat_id=' + chat_id + '&message_thread_id=' + service_message_thread_id + '&message_id=' + messageId;

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

			var msg = "Категория: " + category.slice(category.indexOf(';') + 1)
			+ "%0A" + message
			+ "%0AАвтор поста: @" + "<?php echo $author; ?>";

			var url = 'https://api.telegram.org/bot' + token + '/sendMessage?chat_id=' 
			+ chat_id + '&message_thread_id=' + service_message_thread_id + '&text=' 
			+ msg + '&reply_markup={"inline_keyboard": [[{"text": "Изменить/Удалить", "url": ' + service_app + '}]]}'
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
		 	}; 
			function sendSubmit() {
				document.getElementById("msgHide").value = answer;
				document.getElementById("form").submit();
			}
	</script>
	<?php
		mysqli_close($link);
	?>
</body>
</html>