<?php
   /* só pra ter o que exibir */
   //$nome_usuario = "Bruce Wayne";
   include "../resources/ControlFunc.php";
   $cf=new ControlFunc();
   if(isset($_POST['busca'])){
      $res=$cf->buscarFunc($_POST['busca']);
   }else{
      $res=$cf->buscarFunc("");
   }
   
   include "inc/header";
   include "autenticar.php";
   if($admContas!=1){//verifica permissão
      header ("Location: index.html");
      exit();
   }
   if(isset($_GET['redefinir'])){
      $f=new Funcionario();
      $f->idFunc=$_GET['redefinir'];
      //print_r($f);
      $f=$cf->buscarFunc($f);
      //print_r($f);
      $f[0]->senhaFunc="";
      $cf->atualizarFunc($f[0]);
   }
   if(isset($_GET['excluir'])){
      $f=$cf->buscarFunc($_GET['excluir']);
      $cf->removerFunc($f[0]);
      header ("Location: contas2.php");
   }
   if(isset($_GET['atualizar'])){
      if(isset($_POST)){
         $f=new Funcionario();
         $f->idFunc=$_GET['atualizar'];
         $func=$cf->buscarFunc($_GET['atualizar']);
         $func[0]->admContas=isset($_POST['adm'])?1:0;
         $func[0]->estoque=isset($_POST['estoque'])?1:0;
         $func[0]->relatTotal=isset($_POST['relatorio'])?1:0;
         
         $resatualizacao=$cf->atualizarFunc($func[0]);
         
      }
   }
   if(isset($_GET['edit'])){
      $f=new Funcionario();
      $f->idFunc=$_GET['edit'];
      
      $f=$cf->buscarFunc($f);
      include "inc/contas_frm_modificar";
   }else{
      include "inc/contas_frm_busca";
      include "inc/contas_tb_busca";
   }
   include "inc/footer";
?>


