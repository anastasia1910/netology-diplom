<?php
require_once('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$data = json_decode(file_get_contents("php://input"), true);

	if (isset($data['seance_id'])) {
		$seance_id = $data['seance_id'];

		$deleteSeanceQuery = "DELETE FROM seances WHERE id = ?";
		$stmt = mysqli_prepare($db, $deleteSeanceQuery);
		mysqli_stmt_bind_param($stmt, 'i', $seance_id);
		mysqli_stmt_execute($stmt);

		if (mysqli_stmt_affected_rows($stmt) > 0) {
			echo json_encode(array('success' => true, 'message' => 'Сеанс успешно удален'));
		} else {
			echo json_encode(array('success' => false, 'message' => 'Не удалось найти сеанс для удаления'));
		}

		mysqli_stmt_close($stmt);
	} else {
		echo json_encode(array('success' => false, 'message' => 'Ключ seance_id не был передан'));
	}
} else {
	echo json_encode(array('success' => false, 'message' => 'Неверный метод запроса'));
}

mysqli_close($db);
?>
