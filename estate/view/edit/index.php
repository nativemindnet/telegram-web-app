<?php
	include $_SERVER['DOCUMENT_ROOT'] . "/db.php";
	$user = $_COOKIE["huahinCurrentPost"];
	$query = mysqli_query($link, "select * from estate_ru where ID = '$user'");
	$result = mysqli_fetch_assoc($query);
	$category = $result['Category'];
	$type = $result['Type'];
	$rooms = $result['QuantityOfRooms'];
	$bathrooms = $result['QuantityOfBathrooms'];
	$size = $result['SizeOfSpace'];
	$pool = $result['Pool'];
	$children = $result['Children'];
	$pet = $result['Pet'];
	$minPeriod = $result['MinPeriod'];
	$unit = $result['Unit'];
	$price = $result['Price'];
	$location = $result['Location'];
	$comment = $result['Comment'];
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
						category_ru.ID, category_ru.Category as categ_ru
					FROM
						category_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option <?php if ($result['categ_ru'] == $category ) echo "selected" ?> value='<?php echo $result['ID'] ?>;<?php echo $result['categ_ru'] ?>'><?php echo $result['categ_ru'] ?></option>
				<?php } ?>
			</select>
			<select name="Type" id="select1">
				<option value="change">Тип</option>
				<?php $query = mysqli_query($link, "SELECT
						estate_type_ru.ID, estate_type_ru.Type as estate_type_ru
					FROM
					estate_type_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option <?php if ($result['estate_type_ru'] == $type ) echo "selected" ?> value='<?php echo $result['ID'] ?>;<?php echo $result['estate_type_ru'] ?>'><?php echo $result['estate_type_ru'] ?></option>
				<?php } ?>
			</select>
			<input value="<?php echo $rooms ?>" type="number" placeholder="Количество комнат" name="Rooms" id="text1">
			<input value="<?php echo $bathrooms ?>" type="number" placeholder="Количество ванных комнат" name="Bathrooms" id="text2">
			<input value="<?php echo $size ?>" type="number" placeholder="Площадь" name="Size" id="text3">
			<select name="Pool" id="select2">
				<option value="change">Бассейн</option>
				<?php $query = mysqli_query($link, "SELECT
						estate_pool_ru.ID, estate_pool_ru.Pool as estate_pool_ru
					FROM
					estate_pool_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option <?php if ($result['estate_pool_ru'] == $pool ) echo "selected" ?> value='<?php echo $result['ID'] ?>;<?php echo $result['estate_pool_ru'] ?>'><?php echo $result['estate_pool_ru'] ?></option>
				<?php } ?>
			</select>
			<select name="Children" id="select3">
				<option value="change">Инфраструктура для детей</option>
				<?php $query = mysqli_query($link, "SELECT
						estate_children_ru.ID, estate_children_ru.Children as estate_children_ru
					FROM
					estate_children_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option <?php if ($result['estate_children_ru'] == $children ) echo "selected" ?> value='<?php echo $result['ID'] ?>;<?php echo $result['estate_children_ru'] ?>'><?php echo $result['estate_children_ru'] ?></option>
				<?php } ?>
			</select>
			<select name="Pet" id="select4">
				<option value="change">Домашние питомцы</option>
				<?php $query = mysqli_query($link, "SELECT
						estate_pet_ru.ID, estate_pet_ru.Pet as estate_pet_ru
					FROM
					estate_pet_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option <?php if ($result['estate_pet_ru'] == $pet ) echo "selected" ?> value='<?php echo $result['ID'] ?>;<?php echo $result['estate_pet_ru'] ?>'><?php echo $result['estate_pet_ru'] ?></option>
				<?php } ?>
			</select>
			<input value="<?php echo $minPeriod ?>" type="number" placeholder="Минимальный период" name="MinPeriod" id="text4">
			<select name="Unit" id="select5">
				<option value="change">Единица времени</option>
				<?php $query = mysqli_query($link, "SELECT
						period_unit_ru.ID, period_unit_ru.Unit as unit_ru
					FROM
						period_unit_ru");
					while ($result = mysqli_fetch_assoc($query)) { ?>
						<option <?php if ($result['unit_ru'] == $unit ) echo "selected" ?> value='<?php echo $result['ID'] ?>;<?php echo $result['unit_ru'] ?>'><?php echo $result['unit_ru'] ?></option>
					<?php } ?>
			</select>
			<input value="<?php echo $price ?>" type="number" placeholder="Цена" name="Price" id="text5">
			<input value="<?php echo $location ?>" type="text" placeholder="Местоположение" name="Location" id="text6">
			<input value="<?php echo $comment ?>" type="text" placeholder="Комментарий" name="Comment" id="text7">
			<label id="file-upload" class="selected">
			<input type="file" accept="image/*" name="FileToSave" id="FileToSave" onchange="fileChange()">
				<div id="currentImage">
					<img src="/src/<?php echo $image ?>" alt="" srcset="">
				</div>
				<p id="p1">Выберите файл</p>
				<p id="p2"></p>
			</label>
			
			<input type="text" name="MsgID" id="msgHide">
			<input type="text" name="Message" id="messageHide">
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
	<script src="/script/transl_ru.js"></script>

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
		var message;
		tg = window.Telegram.WebApp;

		function sendData() {
			var category = document.getElementById("select").value;
			var type = document.getElementById("select1").value;
			var rooms = document.getElementById("text1").value;
			var bathrooms = document.getElementById("text2").value;
			var size = document.getElementById("text3").value;
			var pool = document.getElementById("select2").value;
			var children = document.getElementById("select3").value;
			var pet = document.getElementById("select4").value;
			var minPeriod = document.getElementById("text4").value;
			var unit = document.getElementById("select5").value;
			var price = document.getElementById("text5").value;
			var location = document.getElementById("text6").value;
			var comment = document.getElementById("text7").value;
			var image = document.getElementById("FileToSave").value;

			if (category == "change" ||
			type == "change" ||
			rooms == "" ||
			bathrooms == "" ||
			size == "" ||
			pool == "change" ||
			children == "change" ||
			pet == "change" ||
			minPeriod == "" ||
			unit == "change" ||
			price == "" ||
			location == "" ||
			comment == ""
			) {
				alert('Не все поля заполнены');
				return;
			}
			document.querySelector(".loading").style.display = "block";

			var token = "5633923018:AAGVaML4ay4FGcrOpBtmmJFdzTI1K7HYqTw";
			var chat_id = "@tkuik_group";
			var message_thread_id = "3"
			var messageId = "<?php $query = mysqli_query($link, "select MsgID from estate_rent where ID = " . $_COOKIE['huahinCurrentPost']);
					$result = mysqli_fetch_assoc($query);
					echo $result['MsgID']; ?>";
			var url = 'https://api.telegram.org/bot' + token + '/deleteMessage?chat_id=' + chat_id + '&message_thread_id=' + message_thread_id + '&message_id=' + messageId;

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

			message = "Категория: " + category.slice(type.indexOf(';') + 1)
			+ "%0AТип: " + type.slice(type.indexOf(';') + 1)
			+ "%0AКоличество комнат: " + rooms
			+ "%0AКоличество ванных комнат: " + bathrooms
			+ "%0AПлощадь: " + size + "m²"
			+ "%0AИнфраструктура для детей: " + children.slice(children.indexOf(';') + 1)
			+ "%0AБассейн: " + pool.slice(pool.indexOf(';') + 1)
			+ "%0AДомашние питомцы: " + pet.slice(pet.indexOf(';') + 1)
			+ "%0AМинимальный период: " + minPeriod
			+ " " + unit.slice(unit.indexOf(';') + 1)
			+ "%0AЦена: " + price + " ฿"
			+ "%0AЛокация: " + location
			+ "%0AКоментарий: " + comment
			+ "%0AАвтор поста: @" + "<?php echo $author; ?>";
			
			setTimeout(sendSubmit, 1000);
		 	}; 
			function sendSubmit() {
				document.getElementById("msgHide").value = <?php echo $result['MsgID']; ?>;
				document.getElementById("messageHide").value = message;
				document.getElementById("form").submit();
			}
	</script>
	<?php
		mysqli_close($link);
	?>
</body>
</html>