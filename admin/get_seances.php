<?php
// Подключение к базе данных
require_once('db_connect.php');

$sql = "SELECT seances.id AS seance_id, 
               seances.hall_id, 
               seances.movie_id, 
               seances.start_time, 
               movies.name AS movie_name, 
               movies.duration AS movie_duration,
               halls.name AS hall_name
        FROM seances
        INNER JOIN movies ON seances.movie_id = movies.id
        INNER JOIN halls ON seances.hall_id = halls.id";

$result = mysqli_query($db, $sql);

if ($result) {
	$seances = array();

	while ($row = mysqli_fetch_assoc($result)) {
		$seances[] = array(
			'id' => $row['seance_id'],
			'hall_id' => $row['hall_id'],
			'hall_name' => $row['hall_name'],
			'movie_id' => $row['movie_id'],
			'movie_name' => $row['movie_name'],
			'movie_duration' => $row['movie_duration'],
			'start_time' => $row['start_time']
		);
	}

	echo json_encode($seances);
} else {
	echo json_encode(array());
}

mysqli_close($db);
?>
