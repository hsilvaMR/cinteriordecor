<?php
include('../../_connect.php');
session_start();

 
 function addVocuher()
{
    // $array = array('valido' , 'expirado', 'usado');

    global $lnk;
   // $today = date("yy-mm-dd");
    $nome = $_POST["nome"];
    $descricao = trim($_POST["descricao"]);
    $codigo = trim($_POST["codigo"]);
    $valor = $_POST["valor"];
    $inicio = $_POST["inicio"];
    $fim = $_POST["fim"];
    $tipo = $_POST["tipo"];
    $status = "valido";
    $response = ['error'=>'init', 'result'=>'init'];
    
    if(empty($nome) || empty($valor)  || empty($inicio) || empty($fim) || empty($codigo) ){
        
         $response['error']= "empty";
    }
    else{
        
         $query = mysqli_query($lnk, "SELECT * FROM voucher_unico WHERE codigo='$codigo' LIMIT 1");
        $row = mysqli_fetch_assoc($query);

        if (empty( $row['codigo'])) {

                 mysqli_query($lnk, "INSERT INTO voucher_unico(nome,descricao,codigo,valor,inicio,tipo,status,fim)
                  VALUES ('$nome','$descricao','$codigo','$valor','$inicio','$tipo','$status','$fim')");
                  
                $response['result']= "adicionado";
        }
        else {
        
        $response['error']= "existe";
        }
       
      
    }

    echo json_encode($response);
}

function editarVoucher()
{

    global $lnk;
}

function removerVoucher()
{
    global $lnk;
}


 function gerarVoucher()
{
    global $lnk;
    
    $query = mysqli_query($lnk,"SELECT * FROM voucher_unico ORDER BY id DESC LIMIT 1");
    $row = mysqli_fetch_assoc($query);
    $id = $row["id"];
    $tipo = $row["tipo"];
    $response = "";
    
    if(!empty($id)){
        
       $codigo = "CUPAOREF".$tipo.$id; 
       $response =  $codigo;
    }
    else{
        
        $response = "error query";
    }


    //$retorna['result']= "sucess";
    //$retorna['codigo'] = $codigo ;
    //echo json_encode($retorna);
    //$text = "hello world";
    echo  $response;
}

if (isset($_POST['call'])) {
   
    switch ($_POST['call']) {
        case 'add':
            addVocuher();
            break;
        case 'edit':
            editarVoucher();
            break;
        case 'remov':
            removerVoucher();
            break;
        case 'generate':
            gerarVoucher();
            break;
    }
}
