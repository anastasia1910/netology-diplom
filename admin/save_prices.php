<?php
require_once('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$data = json_decode(file_get_contents("php://input"), true);

	if (isset($data['hall']) && isset($data['standardPrice']) && isset($data['vipPrice'])) {
		$hallId = mysqli_real_escape_string($db, $data['hall']);
		$standardPrice = mysqli_real_escape_string($db, $data['standardPrice']);
		$vipPrice = mysqli_real_escape_string($db, $data['vipPrice']);

		$query = "SELECT * FROM prices WHERE hall_id = '$hallId'";
		$result = mysqli_query($db, $query);

		if ($result) {
			if (mysqli_num_rows($result) > 0) {
				$updateQuery = "UPDATE prices SET standard_price = '$standardPrice', vip_price = '$vipPrice' WHERE hall_id = '$hallId'";
				$updateResult = mysqli_query($db, $updateQuery);
				if ($updateResult) {
					echo 'Цены для зала ' . $hallId . ' успешно обновлены!';
				} else {
					echo 'Ошибка при обновлении цен: ' . mysqli_error($db);
				}
			} else {
				$insertQuery = "INSERT INTO prices (hall_id, standard_price, vip_price) VALUES ('$hallId', '$standardPrice', '$vipPrice')";
				$insertResult = mysqli_query($db, $insertQuery);
				if ($insertResult) {
					echo 'Цены для зала ' . $hallId . ' успешно сохранены!';
				} else {
					echo 'Ошибка при сохранении цен: ' . mysqli_error($db);
				}
			}
		} else {
			echo 'Ошибка: ' . mysqli_error($db);
		}
	} else {
		echo 'Ошибка: Некорректные данные';
	}
} else {
	echo 'Доступ запрещен';
}

mysqli_close($db);
?>
