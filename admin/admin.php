<?php
require_once 'header.php';

require_once 'section_halls.php';

require_once 'section_seats.php';

require_once 'section_prices.php';
?>

	<section class="conf-step">
		<header class="conf-step__header conf-step__header_opened">
			<h2 class="conf-step__title">Сетка сеансов</h2>
		</header>
		<div class="conf-step__wrapper">
			<p class="conf-step__paragraph">
				<button class="conf-step__button conf-step__button-accent" onclick="showPopupFilm('#film')">Добавить фильм
				</button>
			</p>
			<div class="conf-step__movies">

				<div class="conf-step__movie">
					<img class="conf-step__movie-poster" alt="poster" src="i/poster.png">
					<h3 class="conf-step__movie-title">Миссия выполнима</h3>
					<p class="conf-step__movie-duration">120 минут</p>
				</div>

				<div class="conf-step__movie">
					<img class="conf-step__movie-poster" alt="poster" src="i/poster.png">
					<h3 class="conf-step__movie-title">Серая пантера</h3>
					<p class="conf-step__movie-duration">90 минут</p>
				</div>
			</div>

			<div class="conf-step__seances">
				<div class="conf-step__seances-hall">
					<h3 class="conf-step__seances-title">Зал 1</h3>
					<div class="conf-step__seances-timeline">
						<div class="conf-step__seances-movie" style="width: 60px; background-color: rgb(133, 255, 137); left: 0;">
							<p class="conf-step__seances-movie-title">Миссия выполнима</p>
							<p class="conf-step__seances-movie-start">00:00</p>
						</div>

					</div>
				</div>
				<div class="conf-step__seances-hall">
					<h3 class="conf-step__seances-title">Зал 2</h3>
					<div class="conf-step__seances-timeline">
						<div class="conf-step__seances-movie"
								 style="width: 65px; background-color: rgb(202, 255, 133); left: 595px;">
							<p class="conf-step__seances-movie-title">Звёздные войны XXIII: Атака клонированных клонов</p>
							<p class="conf-step__seances-movie-start">19:50</p>
						</div>
					</div>
				</div>
			</div>

			<fieldset class="conf-step__buttons text-center">
				<button class="conf-step__button conf-step__button-regular">Отмена</button>
				<input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
			</fieldset>
		</div>
	</section>
	<div class="popup" id="film">
		<div class="popup__container">
			<div class="popup__content">
				<div class="popup__header">
					<h2 class="popup__title">
						Добавление фильма
						<a class="popup__dismiss" onclick="hidePopupFilm('#film')"><img src="i/close.png" alt="Закрыть"></a>
					</h2>

				</div>
				<div class="popup__wrapper">
					<form method="post" accept-charset="utf-8">
						<div class="popup__container">
							<div class="popup__poster"></div>
							<div class="popup__form">
								<label class="conf-step__label conf-step__label-fullsize" for="name">
									Название фильма
									<input class="conf-step__input" type="text" placeholder="Например, «Гражданин Кейн»" name="name"
												 required="">
								</label>
								<label class="conf-step__label conf-step__label-fullsize" for="duration">
									Продолжительность фильма (мин.)
									<input class="conf-step__input" type="text" name="duration" data-last-value="" required="">
								</label>
								<label class="conf-step__label conf-step__label-fullsize" for="description">
									Описание фильма
									<textarea class="conf-step__input" type="text" name="description" required=""></textarea>
								</label>
								<label class="conf-step__label conf-step__label-fullsize" for="country">
									Страна
									<input class="conf-step__input" type="text" name="country" data-last-value="" required="">
								</label>
								<label class="conf-step__label conf-step__label-fullsize" for="hall">
									Зал
									<select class="conf-step__input" name="hall" required="">
					  <?php foreach ($halls as $hall) { ?>
												<option value="<?= $hall['id'] ?>"><?= $hall['name'] ?></option>
					  <?php } ?>
									</select>
								</label>
							</div>
						</div>
						<div class="conf-step__buttons text-center">
							<input type="submit" value="Добавить фильм" class="conf-step__button conf-step__button-accent"
										 data-event="film_add">
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
	<script>
      document.addEventListener('DOMContentLoaded', function () {
          const addMovieButton = document.querySelector('.conf-step__button.accent[data-event="film_add"]');
          addMovieButton.addEventListener('click', function (event) {
              event.preventDefault();
              const form = document.querySelector('.popup form');
              const formData = new FormData(form);
              fetch('add_movie.php', {
                  method: 'POST',
                  body: formData
              })
                  .then(response => response.json())
                  .then(data => {
                      const hall = document.querySelector('.conf-step__seances-hall.active');
                      const moviesContainer = hall.querySelector('.conf-step__seances-timeline');
                      const movieElement = document.createElement('div');
                      movieElement.classList.add('conf-step__seances-movie');
                      movieElement.style.width = '120px';
                      movieElement.style.backgroundColor = 'rgb(255, 255, 255)';
                      movieElement.style.left = '0';
                      movieElement.innerHTML = `
            <p class="conf-step__seances-movie-title">${data.name}</p>
            <p class="conf-step__seances-movie-start">00:00</p>
        `;
                      moviesContainer.appendChild(movieElement);
                      hidePopupFilm('#film');
                  })
                  .catch(error => {
                      console.error('Error:', error);

                  });
          });
      });
	</script>

<?php
require_once 'footer.php';
?>