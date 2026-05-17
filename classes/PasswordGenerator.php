<?php
class PasswordGenerator {
    public function generate($length = 16, $upper = 3, $lower = 5, $numbers = 3, $special = 2) {
        $u = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $l = 'abcdefghijklmnopqrstuvwxyz';
        $n = '0123456789';
        $s = '!@#$%^&*()_+-=';

        $password = '';
        for ($i = 0; $i < $upper; $i++)   $password .= $u[rand(0, strlen($u)-1)];
        for ($i = 0; $i < $lower; $i++)   $password .= $l[rand(0, strlen($l)-1)];
        for ($i = 0; $i < $numbers; $i++) $password .= $n[rand(0, strlen($n)-1)];
        for ($i = 0; $i < $special; $i++) $password .= $s[rand(0, strlen($s)-1)];

        $all = $u . $l . $n . $s;
        while (strlen($password) < $length) {
            $password .= $all[rand(0, strlen($all)-1)];
        }
        return str_shuffle($password);
    }
}