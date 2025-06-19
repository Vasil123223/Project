<?php
require_once '_db.php';

$stmt = $db->prepare("SELECT * FROM bookings WHERE NOT ((end_date <= :start) OR (start_date >= :end))");
$stmt->bindParam(':start', $_POST['start']);
$stmt->bindParam(':end', $_POST['end']);
$stmt->execute();
$rows = $stmt->fetchAll();

class Event {}
$events = [];

foreach ($rows as $row) {
    $e = new Event();
    $e->id = $row['id'];
    $e->text = $row['guest_name'];
    $e->start = $row['start_date'];
    $e->end = $row['end_date'];
    $e->resource = $row['room_id'];
    $e->bubbleHtml = "Reservation details: {$e->text}";
    $e->status = $row['status'];
    $e->paid = $row['paid'];
    $events[] = $e;
}

header('Content-Type: application/json');
echo json_encode($events);
?>