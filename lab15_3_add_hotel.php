<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $country_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
} else {
    $country_id = isset($_GET['id'])  ? (int)$_GET['id'] : 0;
}
if ($country_id <= 0) {
    die('Неверный идентификатор страны.');
}
$stmt = $pdo->prepare(
    'SELECT name FROM lab15_3_countries WHERE id = :id'
);
$stmt->execute([':id' => $country_id]);
$country = $stmt->fetchColumn();
if (!$country) {
    die('Страна не найдена.');
}
$firms = $pdo->query(
    'SELECT id, name FROM lab15_3_firms ORDER BY name'
)->fetchAll(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel'])) {
    header("Location: lab15_3_country_details.php?id={$country_id}");
    exit;
}
$errors = [];
$name  = '';
$cost  = '';
$firm  = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $name = trim($_POST['name']  ?? '');
    $cost = trim($_POST['cost']  ?? '');
    $firm = isset($_POST['firm_id']) ? (int)$_POST['firm_id'] : 0;
    if ($name === '') {
        $errors['name'] = 'Название не может быть пустым.';
    } elseif (mb_strlen($name) > 150) {
        $errors['name'] = 'Название слишком длинное.';
    } else {
        $st = $pdo->prepare(
            'SELECT COUNT(*) FROM lab15_3_hotels 
             WHERE name = :name AND country_id = :cid'
        );
        $st->execute([':name'=>$name,':cid'=>$country_id]);
        if ($st->fetchColumn() > 0) {
            $errors['name'] = 'Отель с таким названием уже существует.';
        }
    }
    if (!is_numeric($cost) || (float)$cost <= 0) {
        $errors['cost'] = 'Стоимость должна быть числом > 0.';
    }
    $firmIds = array_column($firms, 'id');
    if (!in_array($firm, $firmIds, true)) {
        $errors['firm'] = 'Нужно выбрать фирму.';
    }
    if (empty($errors)) {
        $ins = $pdo->prepare(
            'INSERT INTO lab15_3_hotels 
             (name, cost, country_id, firm_id)
             VALUES (:name, :cost, :cid, :fid)'
        );
        $ins->execute([
            ':name' => $name,
            ':cost' => $cost,
            ':cid'  => $country_id,
            ':fid'  => $firm,
        ]);
        $newId = $pdo->lastInsertId();
        header("Location: lab15_3_hotel_details.php?id={$newId}");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ЛР 15-3 Тюнин ТС ИБ-541</title>
</head>
<body>
    <h1>Добавление отеля для страны «<?= htmlspecialchars($country,ENT_QUOTES,'UTF-8') ?>»</h1>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?= $country_id ?>">
        <label>
            Название:<br>
            <input type="text" name="name" value="<?= htmlspecialchars($name,ENT_QUOTES,'UTF-8') ?>">
        </label><br>
        <?php if (!empty($errors['name'])): ?>
            <span style="color:red"><?= htmlspecialchars($errors['name'],ENT_QUOTES,'UTF-8') ?></span><br>
        <?php endif; ?>
        <br>
        <label>
            Стоимость:<br>
            <input type="text" name="cost" value="<?= htmlspecialchars($cost,ENT_QUOTES,'UTF-8') ?>">
        </label><br>
        <?php if (!empty($errors['cost'])): ?>
            <span style="color:red"><?= htmlspecialchars($errors['cost'],ENT_QUOTES,'UTF-8') ?></span><br>
        <?php endif; ?>
        <br>
        <label>
            Фирма:<br>
            <select name="firm_id">
            <option value="">— выберите —</option>
            <?php foreach ($firms as $f): ?>
                <option value="<?= $f['id'] ?>" <?= $firm===$f['id']?'selected':''?>>
                <?= htmlspecialchars($f['name'],ENT_QUOTES,'UTF-8') ?>
                </option>
            <?php endforeach; ?>
            </select>
        </label><br>
        <?php if (!empty($errors['firm'])): ?>
            <span style="color:red"><?= htmlspecialchars($errors['firm'],ENT_QUOTES,'UTF-8') ?></span><br>
        <?php endif; ?>
        <br>
        <button type="submit" name="add">Добавить</button>
        <button type="submit" name="cancel">Отмена</button>
    </form>
</body>
</html>
