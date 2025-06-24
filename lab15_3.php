<?php
require_once 'db.php';

$sql = "
    SELECT c.id, c.name, COUNT(h.id) AS hotel_count
    FROM lab15_3_countries c
    LEFT JOIN lab15_3_hotels h ON h.country_id = c.id
    GROUP BY c.id, c.name
    ORDER BY c.name
";
$stmt = $pdo->query($sql);
$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>ЛР 15-3 Тюнин ТС ИБ-541</title>
    <style>
        table { border-collapse: collapse }
        th, td { border: 1px solid }
    </style>  
</head>
<body>
    <h1>Страны</h1>
    <form method="post" action="lab15_3_country_delete.php">
        <table>
            <tr>
                <th>Название</th>
                <th>Просмотр</th>
                <th>Удалить</th>
            </tr>
            <?php foreach ($countries as $c): ?>
            <tr>
                <td>
                <?php if ($c['hotel_count'] == 0): ?>
                    <em><?= htmlspecialchars($c['name'], ENT_QUOTES, 'UTF-8') ?></em>
                <?php else: ?>
                    <?= htmlspecialchars($c['name'], ENT_QUOTES, 'UTF-8') ?>
                <?php endif; ?>
                </td>
                <td>
                    <a href="lab15_3_country_details.php?id=<?= $c['id'] ?>">Просмотр</a>
                </td>
                <td>
                <?php if ($c['hotel_count'] == 0): ?>
                    <input type="checkbox" name="id[]" value="<?= $c['id'] ?>">
                <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <button type="submit">Удалить</button>
    </form>
</body>
</html>
