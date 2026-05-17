<?php 
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");
require_once '../classes/PasswordGenerator.php';
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
    <form method="POST">
        Ilgis: <input type="number" name="length" value="16"><br><br>
        Didžiosios raidės: <input type="number" name="upper" value="3"><br>
        Mažosios raidės: <input type="number" name="lower" value="5"><br>
        Skaičiai: <input type="number" name="numbers" value="3"><br>
        Spec. simboliai: <input type="number" name="special" value="2"><br><br>
        <button type="submit">Generuoti slaptažodį</button>
    </form>

    <?php
    if ($_POST) {
        $gen = new PasswordGenerator();
        $pass = $gen->generate($_POST['length'], $_POST['upper'], $_POST['lower'], $_POST['numbers'], $_POST['special']);
        echo "<h3>Sugeneruotas slaptažodis: <strong>$pass</strong></h3>";
    }
    ?>
    <br>
    <a href="dashboard.php">← Grįžti į dashboard</a>
</body>
</html>