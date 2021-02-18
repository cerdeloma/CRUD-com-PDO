<?php

require __DIR__ .'/vendor/autoload.php';


// classes que estamos usando
use \App\Session\Login;

//desloga o usuario
Login::logout();