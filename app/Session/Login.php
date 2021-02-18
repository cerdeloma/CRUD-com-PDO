<?php

namespace App\Session;

class Login{


	// método responsavel por iniciar a sessão
	// não permite que o usuario logue duas vezes, podendo assim dar conflito
	private static function init(){
		// verifica status da sessão
		if(session_status() !== PHP_SESSION_ACTIVE){
			// inicia a sessão
			session_start();

			// serve para que o usuario não perca seu acesso, somente se o usuario fechar o navegador
		}

	}

	// retorna os dados do usuario logado
	public static function getUsuarioLogado() {
		//inicia a sessão
		self::init();

		//retorna dados do usuario
		return self::isLogged() ? $_SESSION['usuario'] : null;
	}

	// método responsavel por criar a sessão do usuario logado 
	public static function login($obUsuario){

		//inicia a sessão
		self::init();

		// Sessão de usuário 
		$_SESSION['usuario'] = [
			'id'    => $obUsuario->id,
			'nome' 	=> $obUsuario->nome,
			'email' => $obUsuario->email
		];

		// redireciona usuario para index
		header('Location: index.php');
		exit;
	}

	// método responsavel por deslogar o usuario
	public static function logout() {
		//inicia a sessão
		self::init();		

		// remove a sessão do usuario
		unset($_SESSION['usuario']);

		// redireciona usuario para o login
		header('Location: login.php');
		exit;
	}

	// método responsavel por verificar se user está logado
	public static function isLogged(){
		//inicia a sessão
		self::init();

		// validação da sessão, se existir o id, o usuario está logado	
		return isset($_SESSION['usuario']['id']);
	}

	// método responsavel por obrigar o usuario a estar logado
	// se não estiver logado, redireciona para pagina de login
	public static function requireLogin(){
		if(!self::isLogged()){
			header('location: login.php');
			exit;
		}
	} 

		// método responsavel por obrigar o usuario a estar deslogado
		// se o usuario estiver logado, redireciona ele para a página index
	public static function requireLogout(){
		if(self::isLogged()){
			header('location: index.php');
			exit;
		}
	} 

}
