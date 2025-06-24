<?php
require_once 'db.php';

if (empty($_POST['id']) || !is_array($_POST['id'])) {
    die('Ничего не выбрано для удаления. <a href="lab15_3.php">Назад</a>');
}
$ids = array_map('intval', $_POST['id']);
foreach ($ids as $id) {
    $stmt = $pdo->prepare(
        'SELECT COUNT(*) FROM lab15_3_hotels WHERE country_id = :id'
    );
    $stmt->execute([':id' => $id]);
    if ($stmt->fetchColumn() > 0) {
        die("Ошибка: у страны с ID={$id} есть отели. Удаление остановлено.");
    }
    $stmt2 = $pdo->prepare(
        'SELECT name FROM lab15_3_countries WHERE id = :id'
    );
    $stmt2->execute([':id' => $id]);
    $name = $stmt2->fetchColumn();
    if (!$name) {
        die("Ошибка: страна с ID={$id} не найдена.");
    }
    $del = $pdo->prepare(
        'DELETE FROM lab15_3_countries WHERE id = :id'
    );
    $del->execute([':id' => $id]);
    echo "<p>Страна «".htmlspecialchars($name,ENT_QUOTES,'UTF-8')."» успешно удалена.</p>";
}
echo '<p><a href="lab15_3.php">Назад</a></p>';
