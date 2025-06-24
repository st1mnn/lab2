<?php
require_once 'db.php';

$sql = "
    SELECT
        h.name AS hotel_name,
        h.cost AS hotel_cost,
        c.name AS country_name
    FROM lab14_3_hotels h
    JOIN lab14_3_countries c
        ON h.country_id = c.id
    ORDER BY
        c.name ASC,
        h.cost ASC,
        h.name ASC
";
$stmt = $pdo->query($sql);
$hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>ЛР 14-3 Тюнин ТС ИБ-541</title>
</head>
<body>
    <h1>Список отелей</h1>
    <ul>
        <?php foreach ($hotels as $row): ?>
         <li>
            Страна: <?= htmlspecialchars($row['country_name'], ENT_QUOTES, 'UTF-8') ?>.
            Стоимость в евро: <?= htmlspecialchars($row['hotel_cost'],   ENT_QUOTES, 'UTF-8') ?>.
            Название отеля: <?= htmlspecialchars($row['hotel_name'],    ENT_QUOTES, 'UTF-8') ?>.
        </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
