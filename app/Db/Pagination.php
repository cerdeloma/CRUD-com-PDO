<?php

namespace App\Db;

class Pagination{

	// número máximo de registros por página
	private $limit;

	// quantidade total de resultados do banco
	private $results;

	// quantidade de paginas 
	private $pages;

	// para saber qual é a pagina atual
	private $currentPage;

	// construtor da classe
	public function __construct($results,$currentPage = 1, $limit = 10){
		$this->results = $results;
		$this->limit = $limit;
		$this->currentPage = (is_numeric($currentPage) and $currentPage > 0) ? $currentPage : 1;
		$this->calculate();
	} 

	// método responsavel por calcular a paginação
	private function calculate(){
		// calcula o total de páginas
		$this->pages = $this->results > 0 ? ceil($this->results / $this->limit) : 1;

		// verifica se a página atual não excede o número de páginas
		$this->currentPage = $this->currentPage <= $this->pages ? $this->currentPage : $this->pages; 

	}

	// método responsável por retornar a clausula limit  da SQL
	public function getLimit(){
		$offset = ($this->limit * ($this->currentPage - 1));
		return $offset.','.$this->limit;
	}

	// método responsavel por retornar as opções de páginas disponiveis
	public function getPages(){
		// não retorna páginas
		if($this->pages == 1) return [];

		//paginas
		$paginas = [];
		for($i = 1; $i <= $this->pages; $i++){
			$paginas[] = [
				'pagina' => $i,
				'atual' => $i == $this->currentPage
			];
		}
		
		return $paginas;
	}
}