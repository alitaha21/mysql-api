<?php
$pasword = 'user-password';
// To create a valid password out of laravel Try out!
$cost=10; // Default cost
$password = password_hash($pasword, PASSWORD_BCRYPT, ['cost' => $cost]);

// To validate the password you can use
$hash = '$2y$10$NhRNj6QF.Bo6ePSRsClYD.4zHFyoQr/WOdcESjIuRsluN1DvzqSHm';

if (password_verify($pasword, $hash)) {
   echo 'Password is valid!';
} else {
   echo 'Invalid password.';
}

//Finally if you have a $hash but you want to know the information about that hash. 
print_r( password_get_info( $password_hash ));
?>
