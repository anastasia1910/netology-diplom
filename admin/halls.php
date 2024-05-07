<?php
function getHalls() {
	$db = mysqli_connect('localhost', 'root', '', 'cinema');
	$query = "SELECT * FROM halls";
	$result = mysqli_query($db, $query);
	$halls = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$halls[] = $row;
	}
	mysqli_close($db);
	$json_halls = json_encode($halls);
	return $json_halls;
}

function deleteHall($id) {
	$db = mysqli_connect('localhost', 'root', '', 'cinema');

	$query_prices = "DELETE FROM prices WHERE hall_id = $id";
	mysqli_query($db, $query_prices);

	$query_seances = "DELETE FROM seances WHERE hall_id = $id";
	mysqli_query($db, $query_seances);

	$query_seats = "DELETE FROM seats WHERE hall_id = $id";
	mysqli_query($db, $query_seats);

	$query_hall = "DELETE FROM halls WHERE id = $id";
	mysqli_query($db, $query_hall);

	mysqli_close($db);
}


function addHall($name) {
	$db = mysqli_connect('localhost', 'root', '', 'cinema');

	$name = mysqli_real_escape_string($db, $name);
	$query = "INSERT INTO halls (name) VALUES ('$name')";
	$result = mysqli_query($db, $query);
	$halls = getHalls();
	mysqli_close($db);
	return $halls;
}

?>
