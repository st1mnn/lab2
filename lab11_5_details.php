<?php
require_once 'db.php';

$autoid = isset($_GET['autoid']) ? (int)$_GET['autoid'] : 0;
if ($autoid <= 0) {
    die('Неверный идентификатор автомобиля.');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM lab11_5_cars WHERE id = :id');
    $stmt->execute([':id' => $autoid]);
    header('Location: lab11_5.php');
    exit;
}
$stmt = $pdo->prepare(
    'SELECT
        c.id,
        c.name AS car_name,
        c.cost,
        c.power,
        f.name AS firm_name
     FROM lab11_5_cars c
     JOIN lab11_5_firms f ON c.firm_id = f.id
     WHERE c.id = :id'
);
$stmt->execute([':id' => $autoid]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$car) {
    die('Автомобиль не найден.');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ЛР 11-5 Тюнин ТС ИБ-541</title>
    <style>
        table { border-collapse: collapse }
        th, td { border: 1px solid }
    </style>
</head>
<body>
    <h1>Автомобиль «<?= htmlspecialchars($car['car_name']) ?>»</h1>
    <table>
        <tr><th>ID</th> <td><?= $car['id'] ?></td></tr>
        <tr><th>Название</th> <td><?= htmlspecialchars($car['car_name']) ?></td></tr>
        <tr><th>Фирма</th> <td><?= htmlspecialchars($car['firm_name']) ?></td></tr>
        <tr><th>Стоимость</th> <td><?= $car['cost'] ?></td></tr>
        <tr><th>Мощность</th> <td><?= $car['power'] ?></td></tr>
    </table>
    <form method="post" action="" style="margin-top:1em">
        <button type="submit" name="delete">Удалить</button>
    </form>
    <p><a href="lab11_5.php">← Добавить другой автомобиль</a></p>
</body>
</html>
