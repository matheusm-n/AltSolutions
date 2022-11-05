<?php
function criarImagem($var ,String $nome){
    if(isset($var)){ //passa $_FILES['pic'] e o nome da imagem como parâmetro
        $pos=strrpos($var['name'],".")-strlen($var['name']);
        $ext = strtolower(substr($var['name'],$pos));
        $new_name = $nome.$ext;
        $destino="/produto/";
        
        $imagem=$var;
        $caminho="/produto/$new_name";
        if(file_exists($caminho)){
           excluirImagem($new_name);
        }
        move_uploaded_file($imagem['tmp_name'], $destino.$new_name);
        
        
    }

    function excluirImagem(String $imagem){
        //passa nome da imagem como parâmetro
        $destino="/produto/";
        $caminho="/produto/$imagem";
        if(file_exists($caminho)){
            unlink($caminho);
        }
    }
}