<?php
require_once 'header.php';

require_once 'section_halls.php';

require_once 'section_seats.php';

require_once 'section_prices.php';

require_once 'section_movies.php';

require_once 'section_seances.php';

?>

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('openSaleButton').addEventListener('click', function (event) {
            event.preventDefault();

            const selectedHallId = document.querySelector('input[name="chairs-hall"]:checked').value;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'hall_activity.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                } else {
                    alert('Произошла ошибка при отправке запроса на сервер');
                }
            };
            xhr.send(JSON.stringify({ hall_id: selectedHallId }));
        });
    });



</script>

<?php
require_once 'footer.php';
?>
