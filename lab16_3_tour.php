<?php
session_start();
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: lab16_3_login.php');
    exit;
}
if (empty($_SESSION['user_id'])) {
    header('Location: lab16_3_login.php');
    exit;
}
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear'])) {
    unset($_SESSION['tour']);
    header('Location: lab16_3_tour.php');
    exit;
}
$tour = $_SESSION['tour'] ?? [];
$items = [];
if ($tour) {
    $placeholders = [];
    $params = [];
    foreach ($tour as $cid => $hlist) {
        foreach ($hlist as $hid) {
            $placeholders[] = '(?,?)';
            $params[] = $cid;
            $params[] = $hid;
        }
    }
    $sql = "
        SELECT c.name AS country, h.name AS hotel
        FROM lab15_3_countries c
        JOIN lab15_3_hotels    h
            ON c.id = h.country_id
        WHERE (c.id,h.id) IN (" . implode(',', $placeholders) . ")
        ORDER BY c.name, h.name
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Мой тур</title>
    <style>
        table { border-collapse: collapse }
        th, td { border: 1px solid }
    </style>
</head>
<body>
    <div style="text-align:right">
        Вы вошли как <?= htmlspecialchars("$_SESSION[lastname] $_SESSION[firstname]", ENT_QUOTES, 'UTF-8') ?>
        / <a href="?logout=1">Выйти</a>
    </div>
    <h1>Мой тур</h1>
    <?php if ($items): ?>
        <table>
            <tr><th>Страна</th><th>Отель</th></tr>
            <?php foreach ($items as $it): ?>
                <tr>
                    <td><?= htmlspecialchars($it['country'],ENT_QUOTES,'UTF-8') ?></td>
                    <td><?= htmlspecialchars($it['hotel'], ENT_QUOTES,'UTF-8') ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Тур пуст.</p>
    <?php endif; ?>
    <p>
        <a href="lab16_3.php">На главную</a>&nbsp;
        <form method="post" action="" style="display:inline">
            <button type="submit" name="clear">Очистить тур</button>
        </form>
    </p>
</body>
</html>
