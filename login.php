<?php

require __DIR__ .'/vendor/autoload.php';


// classes que estamos usando
use \App\Entity\Usuario;
use \App\Session\Login;

// obriga o usuario a não estar logado
Login::requireLogout();

// mensagem de alerta dos formulários
$alertaLogin = '';
$alertaCadastro = '';

//validação do post
if(isset($_POST['acao'])){
	switch($_POST['acao']){
		case 'logar';

			//pega o usuario pelo e-mail
			$obUsuario = Usuario::getUsuarioPorEmail($_POST['email']);

			// se usuario ou senha for invalidos, retorna a mensagem do alertalogin
			if(!$obUsuario instanceof Usuario || !password_verify($_POST['senha'], $obUsuario->senha)){
				$alertaLogin = 'E-mail ou senha invalidos!';
				break;
			}

			// Loga o usuario
			Login::login($obUsuario);

			break;

		case 'cadastrar';

		//validação dos campos obrigatorios 
		if(isset($_POST['nome'],$_POST['email'],$_POST['senha'])){

			//pega o usuario pelo e-mail
			$obUsuario = Usuario::getUsuarioPorEmail($_POST['email']);
			if ($obUsuario instanceof Usuario){
				$alertaCadastro = 'O e-mail digitado já está em uso';
				break;
			}

			// novo usuario

			$obUsuario = new Usuario;
			$obUsuario->nome  = $_POST['nome'];
			$obUsuario->email = $_POST['email'];
			$obUsuario->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

			$obUsuario->cadastrar();

			// Loga o usuario
			Login::login($obUsuario);
		}

			break;
	}
}



include __DIR__ .'/includes/header.php';
include __DIR__ .'/includes/formulario-login.php';
include __DIR__ .'/includes/footer.php';
