<?php
$dsn = 'pgsql:host=localhost;port=5432;dbname=lab';
$db_user = 'postgres';
$db_pass = 'strong_password';
try {
    $pdo = new PDO($dsn, $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Ошибка подключения к базе: ' . $e->getMessage());
}
