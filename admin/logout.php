<?php
session_start();

session_unset();

// Уничтожение сеанса
session_destroy();

header("Location: ../client/index.php");
exit();
?>