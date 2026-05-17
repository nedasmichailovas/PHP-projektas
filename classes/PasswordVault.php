<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Encryptor.php';

class PasswordVault {
    private $masterKey;

    public function __construct() {
        session_start();
        $this->masterKey = $_SESSION['master_key'] ?? null;
    }

    public function addPassword($site_name, $password, $notes = '') {
        if (!$this->masterKey) return false;
        
        $encrypted = Encryptor::encrypt($password, $this->masterKey);
        $pdo = Database::getConn();

        $stmt = $pdo->prepare("INSERT INTO password_entries (user_id, site_name, encrypted_password, notes) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$_SESSION['user_id'], $site_name, $encrypted, $notes]);
    }

    public function getPasswords() {
        $pdo = Database::getConn();
        $stmt = $pdo->prepare("SELECT * FROM password_entries WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetchAll();
    }

    public function decryptPassword($encrypted) {
        if (!$this->masterKey) return "Klaida dekoduojant";
        return Encryptor::decrypt($encrypted, $this->masterKey);
    }
}