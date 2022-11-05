<?php 
	//nome do servidor para o Gerenciador, normalmente é localhost
	$bdservidor="localhost";
	// nome do usuário cadastrado no Banco de Dados
	$bdusuario="";
	// senha do usuário no Banco de Dados	
	$bdsenha="";
	// nome da base de dados a ser utilizada
	$base_dados="AS_Estoque";

	// Sistema, não altere nada a partir daqui
	$conectar = new mysqli($bdservidor, $bdusuario, $bdsenha, $base_dados);

	//$conectar = mysqli_connect($servidor, $usuario, $senha, $base_dados);
	if (mysqli_connect_errno($conectar)) {
		echo "Erro de conexão ao servidor:" . mysqli_connect_error();
		exit();

	}
	return $conectar;

?>
