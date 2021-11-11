<?php
require_once 'vendor/autoload.php';

use App\Model\Produto;
use App\Model\ProdutoDao;

$produto = new Produto();

$produto->setNome('Maquina de Lavar');
$produto->setDescricao('brastemp, 20 litros');

$produtoDao = new ProdutoDao();

$produtoDao->create($produto);
$produtoDao->read();

foreach($produtoDao->read() as $produto){
    echo "{$produto['nome']}<br>";
    echo "{$produto['descricao']}<hr>";
}
