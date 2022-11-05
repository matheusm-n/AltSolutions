<?php
   include "../resources/ControlProduto.php";
   $cp= new Control_Produto();
   //print_r($_GET['inserir']);
    //print_r($_GET['editar']);
   if(isset($_GET['excluir'])){
      $p=$cp->buscarProduto($_GET['excluir']);
      if(!is_null($p))
         $cp->removerProduto($p[0]);
         header ("Location: estoque.php");
         exit();
   }
   if(isset($_POST['busca'])){
      $res=$cp->buscarFornecedor($_POST['busca']);
   }else{
      $res=$cp->buscarFornecedor("");
   }
   include "inc/header";
   if(!isset($_COOKIE["ufunc"])||!isset($_COOKIE["sfunc"])){//verifica se está conectado
      header ("Location: index.html");
      exit();
   }
   if(isset($_GET['inserir'])){
      $prod=$_GET['inserir'];
   }
   include "autenticar.php";
   if($estoque!=1){//verifica permissão
      header ("Location: index.html");
      exit();
   }
   include "inc/entrada_frm_busca";
   include "inc/entrada_tb_fornecedor";
   include "inc/footer";
?>