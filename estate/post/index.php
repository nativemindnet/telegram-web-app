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
						category_ru.ID, category_ru.Category as categ_ru
					FROM
						category_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option value='<?php echo $result['ID'] ?>;<?php echo $result['categ_ru'] ?>'><?php echo $result['categ_ru'] ?></option>
				<?php } ?>
			</select><select name="Rooms" id="select9" style="display: none;">
				<option value="change">Количество комнат</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5 и более</option>
			</select>
			<select name="Type" id="select1">
				<option value="change">Тип</option>
				<?php $query = mysqli_query($link, "SELECT
						estate_type_ru.ID, estate_type_ru.Type as estate_type_ru
					FROM
					estate_type_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option value='<?php echo $result['ID'] ?>;<?php echo $result['estate_type_ru'] ?>'><?php echo $result['estate_type_ru'] ?></option>
				<?php } ?>
			</select>
			<select name="Rooms" id="select6">
				<option value="change">Количество комнат</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5 и более">5 и более</option>
			</select>
			<select name="Bathrooms" id="select7">
				<option value="change">Количество ванных</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5 и более">5 и более</option>
			</select>
			<input type="number" pattern="\d*" placeholder="Площадь (в кв.м.)" name="Size" id="text3">
			<select name="Pool" id="select2">
				<option value="change">Бассейн</option>
				<?php $query = mysqli_query($link, "SELECT
						estate_pool_ru.ID, estate_pool_ru.Pool as estate_pool_ru
					FROM
					estate_pool_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option value='<?php echo $result['ID'] ?>;<?php echo $result['estate_pool_ru'] ?>'><?php echo $result['estate_pool_ru'] ?></option>
				<?php } ?>
			</select>
			<select name="Children" id="select3">
				<option value="change">Инфраструктура для детей</option>
				<?php $query = mysqli_query($link, "SELECT
						estate_children_ru.ID, estate_children_ru.Children as estate_children_ru
					FROM
					estate_children_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option value='<?php echo $result['ID'] ?>;<?php echo $result['estate_children_ru'] ?>'><?php echo $result['estate_children_ru'] ?></option>
				<?php } ?>
			</select>
			<select name="Pet" id="select4">
				<option value="change">Домашние питомцы</option>
				<?php $query = mysqli_query($link, "SELECT
						estate_pet_ru.ID, estate_pet_ru.Pet as estate_pet_ru
					FROM
					estate_pet_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option value='<?php echo $result['ID'] ?>;<?php echo $result['estate_pet_ru'] ?>'><?php echo $result['estate_pet_ru'] ?></option>
				<?php } ?>
			</select>
			<input type="number" pattern="\d*" placeholder="Минимальный срок аренды" name="MinPeriod" id="text4">
			<select name="Unit" id="select5">
				<option value="change">Единица времени</option>
				<?php $query = mysqli_query($link, "SELECT
						period_unit_ru.ID, period_unit_ru.Unit as unit_ru
					FROM
						period_unit_ru");
					while ($result = mysqli_fetch_assoc($query)) { ?>
						<option value='<?php echo $result['ID'] ?>;<?php echo $result['unit_ru'] ?>'><?php echo $result['unit_ru'] ?></option>
					<?php } ?>
			</select>
			<input type="number" pattern="\d*" placeholder="Цена (в тайских батах)" name="Price" id="text5">
			<input type="text" placeholder="Местоположение" name="Location" id="text6">
			<input type="text" placeholder="Комментарий" name="Comment" id="text7">
			<label id="file-upload">
			<input type="file" accept="image/*" name="FileToSave" id="FileToSave" onchange="fileChange()">
				<p id="p1">Выбрать файл</p>
				<p id="p2"></p>
			</label>
			
			<input type="text" name="Author" id="authorHide">
			<input type="text" name="AuthorID" id="authorIDHide">
			<input type="text" name="Message" id="messageHide">
			<a class="centered" onclick="sendData()">Создать</a>
		</form>
	</div>

	<div class="footer">
		<a class="navBtn" id="back" href="/"><span>🏠</span></a>
	</div>
	<script src="https://telegram.org/js/telegram-web-app.js"></script>
	<script src="/script/script.js"></script>

	<script type="text/javascript">
		function fileChange() {
			var image = document.getElementById("FileToSave").value;

			if (image != "") {
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
			var rooms = document.getElementById("select6").value;
			var bathrooms = document.getElementById("select7").value;
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

			if (category == "change" || type == "change" || rooms == "change" || bathrooms == "" || size == "" || pool == "change" || children == "change" || pet == "change" || minPeriod == "" || unit == "change" || price == "" || location == "" || image == "") {
				alert('Не все поля заполнены');
				return;
			}

			if (tg.initDataUnsafe.user.username == undefined) {
				alert("У вас не определен username, а без него мы не можем создать пост. Вы можете задать его в настройках Телеграм.");
				return;
			}

			document.querySelector(".loading").style.display = "block";

			message = "%23" + category.slice(category.indexOf(';') + 1)
			+ "%0AТип: " + type.slice(type.indexOf(';') + 1)
			+ "%0AКоличество комнат: " + rooms
			+ "%0AКоличество ванных комнат: " + bathrooms
			+ "%0AПлощадь: " + size + "м²"
			+ "%0AИнфраструктура для детей: " + children.slice(children.indexOf(';') + 1)
			+ "%0AБассейн: " + pool.slice(pool.indexOf(';') + 1)
			+ "%0AДомашние питомцы: " + pet.slice(pet.indexOf(';') + 1)
			+ "%0AМинимальный срок аренды: " + minPeriod
			+ " " + unit.slice(unit.indexOf(';') + 1)
			+ "%0AЦена: " + price + " ฿"
			+ "%0AМестоположение: " + location
			+ "%0AКоментарий: " + comment
			+ "%0AАвтор поста: @" + tg.initDataUnsafe.user.username;

			setTimeout(sendSubmit, 0);
		 	}; 
			function sendSubmit() {
				document.getElementById("authorHide").value = tg.initDataUnsafe.user.username;
				document.getElementById("authorIDHide").value = tg.initDataUnsafe.user.id;
				document.getElementById("messageHide").value = message;
				document.getElementById("form").submit();
			}
	</script>
	<?php
		mysqli_close($link);
	?>
</body>
</html>