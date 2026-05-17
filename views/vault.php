<?php 
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");
require_once '../classes/PasswordVault.php';
$vault = new PasswordVault();
$passwords = $vault->getPasswords();
?>
<!DOCTYPE html>
<html lang="lt">
<head><meta charset="UTF-8"><title>Saugykla</title></head>
<body>
<h2>Mano slaptažodžiai</h2>
<a href="add_password.php">+ Pridėti naują</a><br><br>

<table border="1" cellpadding="8">
    <tr><th>Svetainė</th><th>Slaptažodis</th><th>Data</th></tr>
    <?php foreach ($passwords as $p): ?>
    <tr>
        <td><?= htmlspecialchars($p['site_name']) ?></td>
        <td>
            <button onclick="alert('<?= $vault->decryptPassword($p['encrypted_password']) ?>')">Rodyti slaptažodį</button>
        </td>
        <td><?= $p['created_at'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<br><a href="dashboard.php">Grįžti</a>
</body>
</html>