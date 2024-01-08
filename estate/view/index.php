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
	<div class="filtersPage hidden" id="filtersPage">
		<p>Фильтры</p>
		<form method="GET" action="">
			<select id="select" name="category" onchange="categChange()">
				<option value="null">Категория</option>
				<?php
					$query = mysqli_query($link, "select * from category_ru");
					while ($result = mysqli_fetch_assoc($query)) {
				?>
				<option <?php if (isset($_GET['category'])) { if ($result['Category'] == $_GET['category']) { echo "selected"; }} ?> value="<?php echo $result['Category']; ?>"><?php echo $result['Category']; ?></option>
				<?php
					}
				?>
			</select>

			<select id="select1" name="type" style="display: none;">
				<option value="null">Тип</option>
				<?php
					$query = mysqli_query($link, "select * from estate_type_ru");
					while ($result = mysqli_fetch_assoc($query)) {
				?>
				<option <?php if (isset($_GET['type'])) { if ($result['Type'] == $_GET['type']) { echo "selected"; }} ?> value="<?php echo $result['Type']; ?>"><?php echo $result['Type']; ?></option>
				<?php
					}
				?>
			</select>

			<select id="select2" name="pool" style="display: none;">
				<option value="null">Бассейн</option>
				<?php
					$query = mysqli_query($link, "select * from estate_pool_ru");
					while ($result = mysqli_fetch_assoc($query)) {
				?>
				<option <?php if (isset($_GET['pool'])) { if ($result['Pool'] == $_GET['pool']) { echo "selected"; }} ?> value="<?php echo $result['Pool']; ?>"><?php echo $result['Pool']; ?></option>
				<?php
					}
				?>
			</select>

			<select id="select3" name="children" style="display: none;">
				<option value="null">Инфраструктура для детей</option>
				<?php
					$query = mysqli_query($link, "select * from estate_children_ru");
					while ($result = mysqli_fetch_assoc($query)) {
				?>
				<option <?php if (isset($_GET['children'])) { if ($result['Children'] == $_GET['children']) { echo "selected"; }} ?> value="<?php echo $result['Children']; ?>"><?php echo $result['Children']; ?></option>
				<?php
					}
				?>
			</select>

			<select id="select4" name="pet" style="display: none;">
				<option value="null">Домашние питомцы</option>
				<?php
					$query = mysqli_query($link, "select * from estate_pet_ru");
					while ($result = mysqli_fetch_assoc($query)) {
				?>
				<option <?php if (isset($_GET['pet'])) { if ($result['Pet'] == $_GET['pet']) { echo "selected"; }} ?> value="<?php echo $result['Pet']; ?>"><?php echo $result['Pet']; ?></option>
				<?php
					}
				?>
			</select>

			<select id="select5" name="rooms" style="display: none;">
				<option value="null">Количество комнат</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5 и более">5 и более</option>
			</select>

			<select id="select6" name="bathrooms" style="display: none;">
				<option value="null">Количество ванных</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5 и более">5 и более</option>
			</select>

			<div id="select7" class="price" style="display: none;">
				<label for="minPrice">Мин. цена</label>
				<input placeholder="Min price" type="number" name="minPrice" id="minPrice" value="<?php
					if (isset($_GET['minPrice'])) {
						echo $_GET['minPrice'];
					}
					else {
						echo 0;
					}
				?>">
				<label for="maxPrice">Макс. цена</label>
				<input placeholder="Max price" type="number" name="maxPrice" id="maxPrice" value="<?php
				if (isset($_GET['maxPrice'])) {
					echo $_GET['maxPrice'];
				}
				else {
					$query = mysqli_query($link, "SELECT MAX(Price) FROM estate_rent;");
					$result = mysqli_fetch_assoc($query);
					echo $result['MAX(Price)'];
				}
				?>">
			</div>

			<div id="select8" class="size" style="display: none;">
				<label for="minSize">Мин. площадь</label>
				<input placeholder="Min size" type="number" name="minSize" id="minSize" value="<?php
					if (isset($_GET['minSize'])) {
						echo $_GET['minSize'];
					}
					else {
						echo 0;
					}
				?>">
				<label for="maxSize">Макс. площадь</label>
				<input placeholder="Max size" type="number" name="maxSize" id="maxSize" value="<?php
				if (isset($_GET['maxSize'])) {
					echo $_GET['maxSize'];
				}
				else {
					$query = mysqli_query($link, "SELECT MAX(SizeOfSpace) FROM estate_rent;");
					$result = mysqli_fetch_assoc($query);
					echo $result['MAX(SizeOfSpace)'];
				}
				?>">
			</div>

			<div class="checkboxes">
			<input type="checkbox" name="author" id="author" <?php
				if (isset($_GET['author'])) {
					if ($_GET['author'] == "on") {
						echo "checked";
					}
				}
			?>>
			<label for="author">Мои посты</label>
			</div>
			<button type="submit" class="button">Применить</button>
		</form>
	</div>
	<ul>
		<div id="empty" style="display: none;">
			<p>Пусто</p>
		</div>
		<?php
		$query = mysqli_query($link, "select * from estate_ru");
		while ($result = mysqli_fetch_assoc($query)) {
		?>
		<li>
			<div class="container">
				<img src="/src/<?php echo $result['Image']?>" alt="Post image">
				<p id="category">Категория: <?php echo $result['Category']; ?></p>
				<p id="type">Тип: <?php echo $result['Type']; ?></p>
				<p id="rooms">Количество комнат: <?php echo $result['QuantityOfRooms']; ?></p>
				<p id="bathrooms">Количество ванных комнат: <?php echo $result['QuantityOfBathrooms']; ?></p>
				<p id="size">Площадь: <?php echo $result['SizeOfSpace']; ?>м²</p>
				<p id="pool">Бассейн: <?php echo $result['Pool']; ?></p>
				<p id="children">Инфраструктура для детей: <?php echo $result['Children']; ?></p>
				<p id="pet">Домашние питомцы: <?php echo $result['Pet']; ?></p>
				<p>Минимальный срок аренды: <?php echo $result['MinPeriod']; ?> <?php echo $result['Unit'] ?></p>
				<p id="price">Цена: <?php echo $result['Price']; ?> ฿</p>
				<p>Местоположение: <?php echo $result['Location']; ?></p>
				<p>Комментарий: <?php echo $result['Comment'];
					// $url = "https://iam.api.cloud.yandex.net/iam/v1/tokens";
					// $data = '{"yandexPassportOauthToken":"y0_AgAAAABp4I_WAATuwQAAAADx-YugPrgh18I3Sd24gKuYpwtqtKxGp68"}';

					// $ch = curl_init($url);

					// curl_setopt($ch, CURLOPT_POST, 1);
					// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
					// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

					// // Если вы хотите получить ответ от сервера в виде строки, а не выводить его напрямую
					// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

					// $response = curl_exec($ch);

					// if (curl_errno($ch)) {
					// 		echo 'Ошибка cURL: ' . curl_error($ch);
					// }

					// curl_close($ch);

					// // Декодируем JSON-ответ
					// $json_data = json_decode($response, true);

					// // Извлекаем iamToken
					// $iamToken = $json_data['iamToken'];
					// $IAM_TOKEN = $iamToken;
					// $folder_id = 'b1geogbm9dr51i1mbr5p';
					// $target_language = 'ru';
					// $texts = $result['Comment'];

					// $url = 'https://translate.api.cloud.yandex.net/translate/v2/translate';

					// $headers = [
					// 		'Content-Type: application/json',
					// 		"Authorization: Bearer $IAM_TOKEN"
					// ];

					// $post_data = [
					// 		"targetLanguageCode" => $target_language,
					// 		"texts" => $texts,
					// 		"folderId" => $folder_id,
					// ];

					// $data_json = json_encode($post_data);

					// $curl = curl_init();
					// curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
					// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					// // curl_setopt($curl, CURLOPT_VERBOSE, 1);
					// curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
					// curl_setopt($curl, CURLOPT_URL, $url);
					// curl_setopt($curl, CURLOPT_POST, true);

					// $answer = curl_exec($curl);

					// curl_close($curl);

					// // var_dump($answer);
					// $response = json_decode($answer, true);
					// echo $response['translations'][0]['text'];
				?></p>
				<p>Дата публикации: <?php echo $result['Date']; ?></p>
				<a href="https://t.me/tkuik_group/3/<?php echo $result['MsgID']; ?>"><span>💬</span> Перейти к посту</a>
				<a href="https://t.me/<?php echo $result['Author']; ?>"><span>👱</span> Личное сообщение автору</a>
				<?php
				if (isset($_COOKIE['huahinUserID']))
				if ($_COOKIE['huahinUserID'] == $result['AuthorID']) {
				?>
				<div class="edit_del">
					<a onclick="openCurrentPostEdit(<?php echo $result['ID']; ?>)"><span>📝</span> Изменить</a>
					<a onclick="openCurrentPostDel(<?php echo $result['ID']; ?>)"><span>❌</span> Удалить</a>
				</div>
				<?php
				}
				?>
				<p style="display: none;" id="author"><?php echo $result['AuthorID']; ?></p>
			</div>
		</li>
		<?php
		}
		?>
	</ul>

	<div class="footer">
		<a class="navBtn" id="back" href="/"><span>🏠</span></a>
		<button class="navBtn" id="filtersBtn"><img src="/src/filter.png" alt="Filters"></button>
	</div>
	<script src="https://telegram.org/js/telegram-web-app.js"></script>
	<script src="/script/script.js"></script>
	<script src="/script/estate_view.js"></script>
	<script>
		function categChange() {
			var categ = document.getElementById("select").value;
			if (categ == "Сдам") {
				document.getElementById("select1").style.display = "block";
				document.getElementById("select2").style.display = "block";
				document.getElementById("select3").style.display = "block";
				document.getElementById("select4").style.display = "block";
				document.getElementById("select5").style.display = "block";
				document.getElementById("select6").style.display = "block";
				document.getElementById("select7").style.display = "grid";
				document.getElementById("select8").style.display = "grid";
			}
			else if (categ == "Арендую") {
				document.getElementById("select1").style.display = "block";
				document.getElementById("select2").style.display = "none";
				document.getElementById("select3").style.display = "none";
				document.getElementById("select4").style.display = "none";
				document.getElementById("select5").style.display = "none";
				document.getElementById("select6").style.display = "none";
				document.getElementById("select7").style.display = "none";
				document.getElementById("select8").style.display = "none";

				document.getElementById("select2").value = 'null';
				document.getElementById("select3").value = 'null';
				document.getElementById("select4").value = 'null';
				document.getElementById("select5").value = 'null';
				document.getElementById("select6").value = 'null';
				document.getElementById("select7").value = 'null';
				document.getElementById("select8").value = 'null';
			}
			else {
				document.getElementById("select1").style.display = "none";
				document.getElementById("select2").style.display = "none";
				document.getElementById("select3").style.display = "none";
				document.getElementById("select4").style.display = "none";
				document.getElementById("select5").style.display = "none";
				document.getElementById("select6").style.display = "none";
				document.getElementById("select7").style.display = "none";
				document.getElementById("select8").style.display = "none";

				document.getElementById("select1").value = 'null';
				document.getElementById("select2").value = 'null';
				document.getElementById("select3").value = 'null';
				document.getElementById("select4").value = 'null';
				document.getElementById("select5").value = 'null';
				document.getElementById("select6").value = 'null';
				document.getElementById("select7").value = 'null';
				document.getElementById("select8").value = 'null';
			}
		}
	</script>
</body>
</html>