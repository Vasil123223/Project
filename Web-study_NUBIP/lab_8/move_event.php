<?php
require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
$stmt = $mysqli->prepare("UPDATE bookings SET start_date = ?, end_date = ?, room_id = ? WHERE id = ?");
$stmt->bind_param("ssii", $data['start'], $data['end'], $data['room_id'], $data['id']);
$stmt->execute();
echo "OK";
?>
