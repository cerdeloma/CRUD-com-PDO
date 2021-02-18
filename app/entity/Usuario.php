<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Usuario {

	// identificado do usuario
	public $id;

	// nome
	public $nome;

	// email
	public $email;

	// hash senha do usuario

	public $senha;

	// método responsavel por cadastrar um novo usuario no banco; retorna bool
	public function cadastrar(){


		// DATABASE, dentro do new database está a tabela do banco de dados responsavel por armazenar os dados do usuario
		$obDatabase = new Database('usuarios');

		// insere um novo usuario
		$this->id = $obDatabase->insert([

			'nome'  => $this->nome,
			'email' => $this->email,
			'senha' => $this->senha

		]);
		//sucesso
		return true;

	}

	// método responsavel por retornar uma instancia de usuario com base em seu email
	public static function 	getUsuarioPorEmail($email){
		return (new Database('usuarios'))->select('email ="'.$email.'"')->fetchObject(self::class);


	}



}