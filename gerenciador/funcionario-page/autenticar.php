<?php
   /* Validada cookies de autenticação e Acesso aos Menus */
   if(isset($_COOKIE["ufunc"]))
      $user_func = $_COOKIE["ufunc"];

   if(isset($_COOKIE["sfunc"]))
      $senha_func = $_COOKIE["sfunc"];

   if (empty($user_func) or empty($senha_func))
      include "logout.php";

   include "conectar.php";
   $valida_login = mysqli_query($conectar, "SELECT * FROM Funcionario where funcCPF='$user_func'");
   $linhas_v = mysqli_num_rows($valida_login);
   
   if($linhas_v == 0)
      include "logout.php";
   else
   {
      $autenticar=mysqli_fetch_assoc($valida_login);
      if(password_verify($senha_func,$autenticar['senhaFunc'])){
         $nome_usuario = $autenticar['nomeFunc'];
         $estoque = $autenticar['estoque'];
         $relatTotal = $autenticar['relatTotal'];
         $admContas = $autenticar['admContas'];
         mysqli_close($conectar);
         /* Valida permissões e cria Menu */
         if ($estoque == 1)
            include "inc/menu_estoque";
         if ($relatTotal == 1)
            include "inc/menu_gerente";
         include "inc/conteudo";
      }else{
         include "logout.php";
      }
   }
      

?>