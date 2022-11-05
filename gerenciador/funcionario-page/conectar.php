<?php 
	//nome do servidor, usuário da base de dados, senha e nome da base	
	$bdhost="servidor";
	$bduser="usuário";
	$bdsenha="senha_base_dados";
	$base_dados="nome_base";
	//string de conexão, não alterar nada a partis deste ponto
	$conectar = mysqli_connect($bdhost, $bduser, $bdsenha, $base_dados);
	if (mysqli_connect_errno($conectar)) {
		echo "Erro de conexão ao servidor:" . mysqli_connect_error();
	}
?>
