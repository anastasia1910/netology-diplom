<section class="conf-step">
	<header class="conf-step__header conf-step__header_opened">
		<h2 class="conf-step__title">Открыть продажи</h2>
	</header>
	<div class="conf-step__wrapper text-center">
		<p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
		<ul class="conf-step__selectors-box">
		<?php foreach ($halls as $hall) { ?>
					<li>
						<input type="radio" class="conf-step__radio" name="chairs-hall" value="<?php echo $hall['id']; ?>">
						<span class="conf-step__selector"><?php echo $hall['name']; ?></span>
					</li>
		<?php } ?>
		</ul>
		<button class="conf-step__button conf-step__button-accent" id="openSaleButton">Открыть продажу билетов</button>
	</div>
</section>