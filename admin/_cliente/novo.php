<?php
include('../../_connect.php');
session_start();

$id = $_POST["id"];
$nome = mysqli_real_escape_string($lnk,trim($_POST["nome"]));
$apelido = mysqli_real_escape_string($lnk,trim($_POST["apelido"]));
$email = $_POST['email'];
$email = trim($email);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
$nif = mysqli_real_escape_string($lnk,trim($_POST["nif"]));
$tipo_cliente = mysqli_real_escape_string($lnk,trim($_POST["tipo_cliente"]));
$check_descontos = mysqli_real_escape_string($lnk,trim($_POST["check_descontos"]));
$contacto = mysqli_real_escape_string($lnk,trim($_POST["contacto"]));
$estado = mysqli_real_escape_string($lnk,trim($_POST["estado"]));

//echo "$id \n $nome";


$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user WHERE email = '$email' AND id <> '$id'"));
$retorna = '';
if ($existe == 1) {
	
	$retorna = 'ERRO';
}else{
	
	if($id){
		mysqli_query($lnk,"UPDATE user SET nome='$nome', apelido='$apelido', nif='$nif', contacto='$contacto', tipo_cliente='$tipo_cliente', email='$email', check_descontos='$check_descontos', estado='$estado'  WHERE id='$id'");
	}
	else{
		mysqli_query($lnk, "INSERT INTO user(nome, apelido, nif, contacto, tipo_cliente, email, check_descontos, estado) VALUES ('$nome', '$apelido', '$nif', '$contacto', '$tipo_cliente', '$email', '$check_descontos', '$estado')");
		$id = mysqli_insert_id($lnk);
	}
	
	$retorna = $id;
}
echo json_encode($retorna);

?>