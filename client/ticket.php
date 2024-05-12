<?php
require_once 'header.php';
require_once '../vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

if (isset($_POST['seance_id']) && isset($_POST['seat_ids']) && isset($_POST['movie_name']) && isset($_POST['hall_name']) && isset($_POST['start_time']) && isset($_POST['total_cost'])) {
	$seanceId = $_POST['seance_id'];
	$seatIds = $_POST['seat_ids'];
	$movieName = $_POST['movie_name'];
	$hallName = $_POST['hall_name'];
	$start_time = $_POST['start_time'];
	$totalCost = $_POST['total_cost'];

	$start_time = date('Y-m-d H:i:s', strtotime($start_time));

	$query = "SELECT * FROM tickets WHERE movie_name = ? AND hall_name = ? AND seat_ids = ? AND start_time = ?";
	$stmt = $db->prepare($query);
	$stmt->bind_param("ssss", $movieName, $hallName, $seatIds, $start_time);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$ticket = $result->fetch_assoc();
		?>
			<main>
				<section class="ticket">
					<header class="ticket__check">
						<h2 class="ticket__check-title">Ваш билет:</h2>
					</header>
					<div class="ticket__info-wrapper">
						<p class="ticket__info">На фильм: <span
								class="ticket__details ticket__title"><?= $ticket['movie_name'] ?></span></p>
						<p class="ticket__info">Места: <span class="ticket__details ticket__hall">
                        <?php
						$seatIdsArray = explode(',', $ticket['seat_ids']);
						$seatNumbers = array();
						foreach ($seatIdsArray as $seatId) {
							$querySeat = "SELECT s.row_num, s.seat_num FROM seats s WHERE s.id = ?";
							$stmtSeat = $db->prepare($querySeat);
							$stmtSeat->bind_param("i", $seatId);
							$stmtSeat->execute();
							$resultSeat = $stmtSeat->get_result();
							$seat = $resultSeat->fetch_assoc();
							$seatNumbers[] = "Ряд " . $seat['row_num'] . ", Место " . $seat['seat_num'];
						}
						echo implode(', ', $seatNumbers);
						?>
                    </span>
						</p>
						<p class="ticket__info">В зале: <span
								class="ticket__details ticket__hall"><?= $ticket['hall_name'] ?></span></p>
						<p class="ticket__info">Начало сеанса: <span
								class="ticket__details ticket__start"><?= $ticket['start_time'] ?></span></p>
						<p class="ticket__info">Стоимость: <span class="ticket__details ticket__cost"><?= $ticket['total_cost'] ?> рублей</span>
						</p>
						<p class="ticket__info">Код бронирования: <span
								class="ticket__details ticket__code"><?= $ticket['ticket_code'] ?></span>
						</p>
						<img src="../img/qrcode/qr_code_<?= $ticket['ticket_code'] ?>.png" alt="QR code" class="ticket__info-qr">
						<p class="ticket__hint">Покажите QR-код нашему контроллёру у входа в зал.</p>
						<p class="ticket__hint">Приятного просмотра!</p>
					</div>
				</section>
			</main>
		<?php
	} else {

		function generateTicketCode()
		{
			$code = '';
			for ($i = 0; $i < 6; $i++) {
				$code .= rand(0, 9);
			}
			return $code;
		}

		$ticketCode = generateTicketCode();

		$query = "INSERT INTO tickets (seance_id, seat_ids, movie_name, hall_name, start_time, total_cost, ticket_code) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$stmt = $db->prepare($query);
		$stmt->bind_param("isssssi", $seanceId, $seatIds, $movieName, $hallName, $start_time, $totalCost, $ticketCode);
		$stmt->execute();

		$qrCode = new QrCode($ticketCode);
		$qrCode->setSize(200);

		$writer = new PngWriter();
		$result = $writer->write($qrCode);

		$qrCodeUrl = '../img/qrcode/qr_code_' . $ticketCode . '.png';
		file_put_contents($qrCodeUrl, $result->getString());
		?>
			<main>
				<section class="ticket">
					<header class="ticket__check">
						<h2 class="ticket__check-title">Ваш билет:</h2>
					</header>
					<div class="ticket__info-wrapper">
						<p class="ticket__info">На фильм: <span class="ticket__details ticket__title"><?= $movieName ?></span></p>
						<p class="ticket__info">Места: <span class="ticket__details ticket__hall">
                        <?php
						$seatIdsArray = explode(',', $seatIds);
						$seatNumbers = array();
						foreach ($seatIdsArray as $seatId) {
							$querySeat = "SELECT s.row_num, s.seat_num FROM seats s WHERE s.id = ?";
							$stmtSeat = $db->prepare($querySeat);
							$stmtSeat->bind_param("i", $seatId);
							$stmtSeat->execute();
							$resultSeat = $stmtSeat->get_result();
							$seat = $resultSeat->fetch_assoc();
							$seatNumbers[] = "Ряд " . $seat['row_num'] . ", Место " . $seat['seat_num'];
						}
						echo implode(', ', $seatNumbers);
						?>
                    </span>
						</p>
						<p class="ticket__info">В зале: <span class="ticket__details ticket__hall"><?= $hallName ?></span></p>
						<p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start"><?= $start_time ?></span>
						</p>
						<p class="ticket__info">Стоимость: <span
								class="ticket__details ticket__cost"><?= $totalCost ?> рублей</span>
						</p>
						<p class="ticket__info">Код бронирования: <span
								class="ticket__details ticket__code"><?= $ticketCode ?></span>
						</p>
						<img src="<?= $qrCodeUrl ?>" alt="QR code" class="ticket__info-qr">
						<p class="ticket__hint">Покажите QR-код нашему контроллёру у входа в зал.</p>
						<p class="ticket__hint">Приятного просмотра!</p>
					</div>
				</section>
			</main>
		<?php
	}
} else {
	?>
	<main>
		<section class="error">
			<h2>Ошибка</h2>
			<p>Форма не была отправлена. Пожалуйста, попробуйте снова.</p>
		</section>
	</main>
<?php } ?>