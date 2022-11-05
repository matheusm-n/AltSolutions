<?php
   /* só pra ter o que exibir */
   include "../resources/ControlFunc.php";
   include "../resources/validaCPF.php";
   $cf=new ControlFunc();
   if(isset($_POST)){
      if(!empty($_POST)){
         if(validaCPF($_POST['txt_cpf'])){
            $f = new Funcionario();
            $f->cpfFunc=$_POST['txt_cpf'];
            $f->nomeFunc=$_POST['txt_nome'];
            $f->admContas=isset($_POST['adm']);
            $f->estoque=isset($_POST['estoque']);
            $f->relatTotal=isset($_POST['relatorio']);
            $res=$cf->inserirFunc($f);
            if(is_string($res))
               $erro=$res;
         }else{
            $erro="CPF inválido";
         }
      }
   }

   include "inc/header";
   include "autenticar.php";

   include "inc/contas_frm_nova";

   include "inc/footer";
?>


