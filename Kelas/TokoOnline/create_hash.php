<?php
// Ganti 'password' dengan password yang ingin Anda hash
$password = 'aku123'; // Ganti dengan password yang Anda inginkan
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo "Hashed Password: " . $hashedPassword;
?>