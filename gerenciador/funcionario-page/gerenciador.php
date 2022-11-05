<?php
   include "../resources/ControlProduto.php";
   $cp=new Control_Produto();
   if(isset($_POST['busca'])){
      $res=$cp->buscarProduto($_POST['busca']);
   }
   
   include "inc/header";
   include "autenticar.php";
   if(isset($_GET['venda'])){
      if($relatTotal == 1)
         include "inc/tb_vendas";
      else
         header ("Location: gerenciador.php");
   }elseif (isset($_GET['nf'])) {
      include "inc/tb_pedido_nf";
   }elseif (isset($_GET['cancelado'])) {
      include "inc/tb_pedido_cancelado";
   }else{
      include "inc/sac";
   }
   include "inc/footer";
?>