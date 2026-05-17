<?php 
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");
require_once '../classes/PasswordVault.php';

if ($_POST) {
    $vault = new PasswordVault();
    $result = $vault->addPassword($_POST['site_name'], $_POST['password'], $_POST['notes'] ?? '');
    if ($result) {
        header("Location: vault.php");
        exit;
    } else {
        echo "<p style='color:red'>Klaida išsaugant slaptažodį!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Pridėti slaptažodį</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Pridėti naują slaptažodį</h2>
    <form method="POST">
        Svetainė / Programa: <input type="text" name="site_name" required><br><br>
        Slaptažodis: <input type="text" name="password" required><br><br>
        Pastabos: <textarea name="notes" rows="3"></textarea><br><br>
        <button type="submit">Išsaugoti slaptažodį</button>
    </form>
    <br>
    <a href="vault.php">← Grįžti į saugyklą</a>
</body>
</html>