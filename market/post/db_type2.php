<?php
include $_SERVER['DOCUMENT_ROOT'] . "/db.php";
$type2 = $_POST['data'];

$query = mysqli_query($link, "SELECT market_type3_ru.ID,
market_type3_ru.Type3 as type3_ru FROM market_type3_ru
WHERE market_type3_ru.Type2 = '$type2'");

while ($result = mysqli_fetch_assoc($query)) {
	$data[] = array(
		'id' => $result['ID'].';'.$result['type3_ru'],
		'type' => $result['type3_ru']
	);
}
echo json_encode($data);
?>