<?php
	header('Content-Type: application/json; charset= utf-8');
	function calcula_frete($cep, $peso) {
	$cepDigito = substr($cep,0,1);

	// se Digito == 0, então é SP (frete mais barato)
	if ($cepDigito == "0"){
		$valorFrete = 10;
		if($peso <= 2)
			$valorFrete += sqrt($peso) + 10;
		elseif ($peso <=5)
			$valorFrete += sqrt($peso) + 15;
		else
			$valorFrete += sqrt($peso) + 25;
		return  round($valorFrete,2);
	}else{
		$valorFrete = 30;
		if($peso <= 2)
			$valorFrete += sqrt($peso) + 5;
		elseif ($peso <=5)
			$valorFrete += sqrt($peso) + 14.5;
		else
			$valorFrete += sqrt($peso) + 25;
		return  round($valorFrete,2);
	}
}
function geraFrete($endereco, $peso) {
	calcula_frete($endereco->cep,$peso);
	
	//retorna frete 

}
//valida no post
//echo json_encode(json_decode($_POST));

print_r($_GET);
if(isset($_GET['calc'])){
	$res="";
	if(isset($_GET['cep']) && isset($_GET['peso']) && floatval($_GET['peso'])>0)
		$res=array('preco'=>calcula_frete($_GET['cep'],floatval($_GET['peso'])));
	else
		$res=array('preco'=>-1);
	echo json_encode($res);
}
?>