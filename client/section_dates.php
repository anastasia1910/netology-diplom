<?php
require_once 'header.php';
function formatDate($date) {
	return date('D d', strtotime($date));
}

function getNextDate($date) {
	return date('Y-m-d', strtotime($date . ' +1 day'));
}
?>
<nav class="page-nav">
	<?php
	$today = date('Y-m-d');
	$daysOfWeek = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
	?>
	<a class="page-nav__day <?= ($today == date('Y-m-d')) ? 'page-nav__day_chosen' : '' ?>" href="#" data-full-date="<?= $today ?>">
		<span class="page-nav__day-week"><?= $daysOfWeek[date('w')] ?></span>
		<span class="page-nav__day-number"><?= date('d') ?></span>
	</a>
	<?php for ($i = 0; $i < 6; $i++) { ?>
		<?php $date = getNextDate($today); ?>
		<?php $formattedDate = formatDate($date); ?>
			<a class="page-nav__day" href="#" data-full-date="<?= $date ?>">
				<span class="page-nav__day-week"><?= $daysOfWeek[date('w', strtotime($date))] ?></span>
				<span class="page-nav__day-number"><?= substr($formattedDate, 4) ?></span>
			</a>
		<?php $today = $date; ?>
	<?php } ?>
</nav>
<main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navItems = document.querySelectorAll('.page-nav__day');

        navItems.forEach(item => {
            item.addEventListener('click', function() {
                navItems.forEach(navItem => {
                    navItem.classList.remove('page-nav__day_chosen');
                });

                this.classList.add('page-nav__day_chosen');

                const chosenDate = this.getAttribute('data-full-date');
            });
        });
    });
</script>