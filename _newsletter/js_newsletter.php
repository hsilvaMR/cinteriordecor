<?php
include('../_connect.php');
session_start();
/*
$jsonReceiveData = json_encode($_POST);
$jsonIterator = new RecursiveIteratorIterator(new RecursiveArrayIterator(json_decode($jsonReceiveData, TRUE)),RecursiveIteratorIterator::SELF_FIRST);

$valores = array();
foreach ($jsonIterator as $key => $val)
{
   if(is_array($val)) { foreach($val as $key1 => $val1) { $valores[$key][$key1] = $val1; } }
   else { $valores[$key] = $val; }
}
$email = isset($valores['email']) ? $valores['email'] : '';
*/

$email = isset($_POST['email']) ? strtolower($_POST['email']) : '';

if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    //O e-mail está bom
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM newsletter WHERE email = '$email'"));
	if(!$existe)
	{
		$data = date('Y-m-d');
		mysqli_query($lnk,"INSERT INTO newsletter (email, data) VALUES ('$email', '$data')");
	}
    $retorna = "TM";
}else{ $retorna = "ERRO"; }

//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>