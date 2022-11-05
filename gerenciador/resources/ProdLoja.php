<?php
    header('Content-Type: application/json; charset= utf-8');
    include 'ControlProduto.php';
    
//buscar
    if(isset($_GET['buscar'])){
        $cp= new Control_Produto();
        $sql="SELECT * FROM Produto ";
        if(!empty($_GET['buscar'])){
            //print_r($_GET);
            $prod=$_GET['buscar'];
            
            $sql="$sql WHERE produtoID = '$prod' OR nome LIKE '%$prod%' OR categoria LIKE '%$prod%' ";
        }

       /* if(isset($_GET['ord'])){
            $ord=$_GET['ord'];
            $sql ="$sql ORDER BY $ord";

        }*/
        
        $sql=($sql);
        
        $conectar = include "conectarbd.php";
        $res=$conectar->query($sql);
        $buscou=array();
        if ($res) {
            while($busca=mysqli_fetch_row($res)){//preenche um array com os resultados da busca
                $produto= new Produto ();
                $produto->produtoID=intval($busca[0]);
                $produto->categoria=$busca[1];
                $produto->nome=$busca[2];
                $produto->descricao=$busca[3];
                $produto->imagem="$_SERVER[SERVER_NAME]/gerenciador/produto/$busca[4]";
                $produto->valorVenda=floatval($busca[5]);
                $produto->peso=floatval($busca[6]);
                $produto->prodNF=$cp->buscarProdNF($produto);
                array_push($buscou,$produto);
            }
            $resultado=array('status'=>'sucesso','dados'=>$buscou);
            
        }else{
            $resultado=array('status'=>'erro','dados'=>'Não foi possivel realizar essa busca');
        }
        
        $conectar->close();
        echo json_encode($resultado);
    }
   
    
?>