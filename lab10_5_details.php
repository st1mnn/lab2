<?php
require_once 'db.php';

$firm_id = isset($_GET['firm_id']) ? (int)$_GET['firm_id'] : 0;
if ($firm_id <= 0) {
    die('Неверный идентификатор фирмы.');
}
$stmtFirm = $pdo->prepare(
    'SELECT name FROM lab10_5_firms WHERE id = :id'
);
$stmtFirm->execute([':id' => $firm_id]);
$firm = $stmtFirm->fetch(PDO::FETCH_ASSOC);
$sqlCars = "
    SELECT
        c.name AS car_name,
        co.name AS country_name
    FROM lab10_5_cars c
    JOIN lab10_5_countries co
        ON c.country_id = co.id
    WHERE c.firm_id = :id
    ORDER BY
        co.name ASC,
        c.name ASC
";
$stmtCars = $pdo->prepare($sqlCars);
$stmtCars->execute([':id' => $firm_id]);
$cars = $stmtCars->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>ЛР 10-5 Тюнин ТС ИБ-541</title>
</head>
<body>
    <h1><?= htmlspecialchars($firm['name']) ?></h1>
    <?php if (count($cars) > 0): ?>
        <ul>
        <?php foreach ($cars as $car): ?>
            <li>
                <?= htmlspecialchars($car['car_name']) ?>
                (<?= htmlspecialchars($car['country_name']) ?>)
            </li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>У этой фирмы нет зарегистрированных автомобилей.</p>
    <?php endif; ?>
    <p><a href="lab10_5.php">Назад к списку фирм</a></p>
</body>
</html>
