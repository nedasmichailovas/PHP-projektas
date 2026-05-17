<?php 
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");
require_once '../classes/PasswordVault.php';
$vault = new PasswordVault();
$passwords = $vault->getPasswords();
?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Saugykla</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Mano Slaptažodžių Saugykla</h2>
    <p><a href="add_password.php">+ Pridėti naują slaptažodį</a></p>

    <table>
        <tr>
            <th>Svetainė</th>
            <th>Slaptažodis</th>
            <th>Data</th>
        </tr>
        <?php foreach ($passwords as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['site_name']) ?></td>
            <td>
                <button onclick="alert('<?= htmlspecialchars($vault->decryptPassword($p['encrypted_password'])) ?>')">Rodyti</button>
            </td>
            <td><?= $p['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="dashboard.php">← Grįžti</a>
</body>
</html>