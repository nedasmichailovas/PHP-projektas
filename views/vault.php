<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once '../classes/PasswordVault.php';

$vault = new PasswordVault();

// Slaptažodžio trynimas
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $vault->deletePassword((int)$_GET['delete']);
    header("Location: vault.php");
    exit;
}

$passwords = $vault->getPasswords();
?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Saugykla</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .pass-field { font-family: monospace; letter-spacing: 2px; }
        .show-btn { padding: 5px 10px; font-size: 14px; }
    </style>
</head>
<body>
    <h2>Mano Slaptažodžių Saugykla</h2>
    <p><a href="add_password.php">+ Pridėti naują slaptažodį</a></p>

    <?php if (empty($passwords)): ?>
        <p>Saugykla tuščia. <a href="add_password.php">Pridėkite pirmą slaptažodį</a>.</p>
    <?php else: ?>
    <table>
        <tr>
            <th>Svetainė</th>
            <th>Slaptažodis</th>
            <th>Pastabos</th>
            <th>Data</th>
            <th>Veiksmai</th>
        </tr>
        <?php foreach ($passwords as $p): ?>
        <?php
            // Iššifruojame serverio pusėje – nededame į HTML atributas
            $decrypted = $vault->decryptPassword($p['encrypted_password']);
        ?>
        <tr>
            <td><?= htmlspecialchars($p['site_name']) ?></td>
            <td>
                <span class="pass-field" id="pass-<?= $p['id'] ?>">••••••••</span>
                <button class="show-btn" onclick="togglePass(<?= $p['id'] ?>, <?= htmlspecialchars(json_encode($decrypted), ENT_QUOTES) ?>)">
                    Rodyti
                </button>
            </td>
            <td><?= htmlspecialchars($p['notes'] ?? '') ?></td>
            <td><?= htmlspecialchars($p['created_at']) ?></td>
            <td>
                <a href="?delete=<?= $p['id'] ?>"
                   onclick="return confirm('Ar tikrai trinti?')">🗑 Trinti</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>

    <script>
    // Slaptažodis rodomas tik paspaudus – iš PHP serverio, ne HTML atribute
    function togglePass(id, pass) {
        const el = document.getElementById('pass-' + id);
        const btn = el.nextElementSibling;
        if (el.textContent === '••••••••') {
            el.textContent = pass;
            btn.textContent = 'Slėpti';
        } else {
            el.textContent = '••••••••';
            btn.textContent = 'Rodyti';
        }
    }
    </script>

    <br>
    <a href="dashboard.php">← Grįžti</a>
</body>
</html>
