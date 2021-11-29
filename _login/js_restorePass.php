<?php
include('../_connect.php');
session_start();


$token = isset($_POST['token']) ? strtolower($_POST['token']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';


$retorna['aviso']=''; $aviso='';


$existe = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user_password WHERE token = '$token'"));
if($existe)
{
	$email = $existe['email'];

	if ($password != '') {
		$pass_hash = password_hash($password, PASSWORD_DEFAULT);
		mysqli_query($lnk,"UPDATE user SET password='$pass_hash' WHERE email='$email'");

		mysqli_query($lnk, "DELETE FROM user_password WHERE email='$email'");

		$retorna['aviso']='SUCESSO'; $aviso=1;
	}else{
		if($LANG=='pt'){
			$retorna['aviso'] = "Campo password vazio."; $aviso=1;
		}

		if($LANG=='en'){
			$retorna['aviso'] = "Empty password field"; $aviso=1;
		}
	}

	
}else{

	if($LANG=='pt'){
		$retorna['aviso'] = "Não existe pedido de alteração de password."; $aviso=1;
	}

	if($LANG=='en'){
		$retorna['aviso'] = "There is no request to change the password."; $aviso=1;
	}
}
   
	


//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>