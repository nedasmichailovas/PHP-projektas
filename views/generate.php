<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once '../classes/PasswordGenerator.php';

$generated = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $length  = (int)($_POST['length']  ?? 16);
    $upper   = (int)($_POST['upper']   ?? 3);
    $lower   = (int)($_POST['lower']   ?? 5);
    $numbers = (int)($_POST['numbers'] ?? 3);
    $special = (int)($_POST['special'] ?? 2);

    // Validacija
    if ($length < 4 || $length > 128) {
        $error = 'Ilgis turi būti tarp 4 ir 128.';
    } elseif ($upper < 0 || $lower < 0 || $numbers < 0 || $special < 0) {
        $error = 'Simbolių kiekiai negali būti neigiami.';
    } else {
        $gen = new PasswordGenerator();
        $generated = $gen->generate($length, $upper, $lower, $numbers, $special);
    }
}
?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Slaptažodžių Generatorius</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Slaptažodžių Generatorius</h2>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        Bendras ilgis: <input type="number" name="length" value="16" min="4" max="128"><br><br>
        Didžiosios raidės (kiek): <input type="number" name="upper" value="3" min="0"><br>
        Mažosios raidės (kiek): <input type="number" name="lower" value="5" min="0"><br>
        Skaičiai (kiek): <input type="number" name="numbers" value="3" min="0"><br>
        Spec. simboliai (kiek): <input type="number" name="special" value="2" min="0"><br><br>
        <button type="submit">Generuoti slaptažodį</button>
    </form>

    <?php if ($generated): ?>
        <h3>Sugeneruotas slaptažodis:</h3>
        <p><strong><?= htmlspecialchars($generated) ?></strong></p>
        <p>
            <a href="add_password.php?prefill=<?= urlencode($generated) ?>">
                → Išsaugoti šį slaptažodį saugykloje
            </a>
        </p>
    <?php endif; ?>

    <br>
    <a href="dashboard.php">← Grįžti į dashboard</a>
</body>
</html>
