<?php

require __DIR__ .'/vendor/autoload.php';

use \App\Entity\Vaga;
use \App\Db\Pagination;
use \App\Session\Login;

// obriga o usuario a estar logado
Login::requireLogin();

//Busca 
$busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);

//filtro de status
$filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);

$filtroStatus = in_array($filtroStatus,['s','n']) ? $filtroStatus : '';
//condições SQL
$condicoes = [
	// se tiver texto na busca, ele retorna a pesquisa, senão retorna vazio
	strlen($busca) ? 'titulo LIKE "%'.str_replace(' ','%', $busca).'%"' : null,
	strlen($filtroStatus) ? 'ativo = "'.$filtroStatus.'"' : null
];

// remove posições vazias
$condicoes = array_filter($condicoes);


// cláusula where 
$where = implode(' AND ', $condicoes);

//quantidade total de vagas
$quantidadeVagas = Vaga::getQuantidadeVagas($where);

//paginação
$obPagination = new Pagination($quantidadeVagas, $_GET['pagina'] ?? 1, 5);

// obtém as vagas
$vagas = Vaga::getVagas($where,null,$obPagination->getLimit());


include __DIR__ .'/includes/header.php';
include __DIR__ .'/includes/listagem.php';
include __DIR__ .'/includes/footer.php';
