<section class="conf-step">
	<header class="conf-step__header conf-step__header_opened">
		<h2 class="conf-step__title">Конфигурация залов</h2>
	</header>
	<div class="conf-step__wrapper">
		<p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
		<ul class="conf-step__selectors-box">
			<?php foreach ($halls as $hall) { ?>
				<li>
					<input type="radio" class="conf-step__radio" name="chairs-hall" value="<?php echo $hall['id']; ?>"
						   onchange="loadSeats(this.value)">
					<span class="conf-step__selector"><?php echo $hall['name']; ?></span>
				</li>
			<?php } ?>
		</ul>
		<p class="conf-step__paragraph">Укажите количество рядов и максимальное количество кресел в ряду:</p>
		<div class="conf-step__legend">
			<label class="conf-step__label">Рядов, шт<input type="text" id="rows-input" class="conf-step__input"
															placeholder="10"></label>
			<span class="multiplier">x</span>
			<label class="conf-step__label">Мест, шт<input type="text" id="seats-input" class="conf-step__input"
														   placeholder="8"></label>
		</div>
		<p class="conf-step__paragraph">Теперь вы можете указать типы кресел на схеме зала:</p>
		<div class="conf-step__legend">
			<span class="conf-step__chair conf-step__chair_standart"></span> — обычные кресла
			<span class="conf-step__chair conf-step__chair_vip"></span> — VIP кресла
			<span class="conf-step__chair conf-step__chair_disabled"></span> — заблокированные (нет кресла)
			<p class="conf-step__hint">Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши</p>
		</div>
		<div id="seat-layout"></div>
		<fieldset class="conf-step__buttons text-center">
			<input type="submit" id="save-button" value="Сохранить" class="conf-step__button conf-step__button-accent">
		</fieldset>
	</div>
</section>