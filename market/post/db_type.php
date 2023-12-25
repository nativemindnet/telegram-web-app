<?php
include $_SERVER['DOCUMENT_ROOT'] . "/db.php";
$type1 = $_POST['data'];

$query = mysqli_query($link, "SELECT market_type2_ru.ID,
market_type2_ru.Type2 as type2_ru FROM market_type2_ru
WHERE market_type2_ru.Type = '$type1'");

while ($result = mysqli_fetch_assoc($query)) {
	$data[] = array(
		'id' => $result['ID'].';'.$result['type2_ru'],
		'type' => $result['type2_ru']
	);
}
echo json_encode($data);
?>