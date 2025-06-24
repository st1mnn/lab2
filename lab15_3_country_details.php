<?php
require_once 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die('Неверный идентификатор страны.');
}
$stmt = $pdo->prepare(
    'SELECT name FROM lab15_3_countries WHERE id = :id'
);
$stmt->execute([':id' => $id]);
$country = $stmt->fetchColumn();
if (!$country) {
    die('Страна не найдена.');
}
$stmt2 = $pdo->prepare(
    'SELECT id, name FROM lab15_3_hotels 
     WHERE country_id = :id 
     ORDER BY name'
);
$stmt2->execute([':id' => $id]);
$hotels = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>ЛР 15-3 Тюнин ТС ИБ-541</title>
</head>
<body>
    <h1>Страна «<?= htmlspecialchars($country,ENT_QUOTES,'UTF-8') ?>»</h1>
    <?php if (count($hotels)): ?>
        <ul>
        <?php foreach ($hotels as $h): ?>
            <li>
                <a href="lab15_3_hotel_details.php?id=<?= $h['id'] ?>">
                <?= htmlspecialchars($h['name'],ENT_QUOTES,'UTF-8') ?>
                </a>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>У этой страны нет отелей.</p>
    <?php endif; ?>
    <p>
        <button type="button"
          onclick="location.href='lab15_3_add_hotel.php?id=<?= $id ?>'">
            Добавить новый отель
        </button>
        <a href="lab15_3.php">Назад</a>
    </p>
</body>
</html>
