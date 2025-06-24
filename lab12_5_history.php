<?php
require_once 'db.php';

$stmt = $pdo->prepare(
    'SELECT u.login, v.page_name, v.visited_at
     FROM lab12_5_visits v
     JOIN lab12_5_users u ON v.user_id = u.id
     WHERE v.page_name = :page
     ORDER BY v.visited_at DESC
     LIMIT 10'
);
$stmt->execute([':page' => 'lab12_5_visit.php']);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>ЛР 12-5 Тюнин ТС ИБ-541</title>
    <style>
        table { border-collapse: collapse }
        th, td { border: 1px solid }
    </style>  
</head>
<body>
    <h1>Последние 10 визитов</h1>
    <table>
        <tr>
            <th>Логин</th>
            <th>Страница</th>
            <th>Время визита</th>
        </tr>
        <?php foreach ($rows as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['login'],    ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($r['page_name'],ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($r['visited_at'],ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="lab12_5_visit.php"> Назад на страницу визитов</a></p>
</body>
</html>
