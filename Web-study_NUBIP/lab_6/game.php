<?php
session_start();


if (!isset($_SESSION['board'])) {
    $_SESSION['board'] = array_fill(0, 9, '');
    $_SESSION['turn'] = 'X';
    $_SESSION['winner'] = null;
}


if (isset($_GET['cell']) && $_SESSION['winner'] === null) {
    $cell = (int)$_GET['cell'];
    if ($_SESSION['board'][$cell] === '') {
        $_SESSION['board'][$cell] = $_SESSION['turn'];
        checkWinner();
        if ($_SESSION['winner'] === null) {
            $_SESSION['turn'] = $_SESSION['turn'] === 'X' ? 'O' : 'X';
        }
    }
}


if (isset($_GET['reset'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Проверка победителя
function checkWinner() {
    $b = $_SESSION['board'];
    $lines = [
        [0,1,2],[3,4,5],[6,7,8], // Горизонтали
        [0,3,6],[1,4,7],[2,5,8], // Вертикали
        [0,4,8],[2,4,6]          // Диагонали
    ];
    foreach ($lines as $line) {
        [$a, $b1, $c] = $line;
        if ($b[$a] && $b[$a] === $b[$b1] && $b[$a] === $b[$c]) {
            $_SESSION['winner'] = $b[$a];
            return;
        }
    }

    // Ничья
    if (!in_array('', $b)) {
        $_SESSION['winner'] = 'Draw';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Крестики-нолики</title>
    <style>
        body { font-family: sans-serif; text-align: center; margin-top: 50px; }
        table { margin: auto; border-collapse: collapse; }
        td {
            width: 60px; height: 60px; font-size: 32px; 
            border: 2px solid #000; text-align: center;
        }
        a { display: block; text-decoration: none; color: #000; height: 100%; }
    </style>
</head>
<body>
    <h1>Крестики-нолики</h1>
    <p>Ходит: <strong><?= $_SESSION['turn'] ?></strong></p>

    <table>
        <?php for ($row = 0; $row < 3; $row++): ?>
            <tr>
                <?php for ($col = 0; $col < 3; $col++):
                    $i = $row * 3 + $col;
                    ?>
                    <td>
                        <?php if ($_SESSION['board'][$i] === '' && $_SESSION['winner'] === null): ?>
                            <a href="?cell=<?= $i ?>"></a>
                        <?php else: ?>
                            <?= $_SESSION['board'][$i] ?>
                        <?php endif; ?>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>

    <?php if ($_SESSION['winner']): ?>
        <h2>
            <?= $_SESSION['winner'] === 'Draw' ? 'Ничья!' : 'Победил: ' . $_SESSION['winner'] ?>
        </h2>
    <?php endif; ?>

    <p><a href="?reset=1">🔄 Начать заново</a></p>
</body>
</html>
