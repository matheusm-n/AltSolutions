<?php
   include '../resources/ControlProduto.php';
   $controleProduto=new Control_Produto();
   $produtoID=$controleProduto->ultimoProdutoID();
   $erro;
   if(isset($_POST) && !empty($_POST)){
      if(strlen($_POST['txt_nome'])==0||strlen($_POST['txt_descricao'])==0||strlen($_POST['txt_valorvenda'])==0||strlen($_POST['txt_peso'])==0||floatval($_POST['txt_valorvenda'])<=0||floatval($_POST['txt_peso'])<=0)
         $erro="Preencha todos os campos!";
      else{
         $produto= new Produto();
         $produto->produtoID=$produtoID;
         $produto->categoria=$_POST['txt_categoria'];
         $produto->nome=$_POST['txt_nome'];
         $produto->descricao=$_POST['txt_descricao'];
         $produto->imagem=$_FILES['pic'];
         $produto->valorVenda=str_replace(",",".",$_POST['txt_valorvenda']);
         $produto->peso=str_replace(",",".",$_POST['txt_peso']);
         //print_r($_FILES);
         $res=$controleProduto->inserirProduto($produto);
         if(is_string($res))
            echo $res;
         else
            header ("Location: estoque.php");
      }
   }
   /*/if(isset($_POST))
      echo print_r($_POST);*/
   include "inc/header";
   if(!isset($_COOKIE["ufunc"])||!isset($_COOKIE["sfunc"]))//verifica se está conectado
      header ("Location: index.html");
   include "autenticar.php";
   if($estoque!=1)//verifica permissão
      header ("Location: index.html");
   
   include "inc/produto_frm_cad";
   include "inc/footer";
?>