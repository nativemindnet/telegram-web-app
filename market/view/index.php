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
				<option value="null">Выбрать</option>
				<?php
					$query = mysqli_query($link, "select * from market_category_ru");
					while ($result = mysqli_fetch_assoc($query)) {
				?>
				<option <?php if (isset($_GET['category'])) { if ($result['Category'] == $_GET['category']) { echo "selected"; }} ?> value="<?php echo $result['Category']; ?>"><?php echo $result['Category']; ?></option>
				<?php
					}
				?>
			</select>

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
		$query = mysqli_query($link, "select * from market_posts_ru");
		while ($result = mysqli_fetch_assoc($query)) {
		?>
		<li>
			<div class="container">
				<img src="/src/<?php echo $result['Image']; ?>" alt="Post image">
				<p id="category">#<?php echo $result['Category']; ?></p>
				<?php
				if (filter_var($result['Location'], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
					echo '<a href="'.$result['Location'].'"><span>🗺️</span> Местоположение</a>';
				}
				else {
					echo '<p>Местоположение: '.$result['Location'].'</p>';
				}
				?>
				<?php
					if ($result['Type'] != '') { echo '<p>'.'Категория: '.$result['Type'].'</p>'; }
					if ($result['Type2'] != '') { echo '<p>'.'Подкатегория: '.$result['Type2'].'</p>'; }
					if ($result['Type3'] != '') { echo '<p>'.'Вид: '.$result['Type3'].'</p>'; }
					if ($result['Type4'] != '') { echo '<p>'.'Тип автомомбиля: '.$result['Type4'].'</p>'; }
					if ($result['Brand'] != '') { echo '<p>'.'Марка: '.$result['Brand'].'</p>'; }
					if ($result['OwnersCount'] != 'change') { echo '<p>'.'Кол-во владельцев: '.$result['OwnersCount'].'</p>'; }
					if ($result['Model'] != 'null') { echo '<p>'.'Модель: '.$result['Model'].'</p>'; }
					if ($result['Mileage'] != '-1') { echo '<p>'.'Пробег: '.$result['Mileage'].'</p>'; }
					if ($result['Born'] != '-1') { echo '<p>'.'Год выпуска: '.$result['Born'].'</p>'; }
					if ($result['Price'] != '-1') { echo '<p>'.'Цена: '.$result['Price'].' ฿</p>'; }
				?>
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
					$texts = $result['Message'];

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
				<a href="https://t.me/tkuik_group/322/<?php echo $result['MsgID']; ?>"><span>💬</span> Перейти к объявлению</a>
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
</body>
</html>