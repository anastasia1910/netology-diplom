<section class="conf-step">
	<header class="conf-step__header conf-step__header_opened">
		<h2 class="conf-step__title">Сетка сеансов</h2>
	</header>
	<div class="conf-step__wrapper">
		<p class="conf-step__paragraph">
			<button class="conf-step__button conf-step__button-accent" onclick="showPopup('#film')">Добавить фильм
			</button>
		</p>
		<div class="conf-step__movies">

		</div>
</section>
</main>

<div class="popup" id="film">
	<div class="popup__container">
		<div class="popup__content">
			<div class="popup__header">
				<h2 class="popup__title">
					Добавление фильма
					<a class="popup__dismiss" onclick="hidePopup('#film')"><img src="img/close.png" alt="Закрыть"></a>
				</h2>

			</div>
			<div class="popup__wrapper">
				<form id="addMovieForm" method="post">
					<div class="popup__container">
						<div class="popup__poster"></div>
						<div class="popup__form">
							<label class="conf-step__label conf-step__label-fullsize" for="poster">
								Постер фильма
								<input type="file" name="poster" id="poster" accept=".png,.jpg" required="">
							</label>
							<label class="conf-step__label conf-step__label-fullsize" for="name">
								Название фильма
								<input class="conf-step__input" type="text" placeholder="Например, «Гражданин Кейн»" name="name"
									   required="">
							</label>
							<label class="conf-step__label conf-step__label-fullsize" for="duration">
								Продолжительность фильма (мин.)
								<input class="conf-step__input" type="number" name="duration" id="duration" min="1" max="1000" required="">
							</label>
							<label class="conf-step__label conf-step__label-fullsize" for="description">
								Описание фильма
								<textarea class="conf-step__input" type="text" name="description" required=""></textarea>
							</label>
							<label class="conf-step__label conf-step__label-fullsize" for="country">
								Страна
								<input class="conf-step__input" type="text" name="country" id="country" pattern="[A-Za-zА-Яа-яЁё\s]+" required="">
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
