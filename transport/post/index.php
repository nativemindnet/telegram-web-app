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
			<select name="Category" id="select" onchange="selectChange()">
				<option value="change">Категория</option>
				<?php $query = mysqli_query($link, "SELECT
						category_ru.ID, category_ru.Category as categ_ru
					FROM
						category_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option value='<?php echo $result['ID'] ?>;<?php echo $result['categ_ru'] ?>'><?php echo $result['categ_ru'] ?></option>
				<?php } ?>
			</select>
			<select name="Type" id="select1" onchange="select1Change()">
				<option value="change">Тип</option>
				<?php $query = mysqli_query($link, "SELECT
						transport_type_ru.ID, transport_type_ru.Type as type_ru
					FROM
						transport_type_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option value='<?php echo $result['ID'] ?>;<?php echo $result['type_ru'] ?>'><?php echo $result['type_ru'] ?></option>
				<?php } ?>
			</select>
			<select name="Type2" id="select2">
				<option value="change" dissabled>Тип автомобиля</option>
				<?php $query = mysqli_query($link, "SELECT
						transport_type2_ru.ID, transport_type2_ru.Type2 as type2_ru
					FROM
						transport_type2_ru
					WHERE 
						transport_type2_ru.ID != 4");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option value='<?php echo $result['ID'] ?>;<?php echo $result['type2_ru'] ?>'><?php echo $result['type2_ru'] ?></option>
				<?php } ?>
			</select>
			<select name="Brand" id="select3">
				<option value="change">Марка</option>
				<?php $query = mysqli_query($link, "select * from transport_brand");
					while ($result = mysqli_fetch_assoc($query)) { ?>
						<option value='<?php echo $result['ID'] ?>;<?php echo $result['Brand'] ?>'><?php echo $result['Brand'] ?></option>
					<?php } ?>
			</select>
			<input type="text" placeholder="Модель" name="Model" id="text1">
			<input type="number" placeholder="Минимальный срок аренды" name="MinPeriod" id="text2">
			<select name="Unit" id="select4">
				<option value="change">день/неделя/месяц</option>
				<?php $query = mysqli_query($link, "SELECT
						period_unit_ru.ID, period_unit_ru.Unit as unit_ru
					FROM
						period_unit_ru");
					while ($result = mysqli_fetch_assoc($query)) { ?>
						<option value='<?php echo $result['ID'] ?>;<?php echo $result['unit_ru'] ?>'><?php echo $result['unit_ru'] ?></option>
					<?php } ?>
			</select>
			<input type="number" placeholder="Цена (в тайских батах)" name="Price" id="text3">
			<input type="text" placeholder="Комментарий" name="Comment" id="text4">
			<label id="file-upload">
			<input type="file" accept="image/*" name="FileToSave" id="FileToSave" onchange="fileChange()">
				<p id="p1">Выбрать файл</p>
				<p id="p2"></p>
			</label>
			
			<input type="text" name="CategoryH" id="categoryHide">
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
		var category = document.getElementById("select").value;
		var select = document.getElementById("select");
		var select1 = document.getElementById("select1");
		var select2 = document.getElementById("select2");
		var select3 = document.getElementById("select3");
		var text1 = document.getElementById("text1");
		var text2 = document.getElementById("text2");
		var text3 = document.getElementById("text3");
		var text4 = document.getElementById("text4");
		var file = document.getElementById("file-upload");

		function select1Change() {
			if (select1.value.slice(0, select1.value.lastIndexOf(";")) == "1" || select1.value.slice(0, select1.value.lastIndexOf(";")) == "change") {
				select2.style.display = "inline-block";
				select2.value = "change";
			}
			else {
				select2.style.display = "none";
				select2.value = 4;
			}
		}

		function selectChange() {
			if (select.value.slice(0, select.value.lastIndexOf(";")) == "1" || select.value == "change") {
				select3.style.display = "inline-block";
				select3.value = "change";
				text1.style.display = "inline-block";
				text4.style.display = "inline-block";
				file.style.display = "inline-block";
			}
			else {
				select3.style.display = "none";
				select3.value = "1";
				text1.style.display = "none";
				text4.style.display = "none";
				file.style.display = "none";
			}
		}

		tg = window.Telegram.WebApp;

		function sendData() {
			var type = document.getElementById("select1").value;
			var type2 = document.getElementById("select2").value;
			var brand = document.getElementById("select3").value;
			var model = document.getElementById("text1").value;
			var minPeriod = document.getElementById("text2").value;
			var unit = document.getElementById("select4").value;
			var price = document.getElementById("text3").value;
			var comment = document.getElementById("text4").value;
			var image = document.getElementById("FileToSave").value;
			category = document.getElementById("select").value;

			if (select.value.slice(0, select.value.lastIndexOf(";")) == "2") {
				if (category == "change" || type == "change" || type2 == "change" || unit == "change" || minPeriod == "" || price == "") {
					alert('Не все поля заполнены.');
					return;
				}
			}
			else {
				if (category == "change" || type == "change" || type2 == "change" || brand == "change" || unit == "change" || model == "" || minPeriod == "" || price == "" || image == "") {
					alert('Не все поля заполнены.');
					return;
				}
			}

			if (tg.initDataUnsafe.user.username == undefined) {
				alert("У вас не поределен username, а без него мы не можем создать пост. Вы можете задать его в настройках Телеграм.");
				return;
			}

			document.querySelector(".loading").style.display = "block";
			if (category.slice(0, category.indexOf(';')) == 1) {
				if (type.slice(0, type.indexOf(';')) == 2) {
					message = "%23" + category.slice(type.indexOf(';') + 1)
					+ "%0AТип: " + type.slice(type.indexOf(';') + 1)
					+ "%0AМарка: " + brand.slice(brand.indexOf(';') + 1)
					+ "%0AМодель: " + model
					+ "%0AМинимальный срок аренды: " + minPeriod
					+ " " + unit.slice(unit.indexOf(';') + 1)
					+ "%0AЦена: " + price + " ฿"
					+ "%0AКоментарий: " + comment
					+ "%0AАвтор поста: @" + tg.initDataUnsafe.user.username;
				} else {
					message =  "%23" + category.slice(type.indexOf(';') + 1)
					+ "%0AТип: " + type.slice(type.indexOf(';') + 1)
					+ "%0AТип автомобиля: " + type2.slice(type2.indexOf(';') + 1)
					+ "%0AМарка: " + brand.slice(brand.indexOf(';') + 1)
					+ "%0AМодель: " + model
					+ "%0AМинимальный срок аренды: " + minPeriod
					+ " " + unit.slice(unit.indexOf(';') + 1)
					+ "%0AЦена: " + price + " ฿"
					+ "%0AКоментарий: " + comment
					+ "%0AАвтор поста: @" + tg.initDataUnsafe.user.username;
				}
			}
			else {
				if (type.slice(0, type.indexOf(';')) == 2) {
					message = "%23" + category.slice(type.indexOf(';') + 1)
					+ "%0AТип: " + type.slice(type.indexOf(';') + 1)
					+ "%0AМинимальный срок аренды: " + minPeriod
					+ " " + unit.slice(unit.indexOf(';') + 1)
					+ "%0AЦена: " + price + " ฿"
					+ "%0AАвтор поста: @" + tg.initDataUnsafe.user.username;
				} else {
					message =  "%23" + category.slice(type.indexOf(';') + 1)
					+ "%0AТип: " + type.slice(type.indexOf(';') + 1)
					+ "%0AТип автомобиля: " + type2.slice(type2.indexOf(';') + 1)
					+ "%0AМинимальный срок аренды: " + minPeriod
					+ " " + unit.slice(unit.indexOf(';') + 1)
					+ "%0AЦена: " + price + " ฿"
					+ "%0AАвтор поста: @" + tg.initDataUnsafe.user.username;
				}
			}
			setTimeout(sendSubmit, 1000);
		 	}; 
			function sendSubmit() {
				document.getElementById("categoryHide").value = document.getElementById("select").value.slice(0, document.getElementById("select").value.indexOf(';'));
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