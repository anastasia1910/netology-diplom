<?php

$queryMovies = "SELECT * FROM movies";
$resultMovies = mysqli_query($db, $queryMovies);
if ($resultMovies) {
	while ($movie = mysqli_fetch_assoc($resultMovies)) {
		$querySeances = "SELECT seances.id, seances.start_time, halls.name AS hall_name 
                 FROM seances 
                 JOIN halls ON seances.hall_id = halls.id 
                 WHERE seances.movie_id = $movie[id] AND halls.activity = 1";
		$resultSeances = mysqli_query($db, $querySeances);

		if (mysqli_num_rows($resultSeances) > 0) {
			echo "<section class=\"movie\">";
			echo "<div class=\"movie__info\">";
			echo "<div class=\"movie__poster\">";
		echo "<img class=\"movie__poster-image\" alt=\"$movie[name] постер\" src=\"$movie[poster]\">";
			echo "</div>";
			echo "<div class=\"movie__description\">";
			echo "<h2 class=\"movie__title\">$movie[name]</h2>";
			echo "<p class=\"movie__synopsis\">$movie[description]</p>";
			echo "<p class=\"movie__data\">";
			echo "<span class=\"movie__data-duration\">$movie[duration] минут </span>";
			echo "<span class=\"movie__data-origin\">$movie[country]</span>";
			echo "</p>";
			echo "</div>";
			echo "</div>";

			echo "<div class=\"movie-seances\">";
			while ($seance = mysqli_fetch_assoc($resultSeances)) {
				$fullDate = $_GET['fullDate'] ?? date('Y-m-d');
				echo "<div class=\"movie-seances__hall\">";
				echo "<h3 class=\"movie-seances__hall-title\">$seance[hall_name]</h3>";
				echo "<ul class=\"movie-seances__list\">";
				echo "<li class=\"movie-seances__time-block\"><a class=\"movie-seances__time\" href=\"#\" data-seance-id=\"$seance[id]\" onclick=\"return updateDate(this, '$seance[start_time]');\">$seance[start_time]</a></li>";
				echo "</ul>";
				echo "</div>";
			}
			echo "</div>";

			echo "</section>";
		}
	}
} else {
	echo "Ошибка при получении информации о фильмах";
}

mysqli_close($db);
?>
<script>
    function updateDate(link, startTime) {
        const chosenDate = document.querySelector('.page-nav__day_chosen').getAttribute('data-full-date');
        const seanceId = link.getAttribute('data-seance-id');
        const newHref = `hall.php?seance_id=${seanceId}&date=${chosenDate}&startTime=${startTime}`;
        link.href = newHref;
        return true;
    }
</script>

