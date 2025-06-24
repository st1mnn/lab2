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
    <h1>Главная</h1>
    <ul>
        <li><a href="lab16_3_countries.php">Список стран</a></li>
        <li><a href="lab16_3_tour.php">Мой тур</a></li>
    </ul>
</body>
</html>
