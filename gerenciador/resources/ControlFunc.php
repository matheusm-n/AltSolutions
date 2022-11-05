<?php

include "Funcionario.php";


class ControlFunc {
    
    public $func;
    public function buscarFunc($var){  
        $conectar = include "conectarbd.php";
        if(is_null($var) || (is_string($var) && strlen($var)==0) ){ //realiza a busca sem parâmetros de Funcionários
            $sql=("SELECT * FROM Funcionario ");
        }elseif(is_string($var)){//busca realizada por informações de Funcionário
            $sql=("SELECT * FROM Funcionario WHERE usuarioID = '$var' OR funcCPF = '$var' OR nomeFunc LIKE '%$var%' ");
        }else{//busca um Funcionário específico 
            $sql=("SELECT * FROM Funcionario WHERE usuarioID='$var->idFunc'");
        }
        $res=$conectar->query($sql);
        $buscou=array();
        while($busca=mysqli_fetch_row($res)){//preenche um array com os resultados da busca
            $func =new Funcionario;
            $func->idFunc=$busca[0];
            $func->cpfFunc=$busca[1];
            $func->nomeFunc=$busca[2];
            $func->senhaFunc=$busca[3];
            $func->relatTotal=$busca[4];
            $func->estoque=$busca[5];
            $func->admContas=$busca[6];
            array_push($buscou,$func);
        }
        $conectar->close();
        return $buscou;
        //return $res;
        
    }
    public function inserirFunc(Funcionario $var){
        $conectar = include "conectarbd.php";
        //inserir novo Funcionário
        
        if(isset($var)){
            if(count($this->buscarFunc($var->cpfFunc))==0){//verifica se existe o Funcionário
                $var->senhaFunc=password_hash($var->cpfFunc,PASSWORD_BCRYPT);
            
                $res=mysqli_query($conectar,"INSERT INTO Funcionario (  funcCPF, nomeFunc, senhaFunc, relatTotal, estoque, admContas) VALUES ('$var->cpfFunc','$var->nomeFunc','$var->senhaFunc','$var->relatTotal','$var->estoque','$var->admContas' )");
                $conectar->close();
                return $res;

            }
            return "CPF cadastrado";
        }
        $conectar->close();
    }
    public function atualizarFunc(Funcionario $var){
        $conectar = include "conectarbd.php";
        # code...
        if(isset($var)){
            $busca=$this->buscarFunc($var->cpfFunc);
            if(count($busca)!=0){
                $sql="";
                if(strcmp($var->senhaFunc,$busca[0]->senhaFunc)!=0){//verifica se senha foi alterada
                    if(strlen($var->senhaFunc)==0){//verificação para redefinição
                        $var->senhaFunc=$var->cpfFunc;
                    }
                    $var->senhaFunc=password_hash($var->senhaFunc,PASSWORD_BCRYPT);
                    $sql="senhaFunc='$var->senhaFunc',";
                }
                $sql="UPDATE Funcionario SET $sql relatTotal='$var->relatTotal', estoque='$var->estoque', admContas = '$var->admContas' WHERE funcCPF='$var->cpfFunc'";
                $res=mysqli_query($conectar," $sql");
                
                $conectar->close();
                return $res;

            }
            return "Não encontrado";
        }
        
    }
    public function removerFunc(Funcionario $var){
        $conectar = include "conectarbd.php";
        # code...
        if(isset($var)){
            if(count($this->buscarFunc($var->cpfFunc))!=0){//verifica a existência do funcionário a ser excluido
                
                $sql="DELETE FROM Funcionario WHERE funcCPF = '$var->cpfFunc'";
                $res=mysqli_query($conectar,"$sql");
                $conectar->close();
                return $res;

            }
            return "Não encontrado";
        }
        
    }
 
    
}
