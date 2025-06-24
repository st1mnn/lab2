<?php
require_once 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die('Неверный идентификатор отеля.');
}
$stmt = $pdo->prepare(
    'SELECT 
        h.name AS hotel_name,
        c.id AS country_id,
        c.name AS country_name,
        f.name AS firm_name,
        h.cost AS hotel_cost
     FROM lab15_3_hotels h
     JOIN lab15_3_countries c ON h.country_id = c.id
     JOIN lab15_3_firms f ON h.firm_id = f.id
     WHERE h.id = :id'
);
$stmt->execute([':id' => $id]);
$hotel = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$hotel) {
    die('Отель не найден.');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ЛР 15-3 Тюнин ТС ИБ-541</title>
</head>
<body>
    <h1><?= htmlspecialchars($hotel['hotel_name'],ENT_QUOTES,'UTF-8') ?></h1>
    <p>Страна: <?= htmlspecialchars($hotel['country_name'],ENT_QUOTES,'UTF-8') ?></p>
    <p>Фирма: <?= htmlspecialchars($hotel['firm_name'],ENT_QUOTES,'UTF-8') ?></p>
    <p>Стоимость за день: <?= htmlspecialchars($hotel['hotel_cost'],ENT_QUOTES,'UTF-8') ?></p>
    <p>
        <a href="lab15_3_country_details.php?id=<?= $hotel['country_id'] ?>">
        Назад к стране </a>
    </p>
</body>
</html>
