<?php
require_once 'halls.php';

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	deleteHall($id);

	$halls = json_decode(getHalls(), true);
	echo json_encode($halls);
	exit();
}
?>
