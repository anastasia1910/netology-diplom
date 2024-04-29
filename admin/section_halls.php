<?php
require_once 'halls.php';

$halls = json_decode(getHalls(), true);

?>

<section class="conf-step">
	<header class="conf-step__header conf-step__header_opened">
		<h2 class="conf-step__title">Управление залами</h2>
	</header>
	<div class="conf-step__wrapper">
		<p class="conf-step__paragraph">Доступные залы:</p>
		<ul class="conf-step__list">
			<?php foreach ($halls as $hall) { ?>
				<li><?= $hall['name'] ?>
					<button class="conf-step__button conf-step__button-trash" onclick="deleteHall(<?= $hall['id'] ?>)"></button>
				</li>
			<?php } ?>
		</ul>
		<button class="conf-step__button conf-step__button-accent" onclick="showPopup()">Добавить зал</button>
	</div>
</section>
</main>

<div class="popup">
	<div class="popup__container">
		<div class="popup__content">
			<div class="popup__header">
				<h2 class="popup__title">
					Добавление зала
					<a class="popup__dismiss" onclick="hidePopup()"><img src="i/close.png" alt="Закрыть"></a>
				</h2>

			</div>
			<div class="popup__wrapper">
				<form id="addHallForm" method="post">
					<label class="conf-step__label conf-step__label-fullsize" for="name">
						Название зала
						<input class="conf-step__input" type="text" placeholder="Например, «Зал 1»" name="name" required="">
					</label>
					<div class="conf-step__buttons text-center">
						<input type="submit" value="Добавить зал" class="conf-step__button conf-step__button-accent"
							   data-event="hall_add">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>