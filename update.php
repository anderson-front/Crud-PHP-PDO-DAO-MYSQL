<?php
require_once 'vendor/autoload.php';

use App\Model\Produto;
use App\Model\ProdutoDao;

$produto = new Produto();

$produto->setId(3);
$produto->setNome('Teclado');
$produto->setDescricao('Sem Fio, Microsoft');

$produtoDao = new ProdutoDao();

$produtoDao->update($produto);
$produtoDao->read();

foreach($produtoDao->read() as $produto){
    echo "{$produto['nome']}<br>";
    echo "{$produto['descricao']}<hr>";
}
