<?php
require_once('db_connect.php');

if (isset($_GET['hall_id'])) {
	$hallId = $_GET['hall_id'];

	$queryPrices = "SELECT standart_price, vip_price FROM prices WHERE hall_id = ?";
	$stmtPrices = $db->prepare($queryPrices);
	$stmtPrices->bind_param("i", $hallId);
	$stmtPrices->execute();
	$resultPrices = $stmtPrices->get_result();
	$prices = $resultPrices->fetch_assoc();
	$standardPrice = $prices['standart_price'];
	$vipPrice = $prices['vip_price'];

	$query = "SELECT DISTINCT row_num FROM seats WHERE hall_id = ?";
	$stmt = $db->prepare($query);
	$stmt->bind_param("i", $hallId);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$seatLayoutHtml = '<div class="buying-scheme">';
		while ($row = $result->fetch_assoc()) {
			$seatLayoutHtml .= '<div class="buying-scheme__row">';
			$query = "SELECT * FROM seats WHERE hall_id = ? AND row_num = ? ORDER BY seat_num";
			$stmt_seats = $db->prepare($query);
			$stmt_seats->bind_param("ii", $hallId, $row['row_num']);
			$stmt_seats->execute();
			$result_seats = $stmt_seats->get_result();

			while ($seat = $result_seats->fetch_assoc()) {
				$typeClass = '';
				$seatId = $seat['id'];

				$queryTaken = "SELECT seat_ids FROM tickets WHERE FIND_IN_SET(?, seat_ids)";
				$stmtTaken = $db->prepare($queryTaken);
				$stmtTaken->bind_param("i", $seatId);
				$stmtTaken->execute();
				$resultTaken = $stmtTaken->get_result();
				$isTaken = $resultTaken->num_rows > 0;

				switch ($seat['type']) {
					case 'standart':
						$typeClass = 'buying-scheme__chair buying-scheme__chair_standart';
						break;
					case 'vip':
						$typeClass = 'buying-scheme__chair buying-scheme__chair_vip';
						break;
					case 'disabled':
						$typeClass = 'buying-scheme__chair buying-scheme__chair_disabled';
						break;
					case 'taken':
						$typeClass = 'buying-scheme__chair buying-scheme__chair_taken';
						break;
					case 'selected':
						$typeClass = 'buying-scheme__chair buying-scheme__chair_selected';
						break;
				}

				if ($isTaken) {
					$typeClass .= ' buying-scheme__chair_taken';
				}

				$seatLayoutHtml .= '<span class="' . $typeClass . '" data-seat-id="' . $seatId . '"></span>';
			}
			$seatLayoutHtml .= '</div>';
		}
		$seatLayoutHtml .= '</div>';
		$seatLayoutHtml .= '<div class="buying-scheme__legend">';
		$seatLayoutHtml .= '<div class="col">';
		$seatLayoutHtml .= '<p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_standart"></span> Свободно (<span class="buying-scheme__legend-value">' . $standardPrice . '</span>руб)</p>';
		$seatLayoutHtml .= '<p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_vip"></span> Свободно VIP (<span class="buying-scheme__legend-value">' . $vipPrice . '</span>руб)</p>';
		$seatLayoutHtml .= '</div>';
		$seatLayoutHtml .= '<div class="col">';
		$seatLayoutHtml .= '<p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_taken"></span> Занято</p>';
		$seatLayoutHtml .= '<p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_selected"></span> Выбрано</p>';
		$seatLayoutHtml .= '</div>';
		$seatLayoutHtml .= '</div>';
		$seatLayoutHtml .= '</div>';

		$stmt->close();
		if ($stmt_seats instanceof mysqli_stmt) {
			$stmt_seats->close();
		}
		$stmtTaken->close();
		$stmtPrices->close();
		$db->close();

		echo $seatLayoutHtml;
	} else {
		echo '';
	}
} else {
	echo '';
}
?>