<?php
$host = 'localhost';
$db   = 'hotel';
$user = 'root';
$pass = '';

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die('Ошибка подключения: ' . $mysqli->connect_error);
}
?>
