<?php
function abrirftp(){
    //nome do servidor FTP
    $server="altsolutions.tech";
    // nome do usuário do FTP e senha, definidos no provedor
    $usuario="";
    $senha="";

    //Sistema, não altere nada a partir deste ponto
    $idConexao=ftp_ssl_connect($server);    
    $resultado=ftp_login($idConexao,$usuario,$senha);
    return ($idConexao);
}
function criarImagem($var ,String $nome){
    if(strlen($var['tmp_name'])!=0){
        
        $pos=strrpos($var['name'],".")-strlen($var['name']);
        $ext = strtolower(substr($var['name'],$pos));
        $new_name = $nome.$ext;
        $destino="/public_html/gerenciador/produto/";
        $conexao=abrirftp();
        ftp_pasv($conexao, true);
        $old_name=$var;
        $caminho="http://altsolutions.tech/gerenciador/produto/$new_name";
        if(file_exists($caminho)){
           excluirImagem($conexao,$new_name);
        }
        $res=ftp_put($conexao,$destino.$new_name , $old_name['tmp_name'], FTP_BINARY);
        fecharftp($conexao);
        return $new_name;
    }else{
        
        $ext = ".jpg";
        $new_name = $nome.$ext;
        $destino="/public_html/gerenciador/produto/";
        $conexao=abrirftp();
        ftp_pasv($conexao, true);
        $arquivo="default.jpg";
        $old_name=ftp_get($conexao,$arquivo,"gerenciador/produto/default.jpg");
        $caminho="http://altsolutions.tech/gerenciador/produto/$new_name";
        if(file_exists($caminho)){
           excluirImagem($conexao,$new_name);
        }
        
        $res=ftp_put($conexao,$destino.$new_name , $arquivo, FTP_BINARY);
        fecharftp($conexao);
        return $new_name;
    }

}
function excluirImagem($conexao,String $imagem){
    $destino="/public_html/gerenciador/produto/";
    $caminho="http://altsolutions.tech/gerenciador/produto/$imagem";
    if(file_exists($caminho)){
        ftp_delete($conexao,$destino.$imagem);
    }
}

//echo ftp_pwd($idConexao);
function fecharftp($idConexao){
    ftp_close($idConexao);
}