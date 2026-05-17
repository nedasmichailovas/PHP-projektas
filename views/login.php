<?php require_once '../classes/User.php'; ?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Prisijungimas</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Prisijungimas</h2>
    <form method="POST">
        Vartotojo vardas: <input type="text" name="username" required><br><br>
        Slaptažodis: <input type="password" name="password" required><br><br>
        <button type="submit">Prisijungti</button>
    </form>
    <p><a href="register.php">Neturi paskyros? Registruokis</a></p>

    <?php
    if ($_POST) {
        $user = new User();
        if ($user->login($_POST['username'], $_POST['password'])) {
            header("Location: dashboard.php");
            exit;
        } else {
            echo "<p style='color:red'>Neteisingi prisijungimo duomenys!</p>";
        }
    }
    ?>
</body>
</html>