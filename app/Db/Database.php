<?php

// Faz a ponte entre o sistema e o banco de dados, utilizando o PDO, ela vai funcionar como Query Builder.

namespace App\Db;

use \PDO;
use \PDO\exception;

class Database{

	// host de conexão
	const HOST = 'localhost';

	// nome do banco de dados
	const NAME = 'pbc_vagas';

	// usuario do banco de dados 
	const USER = 'root';

	// senha do banco de dados
	const PASS = '';

	// nome da tabela a ser manipulada
	private $table;

	// estância de pdo, instância de conexão com o banco de dados 
	private $connection;

	// define a tabela e a instancia de conexão
	public function __construct($table = null){
		$this->table = $table;
		$this->setConnection();
	}

	// método responsavel por criar uma conexão com o banco de dados
	private function setConnection(){
		try{
			$this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME,self::USER,self::PASS);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		}catch(PDOexception $e){
			die('ERROR: '.$e->getMessage());
		}
	}

   /**
    * método responsável por executar queries no banco de dados
	* @param string $query 
	* @param array  $params
	* @return PDOStatement 
	*/
	public function execute($query, $params = []){
		try{
			$statement = $this->connection->prepare($query);
			$statement->execute($params);
			return $statement;
		}catch(PDOexception $e){
			die('ERROR: '.$e->getMessage());
		}
	}

	// método responsável por inserir dados no banco
	// @param array $valuews [field => value]
	// @return integer id inserido
	public function insert ($values){
		// dados da query
		$fields = array_keys($values);
		$binds  = array_pad([], count($fields), '?');

		// monta a query
		$query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',', $binds).')';

		// executa o insert
		$this->execute($query, array_values($values));

		// retorna o id inserido
		return $this->connection->lastInsertId();

	}

	// médoto responsavel por executar uma consulta no banco 
	// PDOStatement
	public function select($where = null, $order = null, $limit = null, $fields = '*'){
		// dados da query
		$where = strlen($where) ? 'WHERE ' .$where : '';
		$order = strlen($order) ? 'ORDER ' .$order : '';
		$limit = strlen($limit) ? 'LIMIT ' .$limit : '';

		$query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;
		return $this->execute($query);
	}

	// método responsavel por executar atualizações dentro do banco de dados
	public function update($where, $values){
		//dados da query
		$fields = array_keys($values);

		// monta a query
		$query = 'UPDATE '. $this->table.' SET '.implode('=?, ', $fields). '=? WHERE '.$where;

		// executar a query
		$this->execute($query, array_values($values));

		// retorna sucesso
		return true;
	}

	// método responsavel por excluir dados do banco
	public function delete($where){
		// monta a quert
		$query = 'DELETE FROM '.$this->table.' WHERE '.$where;

		//executa a query
		$this->execute($query);

		//retorna sucesso 
		return true;

	}

}