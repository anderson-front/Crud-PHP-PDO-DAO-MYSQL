# Crud PHP PDO DAO MYSQL

[![CRUD-Operation-using-PHP7-My-Sql-PDO.png](https://i.postimg.cc/GhFmqhGS/CRUD-Operation-using-PHP7-My-Sql-PDO.png)](https://postimg.cc/sv2z2znp)


## Introdução ao PDO
PDO – PHP Data Objects – é uma camada de acesso a base de dados que provê uma maneira uniforme de acessar bases de dados diferentes.

> **Note:** Isso não leva em consideração as sintaxes específicas das bases de dados, mas permite que o processo de mudança de bases de dados e plataformas seja, praticamente, sem problemas, simplesmente mudando os dados de conexão.



## Estrutura de Pastas

- [App]
    * [Model]
        + [conexao.php](#conexao.php)
        + [produto.php](#produto.php)
        + [produtoDao.php](#produtoDao.php)
    - [vendor]
      - [composer]
          + [autoload_psr4.php](#autoload_psr4.php)...
    
    + [composer.json](#composer.json)
    + [create.php](#create.php)
    + [delete.php](#delete.php)
    + [read.php](#read.php)
    + [update.php](#update.php)

### conexao.php

Class responsável pela conexão com o banco de dados:

```php
<?php

namespace App\Model;

class Conexao
{
    private static $instance;

    public static function getConn() {
        
        if(!isset(self::$instance)) {
            self::$instance = new \PDO('mysql:host=localhost;dbname=pdo;charset=utf8','root','');
        }

        return self::$instance;
    }

}
```

### produto.php

Classe responsável pelos dados de um produto

```php
<?php

namespace App\Model;

class Produto 
{
    private $id, $nome, $descricao;

    /**
     * Get the value of nome
     */ 
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     *
     * @return  self
     */ 
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of descricao
     */ 
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set the value of descricao
     *
     * @return  self
     */ 
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}

```

### produtoDao.php

Classe responsável por fazer  CRUD(Create,Read,Update,Delete)

```php
<?php
namespace App\Model;

class ProdutoDao 
{
    public function create(Produto $p) {

        $sql = 'INSERT produtos(nome,descricao) VALUES(?,?)';

        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->bindValue(1,$p->getNome());
        $stmt->bindValue(2,$p->getDescricao());

        $stmt->execute();
    }

    public function read() {
        $sql = 'SELECT * FROM produtos';

        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        } else {
            return [];
        }

    }

    public function update(Produto $p) {

        $sql = 'UPDATE produtos SET nome = ?, descricao = ? WHERE id=?';

        $stmt = Conexao::getConn()->prepare($sql);

        $stmt->bindValue(1,$p->getNome());
        $stmt->bindValue(2,$p->getDescricao());
        $stmt->bindValue(3,$p->getId());

        $stmt->execute();

    }

    public function delete($id) {

        $sql = 'DELETE FROM produtos WHERE id =?';

        $stmt =  Conexao::getConn()->prepare($sql);
        $stmt->bindValue(1,$id);
        $stmt->execute();

    }
}
```

### composer.json

Arquivo responsável em criar a estrutura da pasta vendor e definir o padrão de autoload de classes no padrão Psr-4.
Depois de criar o arquivo deve-se rodar no terminal o comando composer **dump-autoload**

```php
{
    "autoload": {
        "psr-4": {
            "App\\":"App/"
        }
    }
}
```

### Arquivos de execução e instanciação (criação dos objetos) das classes responsáveis pelo CRUD (Create,Read,Update,Delete) 

### Create
```php
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

```

### delete

```php
<?php
require_once 'vendor/autoload.php';

use App\Model\Produto;
use App\Model\ProdutoDao;

$produto = new Produto();
$produtoDao = new ProdutoDao();

$produtoDao->delete(6);
$produtoDao->read();

foreach($produtoDao->read() as $produto){
    echo "{$produto['nome']}<br>";
    echo "{$produto['descricao']}<hr>";
}

```

### read

```php

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

```

### update

```php
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

```
