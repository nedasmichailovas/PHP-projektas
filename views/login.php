<?php require_once '../classes/User.php'; ?>
<!DOCTYPE html>
<html lang="lt">
<head><meta charset="UTF-8"><title>Prisijungimas</title></head>
<body>
<h2>Prisijungimas</h2>
<form method="POST">
    Vartotojo vardas: <input type="text" name="username" required><br><br>
    Slaptažodis: <input type="password" name="password" required><br><br>
    <button type="submit">Prisijungti</button>
</form>
<a href="register.php">Registruotis</a>
</body>
</html>

<?php
if ($_POST) {
    $user = new User();
    if ($user->login($_POST['username'], $_POST['password'])) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<p style='color:red'>Neteisingi duomenys!</p>";
    }
}
?>