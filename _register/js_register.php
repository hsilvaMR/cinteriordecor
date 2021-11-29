<?php
include('../_connect.php');

$check_particular = isset($_POST['check_particular']) ? $_POST['check_particular'] : 0;
$check_company = isset($_POST['check_company']) ? $_POST['check_company'] : 0;
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$apelido = isset($_POST['apelido']) ? $_POST['apelido'] : '';
$check_priv = isset($_POST['check_priv']) ? $_POST['check_priv'] : 0;
$check_desc = isset($_POST['check_desc']) ? $_POST['check_desc'] : 0 ;
$mail = isset($_POST['mail']) ? strtolower($_POST['mail']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';


$retorna['aviso']=''; $aviso='';


if($LANG=='pt'){
	if((!$nome) && ($check_particular==1)){$retorna['aviso'] = "Campo nome vazio!"; $aviso=1;}
	else if((!$nome) && ($check_company==1)){$retorna['aviso'] = "Campo nome da empresa vazio!"; $aviso=1;}
	else if((!$apelido) && ($check_particular==1)){$retorna['aviso'] = "Campo apelido vazio!"; $aviso=1;}
	else if(!$mail){$retorna['aviso'] = "Campo email vazio!"; $aviso=1;}
	else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) { $retorna['aviso'] = "Email inválido, introduza um email válido!"; $aviso=1;}
	else if(!$password){$retorna['aviso'] = "Campo password vazio!"; $aviso=1;}
	else if(strlen($password) < 8){$retorna['aviso'] = "Password inválida!"; $aviso=1;}
	else if($check_priv == 0){$retorna['aviso'] = "Tem de aceitar a \"Política de Privacidade\"."; $aviso=1;}
}

if($LANG=='en'){
	if((!$nome) && ($check_particular==1)){$retorna['aviso'] = "Empty name field!"; $aviso=1;}
	else if((!$nome) && ($check_company==1)){$retorna['aviso'] = "Empty company name field"; $aviso=1;}
	else if((!$apelido) && ($check_particular==1)){$retorna['aviso'] = "Empty nickname field!"; $aviso=1;}
	else if(!$mail){$retorna['aviso'] = "Empty email field!"; $aviso=1;}
	else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) { $retorna['aviso'] = "Invalid email, please enter a valid email!"; $aviso=1;}
	else if(!$password){$retorna['aviso'] = "Empty password field!"; $aviso=1;}
	else if(strlen($password) < 8){$retorna['aviso'] = "Invalid password!"; $aviso=1;}
	else if($check_priv == 0){$retorna['aviso'] = "You must accept the \"Privacy Policy\"."; $aviso=1;}
}


if((!$aviso)){
	
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user WHERE email = '$mail'"));
	if(!$existe)
	{	
		$tipo_cliente = 'empresa';
		if ($check_particular == 1) {
			$tipo_cliente = 'cliente';
		}
		
		//Cria
		$data = date('Y-m-d');
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
	    $randomString = ''; 
	    for ($i = 0; $i <= 12; $i++) { 
	        $index = rand(0, strlen($characters) - 1); 
	        $randomString .= $characters[$index]; 
	    } 
		$token = $randomString;

		
		$pass_hash = password_hash($password, PASSWORD_DEFAULT);

		mysqli_query($lnk,"INSERT INTO user (nome, apelido, tipo_cliente, email, password, token, data_registo, check_descontos) VALUES ('$nome', '$apelido','$tipo_cliente', '$mail', '$pass_hash', '$token', '$data', '$check_desc')");

		$retorna['sucesso'] = "Dados guardados com sucesso!";




	
	}else{
		if($LANG=='pt'){
			$retorna['aviso'] = "Este email já tem conta associada. Inicie Sessão."; $aviso=1;
		}

		if($LANG=='en'){
			$retorna['aviso'] = "This email already has an associated account. Sign in."; $aviso=1;
		}
	
	}
   
	
}

//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>