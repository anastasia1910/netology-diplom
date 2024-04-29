<?php
require_once('db_connect.php');


$data = json_decode(file_get_contents('php://input'), true);
$hallId = $data['hall_id'];
$seatLayoutData = $data['seatLayoutData'];

$queryDelete = "DELETE FROM seats WHERE hall_id = ?";
$stmtDelete = $db->prepare($queryDelete);
$stmtDelete->bind_param("i", $hallId);
$stmtDelete->execute();

$queryInsert = "INSERT INTO seats (hall_id, row_num, seat_num, type) VALUES (?, ?, ?, ?)";
$stmtInsert = $db->prepare($queryInsert);
foreach ($seatLayoutData as $seat) {
	$stmtInsert->bind_param("iiis", $seat['hall_id'], $seat['row_num'], $seat['seat_num'], $seat['type']);
	$stmtInsert->execute();
}

echo 'Seats configuration saved successfully';
?>
