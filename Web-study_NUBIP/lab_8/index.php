<?php require 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Готель – графік бронювань</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script/daypilot-all.min.js"></script> <!-- убедись, что файл доступен -->
</head>
<body>
    <h1>Графік бронювань</h1>
    <div id="dp" style="width: 100%; height: 500px;"></div>

    <script>
    const dp = new DayPilot.Scheduler("dp");

    dp.startDate = "2025-06-01";      // начало периода
    dp.days = 7;                      // количество дней
    dp.scale = "Day";                // масштаб — по дням
    dp.timeHeaders = [
        { groupBy: "Month", format: "MMMM yyyy" },
        { groupBy: "Day", format: "dd ddd" }
    ];
    dp.cellWidth = 60;
    dp.rowHeaderColumns = [{ title: "Номер кімнати", display: "name" }];
    dp.eventHeight = 30;
    dp.headerHeight = 40;

    // Загружаем список комнат
    dp.resources = <?php
        $rooms = $mysqli->query("SELECT id, name FROM rooms");
        $res = [];
        while ($r = $rooms->fetch_assoc()) {
            $res[] = ["id" => $r["id"], "name" => $r["name"]];
        }
        echo json_encode($res);
    ?>;

    // Загружаем список бронирований
    dp.events.list = <?php
        $bookings = $mysqli->query("SELECT * FROM bookings");
        $events = [];
        while ($b = $bookings->fetch_assoc()) {
            $events[] = [
                "id" => $b["id"],
                "resource" => $b["room_id"],
                "start" => $b["start_date"],
                "end" => date('Y-m-d', strtotime($b["end_date"] . ' +1 day')),
                "text" => $b["guest_name"] . " ({$b['start_date']} - {$b['end_date']})",
                "barColor" => match($b["status"]) {
                    "Confirmed" => "green",
                    "New" => "orange",
                    "Checked out" => "gray",
                    "Expired" => "red",
                    default => "blue",
                }
            ];
        }
        echo json_encode($events);
    ?>;

    dp.init();
    </script>
</body>
</html>
