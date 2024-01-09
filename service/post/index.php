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
					<option value='<?php echo $result['ID'] ?>;<?php echo $result['categ_ru'] ?>'><?php echo $result['categ_ru'] ?></option>
				<?php } ?>
			</select>
			<select name="Type" id="select1" onchange="select1Change()">
				<option value="change">Тип</option>
				<?php $query = mysqli_query($link, "SELECT
						service_type_ru.ID, service_type_ru.Type as type_ru
					FROM
					service_type_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option value='<?php echo $result['ID'] ?>;<?php echo $result['type_ru'] ?>'><?php echo $result['type_ru'] ?></option>
				<?php } ?>
			</select>
			<select name="Type2" id="select2" style="display: none;">
				<option value="change">Подтип</option>
			</select>
			<input type="number" pattern="\d*" name="Price" id="price" placeholder="Цена (в тайских батах)">
			<textarea form="form" placeholder="Коментарий" name="Message" id="message" maxlength="255" cols="30" rows="10"></textarea>
			<input type="text" name="MsgID" id="msgHide">
			<input type="text" name="Author" id="authorHide">
			<input type="text" name="AuthorID" id="authorIDHide">
			<a class="centered" onclick="sendData()">Создать</a>
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

		let answer;
		tg = window.Telegram.WebApp;

		function sendData() {
			var category = document.getElementById("select").value;
			var type = document.getElementById("select1").value;
			var type2 = document.getElementById("select2").value;
			var price = document.getElementById("price").value;
			var message = document.getElementById("message").value;

			if (category == "change" || type == "change" || type2 == "change") {
				alert('Не все поля заполнены');
				return;
			}

			if (tg.initDataUnsafe.user.username == undefined) {
				alert("У вас не поределен username, а без него мы не можем создать пост. Вы можете задать его в настройках Телеграм.");
				return;
			}

			document.querySelector(".loading").style.display = "block";

			var msg = "Категория: " + category.slice(category.indexOf(';') + 1)
			+ "%0A" + "Тип: " + type.slice(type.indexOf(';') + 1)
			+ "%0A" + "Подтип: " + type2.slice(type2.indexOf(';') + 1)
			+ "%0A" + "Цена: " + price
			+ "%0A" + "Комментарий: " + message
			+ "%0AАвтор поста: @" + tg.initDataUnsafe.user.username;
	
			var url = 'https://api.telegram.org/bot' + token + '/sendMessage?chat_id=' 
			+ chat_id + '&message_thread_id=' + service_message_thread_id + '&text=' 
			+ msg + '&reply_markup={"inline_keyboard": [[{"text": "Изменить/Удалить", "url": ' + service_app + '}]]}'
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
		 	}; 
			function sendSubmit() {
				document.getElementById("authorHide").value = tg.initDataUnsafe.user.username;
				document.getElementById("authorIDHide").value = tg.initDataUnsafe.user.id;
				document.getElementById("msgHide").value = answer;
				document.getElementById("form").submit();
			}
	</script>
	<?php
		mysqli_close($link);
	?>
</body>
</html>