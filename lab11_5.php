<?php
require_once 'db.php';

$stmt = $pdo->query('SELECT id, name FROM lab11_5_firms ORDER BY name');
$firms = $stmt->fetchAll(PDO::FETCH_ASSOC);
$name    = '';
$cost    = '';
$power   = '';
$firm_id = null;
$errors  = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $cost = trim($_POST['cost'] ?? '');
    $power = trim($_POST['power'] ?? '');
    $firm_id = isset($_POST['firm_id']) ? (int)$_POST['firm_id'] : null;
    if ($name === '') {
        $errors[] = 'Название автомобиля не может быть пустым.';
    }
    if (!is_numeric($cost) || (float)$cost <= 0) {
        $errors[] = 'Стоимость должна быть положительным числом.';
    }
    if (!ctype_digit($power) || (int)$power <= 0) {
        $errors[] = 'Мощность должна быть положительным целым.';
    }
    $firmIds = array_column($firms, 'id');
    if (!in_array($firm_id, $firmIds, true)) {
        $errors[] = 'Нужно выбрать корректную фирму.';
    }
    if (empty($errors)) {
        $stmt = $pdo->prepare(
            'INSERT INTO lab11_5_cars (firm_id, name, cost, power)
             VALUES (:firm, :name, :cost, :power)'
        );
        $stmt->execute([
            ':firm'  => $firm_id,
            ':name'  => $name,
            ':cost'  => $cost,
            ':power' => $power
        ]);
        $autoid = $pdo->lastInsertId();
        header("Location: lab11_5_details.php?autoid={$autoid}");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>ЛР 11-5 Тюнин ТС ИБ-541</title>
</head>
<body>
    <h1>Новый автомобиль</h1>
    <?php if ($errors): ?>
        <ul style="color:red">
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="post" action="">
        <label>
            Название:<br>
            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
        </label><br><br>
        <label>
            Стоимость:<br>
            <input type="text" name="cost" value="<?= htmlspecialchars($cost) ?>">
        </label><br><br>
        <label>
            Мощность:<br>
            <input type="text" name="power" value="<?= htmlspecialchars($power) ?>">
        </label><br><br>
        <fieldset>
            <legend>Фирма:</legend>
            <?php foreach ($firms as $f): ?>
                <label>
                    <input type="radio" name="firm_id" value="<?= $f['id'] ?>"
                    <?= $firm_id === (int)$f['id'] ? 'checked' : '' ?>>
                    <?= htmlspecialchars($f['name']) ?>
                </label><br>
            <?php endforeach; ?>
        </fieldset><br>
        <button type="submit">Отправить</button>
    </form>
</body>
</html>
