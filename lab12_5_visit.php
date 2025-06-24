<?php
session_start();
require_once 'db.php';

if (empty($_SESSION['user_id'])) {
    header('Location: lab12_5.php');
    exit;
}
$userId   = $_SESSION['user_id'];
$pageName = basename(__FILE__);
$stmt = $pdo->prepare(
    'INSERT INTO lab12_5_visits (user_id, page_name) 
     VALUES (:uid, :page)'
);
$stmt->execute([':uid' => $userId, ':page' => $pageName]);
$stmt = $pdo->prepare(
    'SELECT COUNT(*) AS cnt 
     FROM lab12_5_visits 
     WHERE user_id = :uid AND page_name = :page'
);
$stmt->execute([':uid' => $userId, ':page' => $pageName]);
$count = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html>
<head>
    <title>ЛР 12-5 Тюнин ТС ИБ-541</title>
</head>
<body>
    <h1>Страница визитов</h1>
    <p>
        Пользователь 
        <strong><?= htmlspecialchars($_SESSION['login'], ENT_QUOTES, 'UTF-8') ?></strong>
        посетил эту страницу <strong><?= $count ?></strong> раз.
    </p>
    <p><a href="lab12_5_history.php">Посмотреть общую статистику</a></p>
    <p><a href="lab12_5.php">К авторизации</a></p>
</body>
</html>
