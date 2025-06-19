<?php
require_once '_db.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (
    isset($_POST['name']) &&
    isset($_POST['start']) &&
    isset($_POST['end']) &&
    isset($_POST['room'])
) {
    try {
        $stmt = $mysqli->prepare("
            INSERT INTO bookings (guest_name, start_date, end_date, room_id, status)
            VALUES (?, ?, ?, ?, 'New')
        ");

        $stmt->bind_param(
            "sssi",
            $_POST['name'],
            $_POST['start'],
            $_POST['end'],
            $_POST['room']
        );

        $stmt->execute();
        echo "OK";
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        http_response_code(500);
        echo "Ошибка MySQL: " . $e->getMessage();
    }
} else {
    http_response_code(400);
    echo "Недостаточно данных";
}
