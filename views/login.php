<?php
// session_start() PIRMA, prieš bet kokį išvestį
session_start();
require_once '../classes/User.php';

// Jei jau prisijungęs – nukreipiame
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $user = new User();
        if ($user->login($username, $password)) {
            header("Location: dashboard.php");
            exit;
        } else {
            $error = 'Neteisingi prisijungimo duomenys!';
        }
    } else {
        $error = 'Prašome užpildyti visus laukus.';
    }
}
?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Prisijungimas</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Prisijungimas</h2>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        Vartotojo vardas: <input type="text" name="username" required><br><br>
        Slaptažodis: <input type="password" name="password" required><br><br>
        <button type="submit">Prisijungti</button>
    </form>
    <p><a href="register.php">Neturi paskyros? Registruokis</a></p>
</body>
</html>
