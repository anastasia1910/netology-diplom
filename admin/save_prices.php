<?php
require_once('db_connect.php');

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$data = json_decode(file_get_contents("php://input"), true);

	if (isset($data['hall']) && isset($data['standardPrice']) && isset($data['vipPrice'])) {
		$hallId = $data['hall'];
		$standardPrice = $data['standardPrice'];
		$vipPrice = $data['vipPrice'];

		$query = "SELECT * FROM prices WHERE hall_id = ?";
		$stmt = mysqli_prepare($db, $query);
		mysqli_stmt_bind_param($stmt, 'i', $hallId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		if ($result) {
			if (mysqli_num_rows($result) > 0) {
				$updateQuery = "UPDATE prices SET standard_price = ?, vip_price = ? WHERE hall_id = ?";
				$stmt = mysqli_prepare($db, $updateQuery);
				mysqli_stmt_bind_param($stmt, 'iii', $standardPrice, $vipPrice, $hallId);
				mysqli_stmt_execute($stmt);
				if (mysqli_stmt_affected_rows($stmt) > 0) {
					$response['success'] = true;
					$response['message'] = 'Цены для зала ' . $hallId . ' успешно обновлены!';
				} else {
					$response['message'] = 'Ошибка при обновлении цен: ' . mysqli_error($db);
				}
			} else {
				$insertQuery = "INSERT INTO prices (hall_id, standard_price, vip_price) VALUES (?, ?, ?)";
				$stmt = mysqli_prepare($db, $insertQuery);
				mysqli_stmt_bind_param($stmt, 'iii', $hallId, $standardPrice, $vipPrice);
				mysqli_stmt_execute($stmt);
				if (mysqli_stmt_affected_rows($stmt) > 0) {
					$response['success'] = true;
					$response['message'] = 'Цены для зала успешно сохранены!';
				} else {
					$response['message'] = 'Ошибка при сохранении цен: ' . mysqli_error($db);
				}
			}
		} else {
			$response['message'] = 'Ошибка: ' . mysqli_error($db);
		}
	} else {
		$response['message'] = 'Ошибка: Некорректные данные';
	}
} else {
	$response['message'] = 'Доступ запрещен';
}

mysqli_close($db);

echo json_encode($response);
?>
