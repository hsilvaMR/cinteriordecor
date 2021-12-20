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
    $response = ['error' => 'init', 'result' => 'init'];

    if (empty($nome) || empty($valor)  || empty($inicio) || empty($fim) || empty($codigo)) {

        $response['error'] = "empty";
    } else {

        $query = mysqli_query($lnk, "SELECT * FROM voucher_unico WHERE codigo='$codigo' LIMIT 1");
        $row = mysqli_fetch_assoc($query);

        if (empty($row['codigo'])) {

            mysqli_query($lnk, "INSERT INTO voucher_unico(nome,descricao,codigo,valor,inicio,tipo,status,fim)
                  VALUES ('$nome','$descricao','$codigo','$valor','$inicio','$tipo','$status','$fim')");

            $response['result'] = "adicionado";
        } else {

            $response['error'] = "existe";
        }
    }

    echo json_encode($response);
}

function editarVoucher()
{

    global $lnk;
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $descricao = trim($_POST["descricao"]);
    $codigo = trim($_POST["codigo"]);
    $valor = $_POST["valor"];
    $inicio = $_POST["inicio"];
    $fim = $_POST["fim"];
    $tipo = $_POST["tipo"];
    $status = "valido";
    $response = ['error' => 'init', 'result' => 'init', 'id' => 'init'];

    if (empty($nome) || empty($valor)  || empty($inicio) || empty($fim) || empty($codigo)) {

        $response['error'] = "empty_field";
    } else {

        if ($id) {

            mysqli_query($lnk, "UPDATE voucher_unico SET nome='$nome',descricao='$descricao',codigo='$codigo',valor='$valor',inicio='$inicio',tipo='$tipo',status='$status',fim='$fim' WHERE id='$id'");
            $id = mysqli_insert_id($lnk);
            $response['result'] = "update";
            $response['id'] = $id;
        } else {

            $response['error'] = "empty_id";
        }
    }

    echo json_encode($response);
}

function removerVoucher()
{
    global $lnk;
    $id_del = $_POST["id_del"];

    $response = [
        'error' => 'init',
        'result' => 'init',
        'id' => 'init',

    ];

    if ($id_del) {
        mysqli_query($lnk, "DELETE FROM voucher_unico WHERE id='$id_del'");
        $response['result'] = "delete";
        //$response['id'] = $id_del;
    } else {
        $response['error'] = "empty";
    }

    echo json_encode($response);
}

function gerarVoucher()
{
    global $lnk;

    $query = mysqli_query($lnk, "SELECT * FROM voucher_unico ORDER BY id DESC LIMIT 1");
    $row = mysqli_fetch_assoc($query);
    $id = $row["id"];

    // PHP - Random Character Generator REF:  https://www.youtube.com/watch?v=ALWBgCzc4kk
    $char = "ABCDEFGHIJKLMNOPQRSTUVXZabcdefghijklmnopqrstuvxz0123456789$%&&&";
    $token = substr(str_shuffle($char), 0, 8);

    $response = "";

    if (!empty($id)) {

        $codigo = "REF#" . $token . $id;
        $response =  $codigo;
    } else {

        $id = 01;
        $codigo = "REF#" . $token . $id;
        $response =  $codigo;
    }

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
        case 'delete':
            removerVoucher();
            break;
        case 'generate':
            gerarVoucher();
            break;
    }
}
