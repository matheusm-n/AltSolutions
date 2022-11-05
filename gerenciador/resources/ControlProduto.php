<?php

include 'ProdutoClasse.php';
include 'Endereco.php';

class Control_Produto {
   
    
    private $produto ;
    private $prodNF;
    private $fornecedor;
    private $endereco;
    

    //Produtos
    public function buscarProduto($var){
        $conectar = include "conectarbd.php";
        if(is_null($var)  ){ //realiza a busca sem parâmetros de Produto
            $sql=("SELECT * FROM Produto ");
        }elseif(is_string($var)){//busca realizada por informações de Produto
            $sql=("SELECT * FROM Produto WHERE produtoID = '$var' OR nome LIKE '%$var%' OR categoria LIKE '%$var%' ");
        }else{//busca um Produto específico 
            $sql=("SELECT * FROM Produto WHERE produtoID='$var->produtoID'");
        }
        $res=$conectar->query($sql);
        $buscou=array();
        while($busca=mysqli_fetch_row($res)){//preenche um array com os resultados da busca
            $produto= new Produto ();
            $produto->produtoID=intval($busca[0]);
            $produto->categoria=$busca[1];
            $produto->nome=$busca[2];
            $produto->descricao=$busca[3];
            $produto->imagem=$busca[4];
            $produto->valorVenda=floatval($busca[5]);
            $produto->peso=floatval($busca[6]);
            array_push($buscou,$produto);
        }
        $conectar->close();
        return $buscou;
        
    }
    public function inserirProduto(Produto $var){
        $conectar = include "conectarbd.php";
        include "conectarftp.php";
        //inserir novo Fornecedor
        if(isset($var)){
            if(count($this->buscarProduto($var))==0){//verifica se existe o mesmo Produto
                
            
                $res=mysqli_query($conectar,"INSERT INTO Produto ( categoria, nome, descricao, valorVenda, peso ) VALUES ('$var->categoria','$var->nome','$var->descricao','$var->valorVenda','$var->peso' )");
                
                $idProd=$this->buscarProduto($var->nome)[0]->produtoID;
                
                
                $img=criarImagem($var->imagem,$var->produtoID);
                $res=mysqli_query($conectar,"UPDATE Produto SET  imagem='$img' WHERE nome='$var->nome'");
                
                
                
                
                $conectar->close();
                return $res;

            }
            return "Produto já cadastrado";
        }
        $conectar->close();
        
    }
    public function alterarProduto(Produto $var){
        $conectar = include "conectarbd.php";
        include "conectarftp.php";
        if(isset($var)){
            $busca=$this->buscarProduto($var->nome);
            if(count($busca)!=0){
                if(!is_string($var->imagem)){
                  
                    $var->imagem=criarImagem($var->imagem,$busca[0]->produtoID);
                }
                $sql=("SELECT MAX(valorProd) FROM ProdNF WHERE produtoID='$var->produtoID' AND qtdeDisp>0");
                $res=mysqli_query($conectar,"$sql");
                $valor=$var->valorVenda;
                if(mysqli_num_rows($res)>0){
                    $nf=mysqli_fetch_row($res);
                    if($valor<(floatval($nf[0])*1.2))
                        $valor=floatval($nf[0])*1.2;
                }
                
                
                $sql="UPDATE Produto SET  categoria='$var->categoria',imagem='$var->imagem', nome='$var->nome', descricao = '$var->descricao', valorVenda='$valor', peso='$var->peso' WHERE produtoID='".$busca[0]->produtoID."'";
                
                $res=mysqli_query($conectar,"$sql");
                
                $conectar->close();
                return $res;

            }
            return "Não encontrado";
        }
    }
    public function removerProduto(Produto $var){
        $conectar = include "conectarbd.php";
        include "conectarftp.php";
        # code...
        if(isset($var)){
            $busca=$this->buscarProduto($var);
            if(count($busca)!=0){//verifica a existência do Produto a ser excluido
                $c=abrirftp();
                excluirImagem($c,$busca[0]->imagem);
                fecharftp($c);
                $sql="DELETE FROM Produto WHERE produtoID = '$var->produtoID'";
                $res=mysqli_query($conectar,"$sql");
                $conectar->close();
                return $res;

            }
            return "Não encontrado";
        }
    }

