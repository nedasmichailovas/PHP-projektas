<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Encryptor.php';

class User {
    public function register($username, $password) {
        $pdo = Database::getConn();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $masterKey = bin2hex(random_bytes(32));
        $encKey = Encryptor::encrypt($masterKey, $password);

        $stmt = $pdo->prepare(
            "INSERT INTO users (username, password_hash, master_key_encrypted) VALUES (?, ?, ?)"
        );
        return $stmt->execute([$username, $hash, $encKey]);
    }

    public function login($username, $password) {
        $pdo = Database::getConn();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // RAKTAS iššifruojamas su plain slaptažodžiu
            $masterKey = Encryptor::decrypt($user['master_key_encrypted'], $password);

            // session_start() iškviečiamas puslapyje, o ne čia
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['username']  = $user['username'];
            $_SESSION['master_key'] = $masterKey;
            return true;
        }
        return false;
    }
}
