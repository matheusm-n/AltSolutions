<?php
   include '../resources/ControlProduto.php';
   $controleProduto=new Control_Produto();
   if(isset($_POST['busca'])){
      $res=$controleProduto->buscarProduto($_POST['busca']);
   }else{
      $res=$controleProduto->buscarProduto("");
   }

   include "inc/header";
   if(!isset($_COOKIE["ufunc"])||!isset($_COOKIE["sfunc"]))//verifica se está conectado
      header ("Location: index.html");
   include "autenticar.php";
   if($estoque!=1)//verifica permissão
      header ("Location: index.html");
   include "inc/estoque_frm_busca";
   include "inc/estoque_tb_produto";
   include "inc/footer";
?>
