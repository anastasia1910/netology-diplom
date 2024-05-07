<?php
include 'header.php';

require_once 'db_connect.php';

if (isset($_SESSION['user_id'])) {
	header("Location: admin.php");
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email = $_POST['email'];
	$password = $_POST['password'];

	$sql = "SELECT * FROM users WHERE email = ?";
	$stmt = mysqli_prepare($db, $sql);
	mysqli_stmt_bind_param($stmt, "s", $email);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if ($result && mysqli_num_rows($result) > 0) {
		$user = mysqli_fetch_assoc($result);

		if (password_verify($password, $user['password'])) {
			$_SESSION['user_id'] = $user['id'];

			header("Location: admin.php");
			exit();
		} else {
			$error = "Неверный email или пароль.";
		}
	} else {
		$error = "Пользователь с указанным email не найден.";
	}
}
?>

<main>
	<section class="login">
		<header class="login__header">
			<h2 class="login__title">Авторизация</h2>
		</header>
		<div class="login__wrapper">
			<form class="login__form" action="login.php" method="POST" accept-charset="utf-8">
				<label class="login__label" for="email">
					E-mail
					<input class="login__input" type="email" placeholder="example@domain.xyz" name="email" required>
				</label>
				<label class="login__label" for="pwd">
					Пароль
					<input class="login__input" type="password" placeholder="" name="password" required>
				</label>
				<div class="text-center">
					<input value="Авторизоваться" type="submit" class="login__button">
				</div>
			</form>
		</div>
	</section>
</main>