<?php 
    //$path = explode('/', $_GET['path'] );
    
    include 'ControlProduto.php';
    $cp=new Control_Produto();
    $prod=$cp->buscarProduto(NULL);
    
    $produtos=json_encode($prod);
   // print_r($produtos);
   //print_r(json_decode('{"busca":"","tipo":"","ordem":""}'));
    print_r(json_encode(((object)array('0'=>'bla','1'=>'preço','2'=>'asc'))));
   // print_r(json_decode($_GET['buscar']));
   // $method=$_SERVER['REQUEST_METHOD'];
    header('Content-type: application/json; charset= utf-8');
    //$body=file_get_contents('php://input');
   // if ($method == 'GET') {
        
    //}
?>
