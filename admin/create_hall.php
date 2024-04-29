<?php

require_once 'halls.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
	$name = $_POST['name'];
	$halls = addHall($name);
	echo $halls;
	exit();
}

http_response_code(400);
exit();

?>

