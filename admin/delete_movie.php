<?php
require_once('db_connect.php');

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$data = json_decode(file_get_contents("php://input"), true);

	if (isset($data['id'])) {
		$movieId = $data['id'];

		$deleteSeancesQuery = "DELETE FROM seances WHERE movie_id = ?";
		$stmtSeances = mysqli_prepare($db, $deleteSeancesQuery);
		mysqli_stmt_bind_param($stmtSeances, 'i', $movieId);
		mysqli_stmt_execute($stmtSeances);

		if (mysqli_stmt_affected_rows($stmtSeances) >= 0) {
			$deleteMovieQuery = "DELETE FROM movies WHERE id = ?";
			$stmtMovie = mysqli_prepare($db, $deleteMovieQuery);
			mysqli_stmt_bind_param($stmtMovie, 'i', $movieId);
			mysqli_stmt_execute($stmtMovie);

			if (mysqli_stmt_affected_rows($stmtMovie) > 0) {
				$response['success'] = true;
				$response['message'] = 'Фильм и связанные с ним записи сеансов успешно удалены';
			} else {
				$response['message'] = 'Ошибка при удалении фильма: ' . mysqli_error($db);
			}
		} else {
			$response['message'] = 'Ошибка при удалении связанных с фильмом записей сеансов: ' . mysqli_error($db);
		}
	} else {
		$response['message'] = 'Ошибка: Некорректные данные';
	}
} else {
	$response['message'] = 'Доступ запрещен';
}

mysqli_close($db);

echo json_encode($response);
?>
