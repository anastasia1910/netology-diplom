<?php
require_once('db_connect.php');


$name = $_POST['name'] ?? '';
$duration = $_POST['duration'] ?? '';
$description = $_POST['description'] ?? '';
$country = $_POST['country'] ?? '';
$hall_id = $_POST['hall'] ?? '';

$sql = "INSERT INTO movies (name, duration, description, country, hall_id) VALUES (?, ?, ?, ?, ?)";

if ($stmt = $db->prepare($sql)) {
	$stmt->bind_param("sissi", $name, $duration, $description, $country, $hall_id);

	if ($stmt->execute()) {

		$response = array(
			'success' => true,
			'message' => 'Фильм успешно добавлен'
		);
		echo json_encode($response);
	} else {
		$response = array(
			'success' => false,
			'message' => 'Произошла ошибка при добавлении фильма'
		);
		echo json_encode($response);
	}


	$stmt->close();
} else {
	$response = array(
		'success' => false,
		'message' => 'Произошла ошибка при подготовке запроса'
	);
	echo json_encode($response);
}

mysqli_close($db);
?>
