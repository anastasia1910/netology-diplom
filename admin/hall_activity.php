<?php
require_once('db_connect.php');

$data = json_decode(file_get_contents("php://input"), true);

$hall_id = $data['hall_id'] ?? '';

if (!empty($hall_id)) {
	$current_status_query = "SELECT activity FROM halls WHERE id = ?";
	if ($stmt = $db->prepare($current_status_query)) {
		$stmt->bind_param("i", $hall_id);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows == 1) {
			$stmt->bind_result($current_status);
			$stmt->fetch();
			$stmt->close();

			$update_query = "UPDATE halls SET activity = NOT activity WHERE id = ?";
			if ($update_stmt = $db->prepare($update_query)) {
				$update_stmt->bind_param("i", $hall_id);
				if ($update_stmt->execute()) {
					$new_status = $current_status ? 'неактивен' : 'активен';
					echo "Статус активности зала успешно изменен. Текущий статус: $new_status";
				} else {
					echo 'Произошла ошибка при изменении статуса активности зала: ' . $update_stmt->error;
				}
				$update_stmt->close();
			} else {
				echo 'Произошла ошибка при подготовке запроса для обновления статуса: ' . $db->error;
			}
		} else {
			echo 'Зал с указанным идентификатором не найден';
		}
	} else {
		echo 'Произошла ошибка при подготовке запроса для получения текущего статуса: ' . $db->error;
	}
} else {
	echo 'Не удалось получить id зала из запроса';
}

mysqli_close($db);
?>
