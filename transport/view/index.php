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
			<select name="category">
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
			<select name="type">
				<option value="null">Тип</option>
				<?php
					$query = mysqli_query($link, "select * from transport_type_ru");
					while ($result = mysqli_fetch_assoc($query)) {
				?>
				<option <?php if (isset($_GET['type'])) { if ($result['Type'] == $_GET['type']) { echo "selected"; }} ?> value="<?php echo $result['Type']; ?>"><?php echo $result['Type']; ?></option>
				<?php
					}
				?>
			</select>

			<div class=price>
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
					$query = mysqli_query($link, "SELECT MAX(Price) FROM transport_rent;");
					$result = mysqli_fetch_assoc($query);
					echo $result['MAX(Price)'];
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
		$query = mysqli_query($link, "select * from transport_ru");
		while ($result = mysqli_fetch_assoc($query)) {
		?>
		<li>
		<div class="container">
				<?php if ($result['Image'] != "null") { ?>
					<img src="/src/<?php echo $result['Image']?>" alt="Post image">
					<p id="category">Категория: <?php echo $result['Category']; ?></p>
					<p id="type">Тип: <?php echo $result['Type']; ?></p>
					<?php if ($result['Type'] == "Automobile") {?>
						<p>Тип автомобиля: <?php echo $result['Type2']; ?></p>
						<?php } ?>
					<p>Модель: <?php echo $result['Model']; ?></p>
					<p id="brand">Brand: <?php echo $result['Brand']; ?></p>
					<p>Минимальный срок аренды: <?php echo $result['MinPeriod']; ?> <?php echo $result['Unit'] ?></p>
					<p id="price">Цена: <?php echo $result['Price']; ?> ฿</p>
					<p>Комментарий: <?php 
					$url = "https://iam.api.cloud.yandex.net/iam/v1/tokens";
					$data = '{"yandexPassportOauthToken":"y0_AgAAAABp4I_WAATuwQAAAADx-YugPrgh18I3Sd24gKuYpwtqtKxGp68"}';

					$ch = curl_init($url);

					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

					// Если вы хотите получить ответ от сервера в виде строки, а не выводить его напрямую
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

					$response = curl_exec($ch);

					if (curl_errno($ch)) {
							echo 'Ошибка cURL: ' . curl_error($ch);
					}

					curl_close($ch);

					// Декодируем JSON-ответ
					$json_data = json_decode($response, true);

					// Извлекаем iamToken
					$iamToken = $json_data['iamToken'];
					$IAM_TOKEN = $iamToken;
					$folder_id = 'b1geogbm9dr51i1mbr5p';
					$target_language = 'ru';
					$texts = $result['Comment'];

					$url = 'https://translate.api.cloud.yandex.net/translate/v2/translate';

					$headers = [
							'Content-Type: application/json',
							"Authorization: Bearer $IAM_TOKEN"
					];

					$post_data = [
							"targetLanguageCode" => $target_language,
							"texts" => $texts,
							"folderId" => $folder_id,
					];

					$data_json = json_encode($post_data);

					$curl = curl_init();
					curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					// curl_setopt($curl, CURLOPT_VERBOSE, 1);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
					curl_setopt($curl, CURLOPT_URL, $url);
					curl_setopt($curl, CURLOPT_POST, true);

					$answer = curl_exec($curl);

					curl_close($curl);

					// var_dump($answer);
					$response = json_decode($answer, true);
					echo $response['translations'][0]['text'];
					?></p>
					<p>Дата публикации: <?php echo $result['Date']; ?></p>
					<a href="https://t.me/tkuik_group/2/<?php echo $result['MsgID']; ?>"><span>💬</span> Перейти к посту</a>
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
				<?php } else { ?>
					<p id="category">Категория: <?php echo $result['Category']; ?></p>
					<p id="type">Тип: <?php echo $result['Type']; ?></p>
					<?php if ($result['Type'] == "Automobile") {?>
						<p>Тип автомобиля: <?php echo $result['Type2']; ?></p>
						<?php } ?>
					<p>Минимальный срок аренды: <?php echo $result['MinPeriod']; ?> <?php echo $result['Unit'] ?></p>
					<p id="price">Цена: <?php echo $result['Price']; ?> ฿</p>
					<p>Дата публикации: <?php echo $result['Date']; ?></p>
					<a href="https://t.me/tkuik_group/2/<?php echo $result['MsgID']; ?>"><span>💬</span> Перейти к посту</a>
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
				<?php } ?>
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
	<script src="/script/transport_view.js"></script>
</body>
</html>