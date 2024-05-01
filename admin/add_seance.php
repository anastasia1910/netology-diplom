<?php
require_once('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$hall_id = $_POST['hall_id'];
	$movie_id = $_POST['movie_id'];
	$start_time = $_POST['start_time'];

	$sql = "INSERT INTO seances (hall_id, movie_id, start_time) VALUES (?, ?, ?)";
	if ($stmt = $db->prepare($sql)) {
		$stmt->bind_param("iis", $hall_id, $movie_id, $start_time);
		if ($stmt->execute()) {
			$response = 'Сеанс успешно добавлен';
		} else {
			$response = 'Произошла ошибка при добавлении сеанса: ' . $stmt->error;
		}
		$stmt->close();
	} else {
		$response = 'Произошла ошибка при подготовке запроса: ' . $db->error;
	}

	echo json_encode(array('success' => true, 'message' => $response));
} else {
	echo json_encode(array('success' => false, 'message' => 'Неверный запрос'));
}

mysqli_close($db);
?>