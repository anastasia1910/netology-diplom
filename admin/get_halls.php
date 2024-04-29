<?php
require_once 'halls.php';

$halls = json_decode(getHalls(), true);
echo json_encode($halls);
?>