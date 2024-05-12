<?php

require_once 'header.php';

if (isset($_GET['seance_id']) && isset($_GET['seat_ids'])) {
	$seanceId = $_GET['seance_id'];
	$seatIds = $_GET['seat_ids'];

	$querySeance = "SELECT seances.start_time, halls.id AS hall_id, halls.name AS hall_name, movies.name AS movie_name, movies.duration, movies.country, movies.description FROM seances 
                    JOIN halls ON seances.hall_id = halls.id 
                    JOIN movies ON seances.movie_id = movies.id 
                    WHERE seances.id = ?";
	$stmtSeance = $db->prepare($querySeance);
	$stmtSeance->bind_param("i", $seanceId);
	$stmtSeance->execute();
	$resultSeance = $stmtSeance->get_result();
	$seance = $resultSeance->fetch_assoc();

	$seatIdsArray = explode(',', $seatIds);
	$seatNumbers = array();
	$totalCost = 0;

	$querySeat = "SELECT s.row_num, s.seat_num, s.type, 
              CASE 
                WHEN s.type = 'standart' THEN p.standart_price 
                WHEN s.type = 'vip' THEN p.vip_price 
              END AS seat_price 
              FROM seats s 
              JOIN prices p ON s.hall_id = p.hall_id 
              WHERE s.id IN (" . implode(',', array_fill(0, count($seatIdsArray), '?')) . ") 
              AND p.hall_id = ?";
	$stmtSeat = $db->prepare($querySeat);
	$params = array_merge($seatIdsArray, [$seance['hall_id']]);
	$stmtSeat->bind_param(str_repeat('i', count($params)), ...$params);
	$stmtSeat->execute();
	$resultSeat = $stmtSeat->get_result();

	while ($seat = $resultSeat->fetch_assoc()) {
		$totalCost += $seat['seat_price'];
		$seatNumbers[] = "Ряд " . $seat['row_num'] . ", Место " . $seat['seat_num'];
	}

	?>
	<main>
		<section class="ticket">
			<header class="tichet__check">
				<h2 class="ticket__check-title">Вы выбрали билеты:</h2>
			</header>
			<div class="ticket__info-wrapper">
				<p class="ticket__info">На фильм: <span class="ticket__details ticket__title"><?= $seance['movie_name'] ?></span></p>
				<p class="ticket__info">Места: <span class="ticket__details ticket__chairs"><?= implode(', ', $seatNumbers) ?></span></p>
				<p class="ticket__info">В зале: <span class="ticket__details ticket__hall"><?= $seance['hall_name'] ?></span></p>
				<p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start"><?= date("Y-m-d H:i", strtotime($seance['start_time'])) ?></span></p>
				<p class="ticket__info">Стоимость: <span class="ticket__details ticket__cost"><?= $totalCost ?> рублей</span></p>

				<form id="ticketForm" action="ticket.php" method="post">
					<input type="hidden" name="seance_id" value="<?= $seanceId ?>">
					<input type="hidden" name="seat_ids" value="<?= $seatIds ?>">
					<input type="hidden" name="movie_name" value="<?= $seance['movie_name'] ?>">
					<input type="hidden" name="hall_name" value="<?= $seance['hall_name'] ?>">
					<input type="hidden" name="start_time" value="<?= date("Y-m-d H:i", strtotime($seance['start_time'])) ?>">
					<input type="hidden" name="total_cost" value="<?= $totalCost ?>">
					<button type="submit" class="acceptin-button">Получить код бронирования</button>
				</form>

				<p class="ticket__hint">После оплаты билет будет доступен в этом окне, а также придёт вам на почту. Покажите QR-код нашему контроллёру у входа в зал.</p>
				<p class="ticket__hint">Приятного просмотра!</p>
			</div>
		</section>
	</main>
	<?php
} else {
	echo "Нет данных.";
}
?>