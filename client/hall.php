<?php
require_once 'header.php';
session_start();
if (isset($_GET['seance_id'])) {
	$seanceId = $_GET['seance_id'];

	$querySeance = "SELECT seances.start_time, halls.id AS hall_id, halls.name AS hall_name, movies.name AS movie_name, movies.duration, movies.country, movies.description FROM seances 
                    JOIN halls ON seances.hall_id = halls.id 
                    JOIN movies ON seances.movie_id = movies.id 
                    WHERE seances.id = ?";
	$stmtSeance = $db->prepare($querySeance);
	$stmtSeance->bind_param("i", $seanceId);
	$stmtSeance->execute();
	$resultSeance = $stmtSeance->get_result();

	if ($resultSeance->num_rows == 1) {
		$seance = $resultSeance->fetch_assoc();
		?>
			<main>
				<section class="buying">
					<div class="buying__info">
						<div class="buying__info-description">
							<h2 class="buying__info-title"><?php echo $seance['movie_name']; ?></h2>
							<p class="buying__info-start">Начало сеанса: <?php echo $_GET['date'] . ' ' . $seance['start_time']; ?></p>
							<p class="buying__info-hall">Зал: <?php echo $seance['hall_name']; ?></p>
						</div>
					</div>
					<div class="buying-scheme">
						<div class="buying-scheme__wrapper" id="seat-layout-wrapper">

						</div>
					</div>
					<button class="acceptin-button" id="bookButton" data-seance-id="<?php echo $seanceId; ?>">Забронировать</button>
				</section>
			</main>
			<script>
          var seanceId = <?php echo $seanceId; ?>;
          var hallId = <?php echo $seance['hall_id']; ?>;

          document.addEventListener('DOMContentLoaded', function () {
              loadSeats(seanceId, hallId);
          });

          function loadSeats(seanceId, hallId, standardPrice, vipPrice) {
              const xhr = new XMLHttpRequest();
              xhr.open('GET', `load_seats.php?seance_id=${seanceId}&hall_id=${hallId}`, true);
              xhr.onload = function () {
                  if (xhr.status === 200) {
                      const seatLayoutWrapper = document.getElementById('seat-layout-wrapper');
                      seatLayoutWrapper.innerHTML = xhr.responseText;
                      addSeatClickListeners();
                  } else {
                      console.error('Ошибка загрузки мест:', xhr.statusText);
                  }
              };
              xhr.onerror = function () {
                  console.error('Ошибка запроса');
              };
              xhr.send();
          }

          function addSeatClickListeners() {
              const seatWrapper = document.querySelector('.buying-scheme__wrapper');
              if (seatWrapper) {
                  const seatsElements = document.querySelectorAll('.buying-scheme__wrapper .buying-scheme .buying-scheme__chair');

                  seatsElements.forEach((seatElement) => {
                      seatElement.addEventListener('click', (e) => {
                          seatElement.classList.toggle('buying-scheme__chair_selected');
                      });
                  });

                  const bookButton = document.getElementById('bookButton');
                  bookButton.addEventListener('click', (e) => {
                      const selectedSeats = [];
                      seatsElements.forEach((seatElement) => {
                          if (seatElement.classList.contains('buying-scheme__chair_selected')) {
                              selectedSeats.push(seatElement.dataset.seatId);
                          }
                      });

                      if (selectedSeats.length > 0) {
                          const xhr = new XMLHttpRequest();
                          xhr.open('POST', 'payment.php', true);
                          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                          xhr.send(`seance_id=${seanceId}&seat_ids=${selectedSeats.join(',')}&date=${"<?php echo $_GET['date']; ?>"}&start_time=${"<?php echo $seance['start_time']; ?>"}`);

                          xhr.onload = function () {
                              if (xhr.status === 200) {
                                  window.location.href = 'payment.php?seance_id=' + seanceId + '&seat_ids=' + selectedSeats.join(',') + '&date=<?php echo $_GET['date']; ?>&start_time=<?php echo $seance['start_time']; ?>';
                              } else {
                                  console.error('Ошибка бронирования:', xhr.statusText);
                              }
                          };
                      } else {
                          alert('Выберите хотя бы одно место');
                      }
                  });
              }
          }
			</script>
		<?php
	} else {
		echo "Сеанс не найден.";
	}

	$stmtSeance->close();
} else {
	echo "Идентификатор сеанса не указан.";
}
?>