    //Fornecedores
    public function inserirFornecedor(Fornecedor $var){
        $conectar = include "conectarbd.php";
        //inserir novo Fornecedor
        if(isset($var)){
            if(count($this->buscarFornecedor($var->cnpj))==0){//verifica se existe o Fornecedor
                
            
                $res=mysqli_query($conectar,"INSERT INTO Fornecedor ( cnpj, nome, telefone, email, site ) VALUES ('$var->cnpj','$var->nome','$var->telefone','$var->email','$var->site' )");
                $res=mysqli_query($conectar,"SELECT fornecedorID FROM Fornecedor WHERE cnpj='$var->cnpj'");
                $var->endereco->id=(mysqli_fetch_row($res)[0]);
                
                $res=$this->inserirFornEndereco($var->endereco);
                
                $conectar->close();
                return $res;

            }
            return "CNPJ já cadastrado";
        }
        $conectar->close();
        
    }
    public function alterarFornecedor(Fornecedor $var){
        $conectar = include "conectarbd.php";
        # code...
        if(isset($var)){
            $busca=$this->buscarFornecedor($var->cnpj);
            if(count($busca)!=0){
                
                
                $sql="UPDATE Fornecedor SET  nome='$var->nome', telefone='$var->telefone', email = '$var->email', site='$var->site' WHERE cnpj='$var->cnpj'";
                $res=mysqli_query($conectar," $sql");
                $var->endereco->$id=$busca[0]->$fornecedorID;
                $res=alterarFornEndereco($var->endereco);
                $conectar->close();
                return $res;

            }
            return "Não encontrado";
        }
    }
    public function excluirFornecedor(Fornecedor $var){
        $conectar = include "conectarbd.php";
        # code...
        if(isset($var)){
            if(count($this->buscarFornecedor($var->cnpj))!=0){//verifica a existência do fornecedor a ser excluido
                $res=excluirFornEndereco($var->FornecedorID);
                $sql="DELETE FROM Fornecedor WHERE cnpj = '$var->cnpj'";
                $res=mysqli_query($conectar,"$sql");
                $conectar->close();
                return $res;

            }
            return "Não encontrado";
        }
    }
    public function buscarFornecedor($var){
        $conectar = include "conectarbd.php";
        //print_r($var);
        if(is_null($var) || strcmp($var,"")==0 ){ //realiza a busca sem parâmetros de Fornecedor
            $sql=("SELECT * FROM vFornecedor ");
        }elseif(is_string($var)){//busca realizada por informações de Fornecedor
            $sql=("SELECT * FROM vFornecedor WHERE fornecedorID = '$var' OR cnpj = '$var' OR nome LIKE '%$var%' ");
        }else{//busca um Fornecedor específico 
            $sql=("SELECT * FROM vFornecedor WHERE cnpj='$var->cnpj'");
        }
        $res=$conectar->query($sql);
        $buscou=array();
        if($res){
            while($busca=mysqli_fetch_row($res)){//preenche um array com os resultados da busca
                $fornecedor = new Fornecedor ();
                $endereco=new Endereco();
                $fornecedor->fornecedorID=$busca[0];
                $fornecedor->cnpj=$busca[1];
                $fornecedor->nome=$busca[2];
                $fornecedor->telefone=$busca[3];
                $fornecedor->email=$busca[4];
                $fornecedor->site=$busca[5];
                $endereco->cep=$busca[6];
                $endereco->num=$busca[7];
                $endereco->complemento=$busca[8];
                $endereco->endereco=$busca[9];
                $endereco->cidade=$busca[10];
                $endereco->bairro=$busca[11];
                $endereco->UF=$busca[12];
                $endereco->id=$fornecedor->fornecedorID;
                array_push($buscou,$fornecedor);
                
            }
        }
        
        $conectar->close();
        return $buscou;
       
    }
    
