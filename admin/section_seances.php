<main class="conf-steps">
	<section class="conf-step">
		<div class="conf-step__wrapper">

			<div class="conf-step__seances">
				<p class="conf-step__paragraph">
					<button class="conf-step__button conf-step__button-accent" onclick="showPopup('#seance')">Добавить сеанс
					</button>
				</p>
		  <?php foreach ($halls as $hall) { ?>
						<div class="conf-step__seances-hall" data-hall-id="<?php echo $hall['id']; ?>">
							<h3 class="conf-step__seances-title">Зал <?php echo $hall['name']; ?></h3>
							<div class="conf-step__seances-timeline">

							</div>
						</div>
		  <?php } ?>
			</div>
		</div>

	</section>
</main>
<div class="popup" id="seance">
	<div class="popup__container">
		<div class="popup__content">
			<div class="popup__header">
				<h2 class="popup__title">
					Добавление сеанса
					<a class="popup__dismiss" onclick="hidePopup('#seance')"><img src="i/close.png" alt="Закрыть"></a>
				</h2>
			</div>
			<div class="popup__wrapper">
				<form id="addSeanceForm" method="post">
					<div class="popup__form">
						<label class="conf-step__label conf-step__label-fullsize" for="hall_name">
							Зал
							<select class="conf-step__input" name="hall_id" required="">
								<option value="">Выберите зал</option>
				  <?php foreach ($halls as $hall) { ?>
										<option value="<?php echo $hall['id']; ?>"><?php echo $hall['name']; ?></option>
				  <?php } ?>
							</select>
						</label>
						<label class="conf-step__label conf-step__label-fullsize" for="movie_name">
							Фильм
							<select class="conf-step__input" name="movie_id" required="">
								<option value="">Выберите фильм</option>
				  <?php foreach ($movies as $movie) { ?>
										<option value="<?php echo $movie['id']; ?>"><?php echo $movie['name']; ?></option>
				  <?php } ?>
							</select>

						</label>
						<label class="conf-step__label conf-step__label-fullsize" for="start_time">
							Время начала
							<input class="conf-step__input" type="text" placeholder="Время начала сеанса" name="start_time"
										 required="">
						</label>
					</div>
					<div class="conf-step__buttons text-center">
						<input type="submit" value="Добавить сеанс" class="conf-step__button conf-step__button-accent"
									 data-event="seance_add">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
