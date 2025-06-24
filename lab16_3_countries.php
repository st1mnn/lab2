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

$stmt = $pdo->query(
  'SELECT id, name FROM lab15_3_countries ORDER BY name'
);
$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <h1>Страны</h1>
    <ul>
    <?php foreach ($countries as $c): ?>
        <li>
            <a href="lab16_3_country_details.php?country_id=<?= $c['id'] ?>">
            <?= htmlspecialchars($c['name'], ENT_QUOTES, 'UTF-8') ?>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>
    <p><a href="lab16_3.php">Назад</a></p>
</body>
</html>
