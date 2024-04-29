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
	$query = "DELETE FROM halls WHERE id = $id";
	mysqli_query($db, $query);
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
