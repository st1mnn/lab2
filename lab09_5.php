<?php
require_once 'db.php';

$sql = "
    SELECT
        f.name AS firm_name,
        c.name AS car_name,
        c.cost AS car_cost
    FROM lab9_5_firms f
    JOIN lab9_5_cars c ON c.firm_id = f.id
    ORDER BY
        f.name ASC,
        c.cost DESC
";
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>ЛР 9-5 Тюнин ТС ИБ-541</title>
    <style>
        table { border-collapse: collapse }
        th, td { border: 1px solid }
    </style>
</head>
<body>
    <h1>Список фирм и их автомобилей</h1>
    <table>
        <thead>
            <tr>
                <th>Фирма</th>
                <th>Модель</th>
                <th>Стоимость</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['firm_name'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($r['car_name'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($r['car_cost'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
