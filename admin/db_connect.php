<?php
$db = mysqli_connect('localhost', 'root', '', 'cinema');

if (!$db) {
	die("Ошибка подключения: " . mysqli_connect_error());
}
?>