<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Reservation</title>
    <link type="text/css" rel="stylesheet" href="media/layout.css" />
    <script src="js/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>
</head>
<body>
<?php
require_once '_db.php';

// Получение комнат из базы данных
$rooms = $mysqli->query('SELECT * FROM rooms');

// Получение параметров из URL или установка по умолчанию
$start = $_GET['start'] ?? date('Y-m-d');
$end = $_GET['end'] ?? date('Y-m-d', strtotime('+1 day'));
$selectedRoom = $_GET['resource'] ?? '';
?>
<form id="f" action="backend_create.php" method="post" style="padding:20px;">
    <h1>New Reservation</h1>

    <div>Name:</div>
    <div><input type="text" name="name" required /></div>

    <div>Start:</div>
    <div><input type="date" name="start" value="<?php echo htmlspecialchars(substr($start, 0, 10)); ?>" required /></div>

    <div>End:</div>
    <div><input type="date" name="end" value="<?php echo htmlspecialchars(substr($end, 0, 10)); ?>" required /></div>

    <div>Room:</div>
    <div>
        <select name="room" required>
            <?php while ($room = $rooms->fetch_assoc()): ?>
                <option value="<?= $room['id'] ?>" <?= $selectedRoom == $room['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($room['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="space">
        <input type="submit" value="Save" />
        <a href="javascript:close();">Cancel</a>
    </div>
</form>
</body>
</html>
