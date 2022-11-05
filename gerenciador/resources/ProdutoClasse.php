<?php


class Produto {
    
    function __construct() {
        $this->prodNF=array();
        
    }

    public $produtoID;
    public $categoria;
    public $nome;
    public $descricao;
    public $imagem;
    public $peso;
    public $valorVenda;
    public $prodNF;
  
    
}
class Fornecedor{
    
    public $fornecedorID;
    public $cnpj;
    public $nome;
    public $endereco;
    public $telefone;
    public $email;
    public $site;

}
class ProdNF{
    public $produtoID;
    public $fornecedorID;
    public $numeroNF;
    public $dataNF;
    public $qtdeNF;
    public $valorProd;
    public $qtdeDisp;
    
}