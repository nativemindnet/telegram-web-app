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
		<form method="post" action="query.php" id="form" enctype="multipart/form-data" autocomplete="off">
			<select name="Category" id="select" onchange="selectChange()">
				<option value="change">Выбрать</option>
				<?php $query = mysqli_query($link, "SELECT
						market_category_ru.ID, market_category_ru.Category as categ_ru
					FROM
					market_category_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option value='<?php echo $result['ID'] ?>;<?php echo $result['categ_ru'] ?>'><?php echo $result['categ_ru'] ?></option>
				<?php } ?>
			</select>
			<select name="Type" id="select1" style="display: none;" onchange="select1Change()">
				<option value="change">Категория</option>
				<?php $query = mysqli_query($link, "SELECT
						market_type_ru.ID, market_type_ru.Type as type_ru
					FROM
					market_type_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option value='<?php echo $result['ID'] ?>;<?php echo $result['type_ru'] ?>'><?php echo $result['type_ru'] ?></option>
				<?php } ?>
			</select>

			<select name="Type2" id="select2" style="display: none;" onchange="select2Change()">
				<option value="change">Подкатегория</option>
			</select>

			<select name="Type3" id="select3" style="display: none;">
				<option value="change">Вид</option>
			</select>

			<select name="Type4" id="select4" style="display: none;">
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

			<select name="Brand" id="select5" style="display: none;">
				<option value="change">Марка</option>
				<?php $query = mysqli_query($link, "select * from transport_brand");
					while ($result = mysqli_fetch_assoc($query)) { ?>
						<option value='<?php echo $result['ID'] ?>;<?php echo $result['Brand'] ?>'><?php echo $result['Brand'] ?></option>
					<?php } ?>
			</select>
			<input type="text" placeholder="Модель" name="Model" id="text1" style="display: none;">
			<input type="number" placeholder="Пробег" name="Mileage" id="text2" style="display: none;">
			<select name="OwnersCount" id="select6" style="display: none;">
				<option value="change">Количество владельцев</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
			</select>
			<input type="number" placeholder="Год выпуска" name="Born" id="text3" style="display: none;" min="1900" max="2024">

			<select name="Rooms" id="select9" style="display: none;">
				<option value="change">Количество комнат</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5 и более</option>
			</select>
			<input type="number" placeholder="Количество ванных" name="Bathrooms" id="text6" style="display: none;">
			<input type="number" placeholder="Площадь (в кв.м.)" name="Size" id="text7" style="display: none;">
			<select name="Pool" id="select7" style="display: none;">
				<option value="change">Бассейн</option>
				<?php $query = mysqli_query($link, "SELECT
						estate_pool_ru.ID, estate_pool_ru.Pool as estate_pool_ru
					FROM
					estate_pool_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option value='<?php echo $result['ID'] ?>;<?php echo $result['estate_pool_ru'] ?>'><?php echo $result['estate_pool_ru'] ?></option>
				<?php } ?>
			</select>
			<select name="Children" id="select8" style="display: none;">
				<option value="change">Инфраструктура для детей</option>
				<?php $query = mysqli_query($link, "SELECT
						estate_children_ru.ID, estate_children_ru.Children as estate_children_ru
					FROM
					estate_children_ru");
				while ($result = mysqli_fetch_assoc($query)) { ?>
					<option value='<?php echo $result['ID'] ?>;<?php echo $result['estate_children_ru'] ?>'><?php echo $result['estate_children_ru'] ?></option>
				<?php } ?>
			</select>

			<input type="number" placeholder="Цена (в тайских батах)" name="Price" id="text4">

			<input type="text" placeholder="Местоположение" name="Location" id="text">
			<textarea placeholder="Сообщение" form="form" name="Message" id="message" maxlength="255" cols="30" rows="10"></textarea>
			<label id="file-upload">
			<input type="file" accept="image/*" name="FileToSave" id="FileToSave" onchange="fileChange()">
				<p id="p1">Выбрать файл</p>
				<p id="p2"></p>
			</label>
			<input type="text" name="MessageTg" id="messageHide">
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
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<script type="text/javascript">
		function fileChange() {
			var image = document.getElementById("FileToSave").value;
			if (image != "") {
				document.getElementById("p2").style.display = "block";
				document.getElementById("p2").innerHTML = image.slice(image.lastIndexOf("\\")+1);
			}
		}

		document.getElementById("text1").value = 'null';
		document.getElementById("text2").value = 'null';
		document.getElementById("text3").value = 'null';

		function selectChange() {
			var categ = document.getElementById("select").value;
			if (categ.slice(0, categ.indexOf(';')) == "1") {
				document.getElementById("select1").style.display = "inline-block";
			}
			else {
				document.getElementById("select1").style.display = "none";
				document.getElementById("select1").value = "change";
				$("#select2").css("display", "none");
				$("#select3").css("display", "none");
				$("#select4").css("display", "none");
				$("#select5").css("display", "none");
				$("#select6").css("display", "none");
				$("#text1").css("display", "none");
				document.getElementById("text1").value = 'null';
				$("#text2").css("display", "none");
				document.getElementById("text2").value = '-1';
				$("#text3").css("display", "none");
				document.getElementById("text3").value = '-1';
				$("#text6").css("display", "none");
				document.getElementById("text6").value = 'null';
				$("#text7").css("display", "none");
				document.getElementById("text7").value = 'null';
				$("#select7").css("display", "none");
				document.getElementById("select7").value = 'change';
				$("#select8").css("display", "none");
				document.getElementById("select8").value = 'change';
				$("#select9").css("display", "none");
				document.getElementById("select9").value = 'change';
			}
		}

		function select1Change() {
			var data = $('#select1').val();
			switch (data.slice(0, data.indexOf(';'))) {
				case '1':
				case '2':
				case '3':
				case '4':
				case '6':
				case '7':
					$.ajax({
						type: 'POST',
						url: 'db_type.php',
						data: { data: data.slice(0, data.indexOf(';')) },
						success: function(response) {
							$("#select2").empty();
							const data = JSON.parse(response);
							var option = $("<option></option>");
							option.val('change');
							option.text('Подкатегория');
							$("#select2").append(option);
							for (let i = 0; i < data.length; i++) {
								var option = $("<option></option>");
								option.val(data[i].id);
								option.text(data[i].type);
								$("#select2").append(option);
							}
							$("#select2").css("display", "inline-block");
							$("#select3").css("display", "none");
							document.getElementById("select3").value = 'change';
							$("#select4").css("display", "none");
							$("#select5").css("display", "none");
							$("#select6").css("display", "none");
							$("#text1").css("display", "none");
							$("#text2").css("display", "none");
							$("#text3").css("display", "none");
							$("#text6").css("display", "none");
							document.getElementById("text6").value = 'null';
							$("#text7").css("display", "none");
							document.getElementById("text7").value = 'null';
							$("#select7").css("display", "none");
							document.getElementById("select7").value = 'change';
							$("#select8").css("display", "none");
							document.getElementById("select8").value = 'change';
							$("#select9").css("display", "none");
							document.getElementById("select9").value = 'change';
						}
					});
					break;
				default:
					$("#select2").css("display", "none");
					$("#select3").css("display", "none");
					$("#select4").css("display", "none");
					$("#select5").css("display", "none");
					$("#select6").css("display", "none");
					$("#text1").css("display", "none");
					document.getElementById("text1").value = 'null';
					$("#text2").css("display", "none");
					document.getElementById("text2").value = '-1';
					$("#text3").css("display", "none");
					document.getElementById("text3").value = '-1';
					$("#text6").css("display", "none");
					document.getElementById("text6").value = 'null';
					$("#text7").css("display", "none");
					document.getElementById("text7").value = 'null';
					$("#select7").css("display", "none");
					document.getElementById("select7").value = 'change';
					$("#select8").css("display", "none");
					document.getElementById("select8").value = 'change';
					$("#select9").css("display", "none");
					document.getElementById("select9").value = 'change';
			}
		}

		function select2Change() {
			var data = $('#select2').val();
			switch (data.slice(0, data.indexOf(';'))) {
				case '4':
				case '5':
				case '6':
				case '7':
				case '8':
				case '9':
				case '10':
				case '12':
				case '13':
				case '14':
				case '15':
				case '16':
				case '18':
				case '19':
				case '20':
				case '21':
				case '28':
					$.ajax({
						type: 'POST',
						url: 'db_type2.php',
						data: { data: data },
						success: function(response) {
							$("#select3").empty();
							const data = JSON.parse(response);
							var option = $("<option></option>");
							option.val('change');
							option.text('Вид');
							$("#select3").append(option);
							for (let i = 0; i < data.length; i++) {
								var option = $("<option></option>");
								option.val(data[i].id);
								option.text(data[i].type);
								$("#select3").append(option);
							}
							$("#select3").css("display", "inline-block");
						}
					});
					break;
				case '1':
					$("#select4").css("display", "inline-block");
					$("#select5").css("display", "inline-block");
					$("#select6").css("display", "inline-block");
					$("#text1").css("display", "inline-block");
					document.getElementById("text1").value = '';
					$("#text2").css("display", "inline-block");
					document.getElementById("text2").value = '';
					$("#text3").css("display", "inline-block");
					document.getElementById("text3").value = '';
					break;
				case '2':
					$("#select4").css("display", "none");
					document.getElementById("select4").value = 'change';
					$("#select5").css("display", "inline-block");
					$("#select6").css("display", "inline-block");
					$("#text1").css("display", "inline-block");
					document.getElementById("text1").value = '';
					$("#text2").css("display", "inline-block");
					document.getElementById("text2").value = '';
					$("#text3").css("display", "inline-block");
					document.getElementById("text3").value = '';
					break;
				case '3':
					$("#select4").css("display", "none");
					document.getElementById("select4").value = 'change';
					$("#select5").css("display", "none");
					document.getElementById("select5").value = 'change';
					$("#select6").css("display", "none");
					document.getElementById("select6").value = 'change';
					$("#text1").css("display", "none");
					document.getElementById("text1").value = 'null';
					$("#text2").css("display", "none");
					document.getElementById("text2").value = '-1';
					$("#text3").css("display", "none");
					document.getElementById("text3").value = '-1';
					break;
				case '29':
				case '30':
					$("#text6").css("display", "inline-block");
					document.getElementById("text6").value = '';
					$("#text7").css("display", "inline-block");
					document.getElementById("text7").value = '';
					$("#select7").css("display", "inline-block");
					document.getElementById("select7").value = 'change';
					$("#select8").css("display", "inline-block");
					document.getElementById("select8").value = 'change';
					$("#select9").css("display", "inline-block");
					document.getElementById("select9").value = 'change';
					break;
				case '31':
					$("#text6").css("display", "none");
					document.getElementById("text6").value = 'null';
					$("#text7").css("display", "none");
					document.getElementById("text7").value = 'null';
					$("#select7").css("display", "none");
					document.getElementById("select7").value = 'change';
					$("#select8").css("display", "none");
					document.getElementById("select8").value = 'change';
					$("#select9").css("display", "none");
					document.getElementById("select9").value = 'change';
					break;
				default:
					$("#select3").css("display", "none");
					document.getElementById("select3").value = 'change';
			}
		}

		var answer;
		var msg;
		tg = window.Telegram.WebApp;

		function sendData() {
			var category = document.getElementById("select").value;
			var type = document.getElementById("select1").value;
			var type2 = document.getElementById("select2").value;
			var type3 = document.getElementById("select3").value;
			var type4 = document.getElementById("select4").value;
			var brand = document.getElementById("select5").value;
			var ownersCount = document.getElementById("select6").value;

			var location = document.getElementById("text").value;
			var model = document.getElementById("text1").value;
			var mileage = document.getElementById("text2").value;
			var born = document.getElementById("text3").value;
			var price = document.getElementById("text4").value;

			var message = document.getElementById("message").value;
			var image = document.getElementById("FileToSave").value;

			if (category == "change" || image == "" || location == "") {
				alert('Не все поля заполнены');
				return;
			}

			if (tg.initDataUnsafe.user.username == undefined) {
				alert("У вас не определен username, а без него мы не можем создать пост. Вы можете задать его в настройках Телеграм.");
				return;
			}

			document.querySelector(".loading").style.display = "block";

			msg = "%23" + category.slice(category.indexOf(';') + 1)
			if (type != 'change') { msg += "%0AКатегория: " + type.slice(type.indexOf(';') + 1) }
			if (type2 != 'change') { msg += "%0AПодкатегория: " + type2.slice(type2.indexOf(';') + 1) }
			if (type3 != 'change') { msg += "%0AВид: " + type3.slice(type3.indexOf(';') + 1) }
			if (type4 != 'change') { msg += "%0AТип автомобиля: " + type4.slice(type4.indexOf(';') + 1) }
			if (brand != 'change') { msg += "%0AМарка: " + brand.slice(brand.indexOf(';') + 1) }
			if (ownersCount != 'change') { msg += "%0AКол-во владельцев: " + ownersCount.slice(ownersCount.indexOf(';') + 1) }

			if (model != 'null') { msg += "%0AМодель: " + model }
			if (mileage != 'null') { msg += "%0AПробег: " + mileage }
			if (born != 'null') { msg += "%0AГод выпуска: " + born }
			if (price != '0') { msg += "%0AЦена: " + price }
			msg += "%0AКомментарий: " + message
			+ "%0AМестоположение: " + location
			+ "%0AАвтор поста: @" + tg.initDataUnsafe.user.username;
			setTimeout(sendSubmit, 1000);
		 	}; 
			function sendSubmit() {
				document.getElementById("authorHide").value = tg.initDataUnsafe.user.username;
				document.getElementById("authorIDHide").value = tg.initDataUnsafe.user.id;
				document.getElementById("messageHide").value = msg;
				document.getElementById("form").submit();
			}
	</script>
	<?php
		mysqli_close($link);
	?>
</body>
</html>