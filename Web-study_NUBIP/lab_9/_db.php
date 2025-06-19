<?php
$host = 'localhost';
$db   = 'hotel';    // убедитесь, что база с таким именем есть в phpMyAdmin
$user = 'root';     // стандартное имя пользователя
$pass = '';         // пустой пароль по умолчанию

$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_error) {
    die('Ошибка подключения: ' . $mysqli->connect_error);
}
?>
