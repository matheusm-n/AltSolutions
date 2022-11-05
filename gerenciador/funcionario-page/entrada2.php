<?php
   include "inc/header";
   include "../resources/ControlProduto.php";
   include "autenticar.php";
   $cp=new Control_Produto();
   
   if($estoque!=1){//verifica permissão
      header ("Location: index.html");
      exit();
   }
   if(isset($_GET)){
      if(isset($_GET['incluir'])&&isset($_GET['f'])){
         $prod = new Produto();
         $prod->produtoID=$_GET['incluir'];
         $prod=$cp->buscarProduto($prod);
         $forn=$cp->buscarFornecedor($_GET['f']);
      }
   }
   if(isset($_POST)){
      if(!empty($_POST)&&strlen($_POST['txt_numeronf'])>0&&intval($_POST['txt_qtdenf'])>0&&floatval($_POST['txt_valorprod'])>0&&strlen($_POST['txt_produtoidid'])>0&&strlen($_POST['txt_fornecedorid'])>0){
         $nf=new ProdNF();
         $nf->numeroNF=$_POST['txt_numeronf'];
         $nf->qtdeNF=intval($_POST['txt_qtdenf']);
         $nf->valorProd=floatval($_POST['txt_valorprod']);
         $nf->qtdeDisp=intval($_POST['txt_qtdenf']);
         $nf->produtoID=$_POST['txt_produtoidid'];
         $nf->fornecedorID=$_POST['txt_fornecedorid'];
         $res=$cp->inserirProdNF($nf);
         if(!is_string($res)){
            header ("Location: gerenciador.php");
            exit();
         }
         echo "<p>$res/p>";
         
      }
   }else{
      echo "<p>Preencha todos os campos de forma válida/p>";
   }

   include "inc/entrada_frm_nf";
   include "inc/footer";
?>