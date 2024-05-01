<?php
// Подключение к базе данных
require_once('db_connect.php');

function getMoviesList()
{
	global $db;

	$sql = "SELECT * FROM movies";
	$result = mysqli_query($db, $sql);

	if ($result) {
		$movies = array();

		while ($row = mysqli_fetch_assoc($result)) {
			$movies[] = array(
				'id' => $row['id'],
				'name' => $row['name'],
				'duration' => $row['duration'],
				'description' => $row['description'],
				'country' => $row['country'],
				'poster' => $row['poster']
			);
		}

		// Преобразуем массив в JSON и возвращаем его
		return json_encode($movies);
	} else {
		// Если запрос не выполнен успешно, возвращаем пустой JSON
		return json_encode(array());
	}

	mysqli_close($db);
}

// Возвращаем данные в формате JSON
echo getMoviesList();
?>
