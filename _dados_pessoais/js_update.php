<?php
include('../_connect.php');

$id_user = isset($_POST['id_user']) ? $_POST['id_user'] : 0;
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$apelido = isset($_POST['apelido']) ? $_POST['apelido'] : '';
$email = isset($_POST['email']) ? strtolower($_POST['email']) : '';
$contacto = isset($_POST['contacto']) ? strtolower($_POST['contacto']) : '';
$nif = isset($_POST['nif']) ? strtolower($_POST['nif']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$password_new = isset($_POST['password_new']) ? $_POST['password_new'] : '';
$confirmacao = isset($_POST['confirmacao']) ? $_POST['confirmacao'] : '';
$tipo_cliente = isset($_POST['tipo_cliente']) ? $_POST['tipo_cliente'] : '';




$retorna['aviso']=''; $aviso='';

if($LANG=='pt'){

	if(!$confirmacao){$retorna['aviso'] = "Campo confirmação vazio! Escreva confirmação para confirmar as alterações."; $aviso=1;}
	else if(!$nome){$retorna['aviso'] = "Campo nome vazio!"; $aviso=1;}
	else if((!$apelido) && ($tipo_cliente == 'cliente')){$retorna['aviso'] = "Campo apelido vazio!"; $aviso=1;}
	if(!$email){$retorna['aviso'] = "Campo email vazio!"; $aviso=1;}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $retorna['aviso'] = "Email inválido, introduza um email válido!"; $aviso=1;}
	else if (!$contacto){$retorna['aviso'] = "Campo contacto vazio!"; $aviso=1;}
	else if (!$nif){$retorna['aviso'] = "Campo NIF ou NIPC vazio!"; $aviso=1;}
	else if((!empty($password_new)) && (strlen($password_new) < 8)){$retorna['aviso'] = "Password inválida!"; $aviso=1;}
}

if($LANG=='en'){

	if(!$confirmacao){$retorna['aviso'] = "Confirmation field empty! Write confirmation to confirm the changes."; $aviso=1;}
	else if(!$nome){$retorna['aviso'] = "Empty name field!"; $aviso=1;}
	else if((!$apelido) && ($tipo_cliente == 'cliente')){$retorna['aviso'] = "Empty nickname field!"; $aviso=1;}
	if(!$email){$retorna['aviso'] = "Empty email field!"; $aviso=1;}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $retorna['aviso'] = "Invalid email, please enter a valid email!"; $aviso=1;}
	else if (!$contacto){$retorna['aviso'] = "Empty contact field!"; $aviso=1;}
	else if (!$nif){$retorna['aviso'] = "Empty NIF or VAT field!"; $aviso=1;}
	else if((!empty($password_new)) && (strlen($password_new) < 8)){$retorna['aviso'] = "Invalid password!"; $aviso=1;}
}


if((!$aviso)){

	if($id_user){
		$pass_hash = $password;
		if ($password != $password_new) {
			$pass_hash = password_hash($password_new, PASSWORD_DEFAULT);
		}
		
		mysqli_query($lnk,"UPDATE user SET nome='$nome',apelido='$apelido',nif='$nif',contacto='$contacto',email='$email',password='$pass_hash' WHERE id='$id_user'");
	}

	$retorna['sucesso'] = "DADOS GUARDADOS COM SUCESSO!";
}

//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>