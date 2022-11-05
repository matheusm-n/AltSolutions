<?php
// obt�m os valores digitados
$ufunc = $_POST["txt_usuario"];
$sfunc = $_POST["txt_senha"];

// acesso ao banco de dados
include "conectar.php";
$reslogin = mysqli_query($conectar, "SELECT * FROM Funcionario where funcCPF='$ufunc'");
$login_linhas = mysqli_num_rows($reslogin);

// testa se a consulta retornou algum registro
if($login_linhas!=0){
    if(password_verify($sfunc,mysqli_fetch_row($reslogin)[3])){
        setcookie ("ufunc", $ufunc);
        setcookie ("sfunc", $sfunc);
        header ("Location: gerenciador.php");
    }else{
       
        header ("Location: erro.html"); 
        
    }
    
}
else
{
    
    header ("Location: erro.html"); 
    
}
mysqli_close($conectar);
?>

