<?php
include('../../_connect.php');
session_start();

$id = $_POST["id"];
$nome = trim($_POST["nome"]);
$nome = str_replace("'", "′", $nome);
$nome = str_replace("\"", "“", $nome);
$valor = trim($_POST["valor"]);
$valor = filter_var($valor, FILTER_VALIDATE_INT);
$tipo = 'percentagem';
$categoria = $_POST["categoria"];
$produtos = $_POST["produtos"];
$inicio = $_POST["inicio"];
$fim = $_POST["fim"];
$countdown = trim($_POST["countdown"]);

//echo "$id \n $titulo \n $img";

if($id || $nome || $valor){
	if($id){
		mysqli_query($lnk,"UPDATE promocao SET nome='$nome',valor='$valor',tipo='$tipo',produtos='$produtos',categoria='$categoria',inicio='$inicio',fim='$fim',countdown='$countdown' WHERE id='$id'");
	}
	else{
		mysqli_query($lnk, "INSERT INTO promocao(nome,valor,tipo,produtos,categoria,inicio,fim,countdown) VALUES ('$nome','$valor','$tipo','$produtos','$categoria','$inicio','$fim','$countdown')");
		$id = mysqli_insert_id($lnk);
	}
}
echo $id;
?>