<?php
require_once('db_connect.php');

if (isset($_GET['hall_id'])) {
	$hallId = $_GET['hall_id'];

	$query = "SELECT DISTINCT row_num FROM seats WHERE hall_id = ?";
	$stmt = $db->prepare($query);
	$stmt->bind_param("i", $hallId);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$seatLayoutHtml = '<div class="conf-step__hall">';
		$seatLayoutHtml .= '<div class="conf-step__hall-wrapper">';
		while ($row = $result->fetch_assoc()) {
			$seatLayoutHtml .= '<div class="conf-step__row">';
			$query = "SELECT * FROM seats WHERE hall_id = ? AND row_num = ? ORDER BY seat_num";
			$stmt_seats = $db->prepare($query);
			$stmt_seats->bind_param("ii", $hallId, $row['row_num']);
			$stmt_seats->execute();
			$result_seats = $stmt_seats->get_result();

			while ($seat = $result_seats->fetch_assoc()) {
				$typeClass = '';
				switch ($seat['type']) {
					case 'standart':
						$typeClass = 'conf-step__chair_standart';
						break;
					case 'vip':
						$typeClass = 'conf-step__chair_vip';
						break;
					case 'disabled':
						$typeClass = 'conf-step__chair_disabled';
						break;
				}
				$seatLayoutHtml .= '<span class="conf-step__chair ' . $typeClass . '" data-seat-type="' . $seat['type'] . '"></span>';
			}
			$seatLayoutHtml .= '</div>';
		}
		$seatLayoutHtml .= '</div>';
		$seatLayoutHtml .= '</div>';

		$stmt->close();
		if ($stmt_seats instanceof mysqli_stmt) {
			$stmt_seats->close();
		}
		$db->close();

		echo $seatLayoutHtml;
	} else {
		echo '';
	}
} else {

	echo '';
}

?>