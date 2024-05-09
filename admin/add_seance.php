<?php
require_once('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$hall_id = $_POST['hall_id'];
	$movie_id = $_POST['movie_id'];
	$start_time = $_POST['start_time'];

	$sql = "SELECT duration FROM movies WHERE id = ?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param("i", $movie_id);
	$stmt->execute();
	$stmt->bind_result($duration);
	$stmt->fetch();
	$stmt->close();

	list($hours, $minutes) = explode(':', $start_time);
	$start_minutes = $hours * 60 + $minutes;

	$overlap_check_query = "SELECT * FROM seances WHERE hall_id = ? AND ((TIME_TO_SEC(start_time) / 60 <= ? AND TIME_TO_SEC(ADDTIME(start_time, SEC_TO_TIME(? * 60))) / 60 > ?) OR (TIME_TO_SEC(start_time) / 60 >= ? AND TIME_TO_SEC(start_time) / 60 < TIME_TO_SEC(ADDTIME(?, SEC_TO_TIME(? * 60))) / 60))";
	$stmt = $db->prepare($overlap_check_query);
	$stmt->bind_param("iiiiisi", $hall_id, $start_minutes, $duration, $start_minutes, $start_minutes, $start_time, $duration);
	$stmt->execute();
	$result = $stmt->get_result();
	$existing_seances = $result->fetch_all(MYSQLI_ASSOC);
	$stmt->close();

	if (count($existing_seances) > 0) {
		echo json_encode(array('success' => false, 'message' => 'Время сеанса перекрывается с существующими сеансами'));
	} else {
		$sql = "INSERT INTO seances (hall_id, movie_id, start_time) VALUES (?, ?, ?)";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("iis", $hall_id, $movie_id, $start_time);
		if ($stmt->execute()) {
			$response = 'Сеанс успешно добавлен';
			echo json_encode(array('success' => true, 'message' => $response));
		} else {
			$response = 'Произошла ошибка при добавлении сеанса: ' . $stmt->error;
			echo json_encode(array('success' => false, 'message' => $response));
		}
		$stmt->close();
	}
} else {
	echo json_encode(array('success' => false, 'message' => 'Неверный запрос'));
}

mysqli_close($db);

?>