    public function alterarFornEndereco(Endereco $var){
        $conectar = include "conectarbd.php";
        
        if(isset($var)){
            $sql="UPDATE EnderecoF SET  CEP='$var->', num='$var->', complemento = '$var->' WHERE fornecedorID='$var->id'";
            $res=mysqli_query($conectar," $sql");
            $conectar->close();
            return $res;            
        }
    }
    public function inserirFornEndereco(Endereco $var){
        $conectar = include "conectarbd.php";
        //inserir novo Endereço do Fornecedor
        if(isset($var)){
            
            $res=mysqli_query($conectar,"SELECT fornecedorID FROM EnderecoF WHERE fornecedorID='$var->id'");
            
            if(is_null(mysqli_fetch_row($res))){//verifica se existe o Endereco
                $res=mysqli_query($conectar,"INSERT INTO EnderecoF ( fornecedorID, CEP, num, complemento ) VALUES ('$var->id','$var->cep','$var->num','$var->complemento')");
                
                $conectar->close();
                return $res;
            }
            return "Id já cadastrado";
        }
        $conectar->close();
    }
    public function excluirFornEndereco(String $var){
        $conectar = include "conectarbd.php";
        # code...
        if(isset($var)){
                $sql="DELETE FROM EnderecoF WHERE fornecedorID = '$var'";
                $res=mysqli_query($conectar,"$sql");
                $conectar->close();
                return $res;
            return "Não encontrado";
        }
    }
    //Estoque de Produtos
    public function inserirProdNF(ProdNF $var){
        $conectar = include "conectarbd.php";
        include "conectarftp.php";
        //inserir nova NF
        if(isset($var)){
            $busca=mysqli_query($conectar,"SELECT * FROM ProdNF WHERE numeroNF='$var->numeroNF' AND produtoID='$var->produtoID'");
            //lembrar de alterar produto
            if($busca->num_rows==0){//verifica se existe o mesma NF
                $var->dataNF=date("Ymd");
                
                $res=mysqli_query($conectar,"INSERT INTO ProdNF ( fornecedorID, produtoID, numeroNF, dataNF, qtdeNF, valorProd, qtdeDisp ) VALUES ('$var->fornecedorID','$var->produtoID','$var->numeroNF','$var->dataNF','$var->qtdeNF' ,'$var->valorProd','$var->qtdeDisp' )");
                $sql="SELECT valorVenda FROM Produto WHERE produtoID='$var->produtoID'";
                $res=mysqli_query($conectar,$sql);
                $r=mysqli_fetch_row($res);
                if($r[0]<(1.2*$var->valorProd)){
                    $valor=1.2*$var->valorProd;
                    $sql="UPDATE Produto SET valorVenda='$valor' WHERE produtoID='$var->produtoID'";
                    $res=mysqli_query($conectar,$sql);
                }

                $conectar->close();
                return $res;

            }
            return "NF já cadastrado";
        }
        $conectar->close();
        
    }
    public function alterarProdNF(ProdNF $var){
        $conectar = include "conectarbd.php";
        # code...
        if(isset($var)){
            $busca=$this->buscarFornecedor($var->numeroNF);
            if(count($busca)!=0){
                
                
                $sql="UPDATE ProdNF SET  qtdeDisp='$var->qtdeDisp', WHERE numeroNF='$var->numeroNF'";
                $res=mysqli_query($conectar," $sql");
                $var->endereco->$id=$busca[0]->$fornecedorID;
                $res=alterarFornEndereco($var->endereco);
                $conectar->close();
                return $res;

            }
            return "NF não encontrado";
        }
    }
    public function excluirProdNF(ProdNF $var){
        $conectar = include "conectarbd.php";
        # code...
        if(isset($var)){
            if(count($this->buscarFornecedor($var->numeroNF))!=0){//verifica a existência do fornecedor a ser excluido
                $sql="DELETE FROM ProdNF WHERE numeroNF = '$var->numeroNF'";
                $res=mysqli_query($conectar,"$sql");
                $conectar->close();
                return $res;

            }
            return "Não encontrado";
        }
    }
    public function buscarProdNF($var){
        $conectar = include "conectarbd.php";
        if(is_string($var)){
            $sql=("SELECT * FROM ProdNF WHERE numeroNF='$var'");
        }else{
            $sql=("SELECT * FROM ProdNF WHERE produtoID='$var->produtoID' order by dataNF asc");
        }
        $res=$conectar->query($sql);
        $buscou=array();
        while($busca=mysqli_fetch_row($res)){//preenche um array com os resultados da busca
            $prodNF= new ProdNF ();
            $prodNF->fornecedorID=intval($busca[0]);
            $prodNF->produtoID=intval($busca[1]);
            $prodNF->numeroNF=$busca[2];
            $prodNF->dataNF=$busca[3];
            $prodNF->qtdeNF=$busca[4];
            $prodNF->valorProd=floatval($busca[5]);
            $prodNF->qtdeDisp=intval($busca[6]);
            
            array_push($buscou,$prodNF);
        }
        $conectar->close();
        return $buscou;
    }
    public function disponibilidadeProduto(String $produtoId){
        $conectar = include "conectarbd.php";
        if(isset($produtoId)){
        
            $sql=("SELECT * FROM vDisponibilidade WHERE produtoID='$produtoId'");
        
            $res=$conectar->query($sql);
            $busca=NULL;
            if($res)
                $busca=mysqli_fetch_row($res);//preenche um array com os resultados da busca
            
            
            
              
            
            $conectar->close();
            if(is_null($busca))
                return 0;
            return $busca[1];
        }
    }
    public function forneceProduto(String $produtoId){
        if(isset($produtoId)){
            $conectar = include "conectarbd.php";
            
            $sql=("SELECT * FROM vForneceProd WHERE produtoID='$produtoId'");
            
            $res=$conectar->query($sql);
            $buscou=array();
            while($busca=mysqli_fetch_row($res)){//preenche um array com os resultados da busca
      
                array_push($buscou,$busca[0]);//retorna ids de Fornecedores
            }
            $conectar->close();
            return $buscou;
        }
    }
    public function retiraEstoque (String $produtoID,Int $quantidade){
        if(isset($produtoId)&&isset($quantidade)){
            if($this->disponibilidadeProduto($produtoId)>=$quantidade){
                $p=new Produto();
                $p->produtoID=$produtoID;
                $prodNF=$this->buscarProdNF($p);
                for($i=0;$quantidade>0;$i++){
                    if($quantidade>$prodNF[$i]->qtdeDisp){
                        $prodNF[$i]->qtdeDisp-=$quantidade;
                    }else{
                        $quantidade-=$prodNF[$i]->qtdeDisp;
                        $prodNF[$i]->qtdeDisp=0;
                    }
                    alterarProdNF($prodNF[$i]);
                }
            }
        }
    }
    public function ultimoProdutoID(){
        
            $conectar = include "conectarbd.php";
            
            $sql=("SELECT Max(produtoID) FROM Produto ");
            
            $res=$conectar->query($sql);
            
            $busca=mysqli_fetch_row($res);
             
            $conectar->close();
            return $busca[0]+1;
        
    }
    public function ultimoFornecedorID(){
        
        $conectar = include "conectarbd.php";
        
        $sql=("SELECT Max(fornecedorID) FROM Fornecedor ");
        
        $res=$conectar->query($sql);
        
        $busca=mysqli_fetch_row($res);
         
        $conectar->close();
        if(!($busca))
            return 1;
        return ($busca[0]+1);
    
    }
    public function buscarCep(String $var){
        $conectar = include "conectarbd.php";
        if(!is_null($var) || strlen($var)!=0 ){ 
            $sql=("SELECT CEP,ENDERECO,CIDADE,BAIRRO,UF FROM tCEP WHERE CEP='$var'");
        }
        $res=$conectar->query($sql);
        
        $busca=mysqli_fetch_row($res);
        $endereco= new Endereco ();
        //print_r($res);
        if(is_null($busca)){
            $endereco->cep=$var;
            $endereco->endereco="";
            $endereco->cidade="";
            $endereco->bairro="";
            $endereco->uf="";
            
            
        }else{
            $endereco->cep=$busca[0];
            $endereco->endereco=$busca[1];
            $endereco->cidade=$busca[2];
            $endereco->bairro=$busca[3];
            $endereco->uf=$busca[4];
        }
        $conectar->close();
        return $endereco;
        
    }
    
    
}
