<?php 

    $cookie_name = 'user';
    $cookie_value = 'RIAN';
    setcookie($cookie_name, $cookie_value);
    
    $cookie_value = 'IWANN';
    setcookie($cookie_name, $cookie_value);

    echo $_COOKIE[$cookie_name];
    setcookie("user", "", time() - 3600);
    var_dump($_COOKIE)

?>