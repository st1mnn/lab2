<?php
session_start();
require_once 'db.php';

$login = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $pass  = $_POST['password'] ?? '';
    if ($login === '' || $pass === '') {
        $error = 'Оба поля обязательны.';
    } else {
        $stmt = $pdo->prepare(
            'SELECT id, login FROM lab12_5_users 
             WHERE login = :login AND password = md5(:pass)'
        );
        $stmt->execute([':login' => $login, ':pass' => $pass]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['login']   = $user['login'];
            header('Location: lab12_5_visit.php');
            exit;
        }
        $error = 'Неверный логин или пароль.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ЛР 12-5 Тюнин ТС ИБ-541</title>
</head>
<body>
    <h1>Авторизация</h1>
    <?php if ($error): ?>
        <p style="color:red"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label>
            Логин:<br>
            <input type="text" name="login"
                value="<?= htmlspecialchars($login, ENT_QUOTES, 'UTF-8') ?>">
        </label><br><br>
        <label>
            Пароль:<br>
            <input type="password" name="password">
        </label><br><br>
        <button type="submit">Войти</button>
    </form>
</body>
</html>
