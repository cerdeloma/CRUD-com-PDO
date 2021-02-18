<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Vaga{

	/**
	* Identificador único da vaga
	* @var integer 
	*/
	public $id;

	/**
	* Título da vaga
	* @var string 
	*/
	public $titulo;

	/**
	* Descrição da vaga (pode conter html)
	* @var string 
	*/
	public $descricao;

	/**
	* Define se a vaga está ativa 
	* @var string(s/n)
	*/
	public $ativo;	

	/**
	* data da publicação da vaga
	* @var string 
	*/
	public $data;

	/**
	* Método para cadastrar uma nova vaga no banco de dados
	* @return boolean 
	*/
	public function cadastrar(){
		//DEFINIR A DATA
		$this->data = date('Y-m-d H:i:s');
		//INSERIR A VAGA NO BANCO 
		$obDatabase = new Database('vagas');
		$this->id = $obDatabase->insert([
											'titulo'	 => $this->titulo,
											'descricao'  => $this->descricao,
											'ativo'      => $this->ativo,
											'data'       => $this->data
										]);
		//RETORNAR SUCESSO
		return true;
	}


	// método responsavel por atualizar a vaga no banco
	public function atualizar(){
		return (new Database('vagas'))->update('id = '.$this->id, [
														'titulo'	 => $this->titulo,
														'descricao'  => $this->descricao,
														'ativo'      => $this->ativo,
														'data'       => $this->data
														]);
	}

	// método responsavel por excluir a vaga do banco
	public function excluir(){
		return (new Database('vagas'))->delete('id = '.$this->id);
	}


	// método responsável por obter as vagas no banco de dados
	public static function getVagas($where = null, $order = null, $limit = null){
		return (new Database('vagas'))->select($where,$order,$limit)
									  ->fetchAll(PDO::FETCH_CLASS,self::class);
	}

	// método responsável por obter a quantidade de vagas do banco de dados
	public static function getQuantidadeVagas($where = null){
		return (new Database('vagas'))->select($where,null,null,'COUNT(*) as qtd')
									  ->fetchObject()
									  ->qtd;
	}

	/**
	 * método responsável por buscar uma vaga com base em seu id
	 * @param integer $id
	 * @return Vaga
	 */
	public static function getVaga($id){
		return (new Database('vagas'))->select('id = '.$id)
									  ->fetchObject(self::class);
	}	



}	