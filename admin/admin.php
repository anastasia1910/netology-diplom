<?php
require_once 'header.php';

if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit();
}

require_once 'section_halls.php';

require_once 'section_seats.php';

require_once 'section_prices.php';

require_once 'section_movies.php';

require_once 'section_seances.php';

require_once 'section_sales.php';

require_once 'footer.php';
?>
