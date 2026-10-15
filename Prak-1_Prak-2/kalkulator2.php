<?php
$hasil = null;
$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $a = (float) ($_POST['a'] ?? 0);
    $b = (float) ($_POST['b'] ?? 0);
    $operator = $_POST['operator'] ?? '+';

    // Membuat Operator dalam Kalkulator
    switch ($operator){
        case '+':
            $hasil = $a + $b;
            break;
        case '-':
            $hasil = $a - $b;
            break;
        case '*':
            $hasil = $a * $b;
            break;
        case '/':
            if ($b == 0){
                $pesan = 'Pembagian dengan nol tidak diperbolehkan.';
            }else{
                $hasil = $a / $b;
            }
            break;
        case '^':
            $hasil = pow($a, $b);
            break;
        default:
            $pesan ='Operator tidak valid.';
    }
}
?>

<!-- Tampilan dari Operator Kalkulator -->
<!doctype html>
<html lang="id">

<head>
    <meta charset = "utf-8">
    <title>Kalkulator Sederhana</title>
</head>

<body>
    <h1>D Calculator</h1>
    <p>Welcome to D Calculator</p>
    <form method="post">
        <input type = "number" step = "any" name= "a"
required>

        // <!-- pemilihan opsi operator (untuk user) -->
        <select name="operator">
            <option value="+">Addition (+)</option>
            <option value="-">Subtraction (-)</option>
            <option value="*">Multiplication (*)</option>
            <option value="/">Division (/)</option>
            <option value="^">Power (^)</option>
        </select>
        <input type = "number" step = "any" name= "b"
required>

        <!-- Menjalankan Operator yang Dipilih -->
        <button type="submit">Start Counting</button>

        </form>
        <?php if ($pesan): ?>
            <p><?= htmlspecialchars($pesan) ?></p>
        <?php elseif ($hasil !== null): ?>
            <p>Hasil: <?= htmlspecialchars((string)$hasil)?></p>
        <?php endif; ?>
</body>

</html>

<!-- Menambahkan Style pada Tampilan Website -->
<style>
    body { font-family: Arial, sans-serif; margin: 40px; text-align: center; background: #7a7a7a;}
    h1 { font-size: 50px; color: white;}
    form { background: #000000; padding: 20px; border-radius: 8px; inline-block; }
    input, select, button { padding: 8px; margin: 5px; }
    button { background: #fffb00; color: black; border-color: black; cursor: pointer; }
    input {background: #f4f4f4;}
</style>