<?php
   include "../resources/ControlFunc.php";
   include "../resources/validaCPF.php";
   $cf=new ControlFunc();
   
   
   include "inc/header";
   include "autenticar.php";
   if(isset($_POST)){
      if(isset($_GET['ns'])){
         $func=$cf->buscarFunc($user_func);
         if(strcmp($_POST['txt_nsenha'],$_POST['txt_rsenha'])!=0){
            $erro="A nova senha não coincide com sua confirmação";
         }else if(!password_verify($_POST['txt_senha'],$func[0]->senhaFunc)){
            $erro="Senha atual inválida";
         }else{
            $f = new Funcionario();
            $f=$func[0];
            $f->senhaFunc=$_POST['txt_nsenha'];
            $res=$cf->atualizarFunc($f);
            if(is_string($res))
               $erro=$res;
         }
      }
      
   
   }
   include "inc/contas_mudar_senha";
   include "inc/footer";
?>


