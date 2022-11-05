<?php
   include '../resources/ControlProduto.php';
   
   $controleProduto=new Control_Produto();
   $f=new Fornecedor();
   $f->endereco=new Endereco();
   $f->fornecedorID=$controleProduto->ultimoFornecedorID();
   //echo print_r($fID);
   if(!empty($_POST)){
      $f->cnpj=$_POST['txt_cnpj'];
      $f->nome=$_POST['txt_nome'];
      $f->endereco=$controleProduto->buscarCep($_POST['txt_cep']);
      if(strcmp("",$f->endereco->endereco)==0)
         $erro="CEP não encontrado";
      $f->endereco->num=$_POST['txt_num'];
      $f->endereco->complemento=$_POST['txt_complemento'];
      $f->telefone=$_POST['txt_telefone'];
      $f->email=$_POST['txt_email'];
      $f->site=$_POST['txt_site'];
      if(isset($_POST['salvar'])){
         //print_r($_POST);
         if(strlen($f->nome)==0||strlen($f->cnpj)==0||strlen($f->telefone)==0||strlen($f->email)==0||strlen($f->site)==0||strlen($f->endereco->num)==0||strlen($f->endereco->cep)==0||strlen($f->endereco->endereco)==0||strlen($f->endereco->cidade)==0||strlen($f->endereco->bairro)==0||strlen($f->endereco->uf)==0){
            $erro="Preencha todos os campos!";
         }else{
            $f->endereco=$controleProduto->buscarCep($_POST['txt_cep']);
            if(strcmp("",$f->endereco->endereco)!=0){
               $res=$controleProduto->inserirFornecedor($f);
               header ("Location: estoque.php");
               exit();
            }else
               $erro="`É necessário inserir um endereço válido";
            
            if(is_string($res)){
               $erro=$res;
            }
         }
      }
   }
      
   include "inc/header";
   if(!isset($_COOKIE["ufunc"])||!isset($_COOKIE["sfunc"])){//verifica se está conectado
      header ("Location: index.html");
   }
   include "autenticar.php";
   if($estoque!=1)//verifica permissão
      header ("Location: index.html");
   include "inc/fornecedor_frm_cad";
   include "inc/footer";
?>