<?php require_once '../classes/User.php'; ?>
<!DOCTYPE html>
<html lang="lt">
<head><meta charset="UTF-8"><title>Registracija</title></head>
<body>
<h2>Registracija</h2>
<form method="POST">
    Vartotojo vardas: <input type="text" name="username" required><br><br>
    Slaptažodis: <input type="password" name="password" required><br><br>
    <button type="submit">Registruotis</button>
</form>
</body>
</html>

<?php
if ($_POST) {
    $user = new User();
    if ($user->register($_POST['username'], $_POST['password'])) {
        echo "<p style='color:green'>Registracija sėkminga! <a href='login.php'>Prisijunk</a></p>";
    } else {
        echo "<p style='color:red'>Klaida registruojant!</p>";
    }
}
?>