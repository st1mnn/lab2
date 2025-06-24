<!DOCTYPE html>
<html>
<head>
    <title>ЛР 13-3 Тюнин ТС ИБ-541</title>
</head>
<body>
    <h1>Первые 10 элементов последовательности Фибонначи</h1>
    <ul>
<?php
$fib = [0, 1];
for ($i = 2; $i < 10; $i++) {
    $fib[$i] = $fib[$i - 1] + $fib[$i - 2];
}
foreach ($fib as $index => $value) {
    $n = $index + 1;
    $text = "F($n) = $value";
    $style = '';
    if ($n % 3 === 0) {
        $style = ' style="color: Aqua;"';
    }
    echo "    <li{$style}>";
    if ($value % 2 !== 0) {
        echo '<em>';
    }
    echo htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    if ($value % 2 !== 0) {
        echo '</em>';
    }
    echo "</li>\n";
}
?>
    </ul>
</body>
</html>
