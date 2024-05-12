<?php
require_once('db_connect.php');

$name = $_POST['name'] ?? '';
$duration = $_POST['duration'] ?? '';
$description = $_POST['description'] ?? '';
$country = $_POST['country'] ?? '';

if ($_FILES['poster']['error'] === UPLOAD_ERR_OK) {
	$poster_tmp_name = $_FILES['poster']['tmp_name'];
	$poster_name = basename($_FILES['poster']['name']);
	$poster_path = '../img/posters/' . $poster_name;

	if (move_uploaded_file($poster_tmp_name, $poster_path)) {

	} else {

	}
}

$sql = "INSERT INTO movies (name, duration, description, country, poster) VALUES (?, ?, ?, ?, ?)";

if ($stmt = $db->prepare($sql)) {
	$stmt->bind_param("sisss", $name, $duration, $description, $country, $poster_path);

	if ($stmt->execute()) {
		$response = array(
			'success' => true,
			'message' => 'Фильм успешно добавлен',
			'name' => $name
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
