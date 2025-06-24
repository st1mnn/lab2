<?php
require_once 'db.php';

$stmt = $pdo->query(
    'SELECT id, name FROM lab10_5_firms ORDER BY name'
);
$firms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>ЛР 10-5 Тюнин ТС ИБ-541</title>
    <style>
        table { border-collapse: collapse }
        th, td { border: 1px solid }
    </style>    
</head>
<body>
    <h1>Фирмы</h1>
    <table>
        <thead>        
            <tr>
                <th>Название фирмы</th>
                <th>Детали</th>
            </tr>
        </thead>
        <tbody>            
            <?php foreach ($firms as $f): ?>
            <tr>
                <td><?= htmlspecialchars($f['name']) ?></td>
                <td><a href="lab10_5_details.php?firm_id=<?= $f['id'] ?>">
                        Подробнее</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>            
    </table>
</body>
</html>
