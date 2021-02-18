<?php

use \App\Session\Login;

// recebe os dados do usuario logado
$usuarioLogado = Login::getUsuarioLogado();

// se o usuario estiver logado, vai aparecer o botão sair, senão vai aparecer o botão entrar, e direciona para pagina de login
$usuario = $usuarioLogado ? $usuarioLogado['nome'].' <a href="logout.php" class="text-light font-weight-bold ml-2"> Sair </a>' : 'Visitante <a href="login.php" class="text-light font-weight-bold ml-2">Entrar</a>'


?>

<!doctype html>
<html lang="pt-BR">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>CRUD com PHP & MySQL</title>
  </head>
  <body class="bg-dark text-light">

    <div class="container mb-5">
        
        <div class="jumbotron bg-danger">
            <h1>Vagas de emprego</h1>
            <p>Exemplo de CRUD com PHP orientado a objetos e MySQL</p>

            <hr class="border-light">
            <div class="d-flex justify-content-start">
              <?=$usuario?>
            </div>
        </div>