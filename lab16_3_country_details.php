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

$cid = filter_input(INPUT_GET, 'country_id', FILTER_VALIDATE_INT);
if (!$cid) {
    die('Неверный ID страны.');
}
if ($hid = filter_input(INPUT_GET,'add_hotel',FILTER_VALIDATE_INT)) {
    $_SESSION['tour'][$cid] = $_SESSION['tour'][$cid] ?? [];
    if (!in_array($hid, $_SESSION['tour'][$cid], true)) {
        $_SESSION['tour'][$cid][] = $hid;
    }
}
$stmt = $pdo->prepare('SELECT name FROM lab15_3_countries WHERE id = :id');
$stmt->execute([':id'=>$cid]);
$country = $stmt->fetchColumn() ?: die('Страна не найдена.');
$stmt = $pdo->prepare(
    'SELECT h.id, h.name 
    FROM lab15_3_hotels h
    WHERE h.country_id = :cid
    ORDER BY h.name'
);
$stmt->execute([':cid'=>$cid]);
$hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
$inTour = $_SESSION['tour'][$cid] ?? [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>ЛР 16-3 Тюнин ТС ИБ-541</title>
</head>
<body>
    <div style="text-align:right">
        Вы вошли как <?= htmlspecialchars("$_SESSION[lastname] $_SESSION[firstname]", ENT_QUOTES, 'UTF-8') ?>
        / <a href="?logout=1">Выйти</a>
    </div>
    <h1>Страна «<?= htmlspecialchars($country,ENT_QUOTES,'UTF-8') ?>»</h1>
    <?php if ($hotels): ?>
        <ul>
        <?php foreach ($hotels as $h): ?>
            <li>
                <?= htmlspecialchars($h['name'],ENT_QUOTES,'UTF-8') ?>
                <?php if (!in_array($h['id'], $inTour, true)): ?>
                    — <a href="?country_id=<?= $cid ?>&add_hotel=<?= $h['id'] ?>">Добавить в тур</a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Нет отелей.</p>
    <?php endif; ?>
    <p>
        <a href="lab16_3_countries.php">Назад к списку стран</a>
    </p>
</body>
</html>
