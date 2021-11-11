<?php
require_once 'vendor/autoload.php';

use App\Model\Produto;
use App\Model\ProdutoDao;

$produto = new Produto();

$produtoDao = new ProdutoDao();
$produtoDao->read();

foreach($produtoDao->read() as $produto){
    echo "{$produto['nome']}<br>";
    echo "{$produto['descricao']}<hr>";
}
