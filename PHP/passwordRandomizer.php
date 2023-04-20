<?php 
$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+';
$password_length = 12;

$password = '';
for ($i = 0; $i < $password_length; $i++) {
    $password .= $characters[rand(0, strlen($characters) - 1)];
}

echo "Your new password ! : " . $password;