<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="lt">
<head><meta charset="UTF-8"><title>Dashboard</title></head>
<body>
<h2>Sveiki, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
<p><a href="generate.php">→ Generuoti slaptažodį</a></p>
<p><a href="vault.php">→ Peržiūrėti saugyklą</a></p>
<p><a href="../logout.php">Atsijungti</a></p>
</body>
</html>