<?php
include('../../_connect.php');
session_start();

$jsonReceiveData = json_encode($_POST);
$jsonIterator = new RecursiveIteratorIterator(new RecursiveArrayIterator(json_decode($jsonReceiveData, TRUE)),RecursiveIteratorIterator::SELF_FIRST);

$valores = array();
foreach ($jsonIterator as $key => $val)
{
   if(is_array($val)) { foreach($val as $key1 => $val1) { $valores[$key][$key1] = $val1; } }
   else { $valores[$key] = $val; }
}

$email = $valores['email'];
$email = trim($email);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);

if($email){
	$login = mysqli_query($lnk,"SELECT * FROM admin WHERE email = '$email'");
	$num_util = mysqli_num_rows($login);
	if($num_util == 1)
	{
		$linha = mysqli_fetch_array($login);
		$nome = $linha['nome'];
		$password = $linha['password'];

		$para = $nome." <".$email.">";
		$paraEmail = $email;
		$paraNome = $nome;
		$De = "Admin <tmendes@mredis.com>";
		$Cc = "";
		$CcOculto = "";
		$respPara = "";

		$assunto = "Recuperar Password";
		$mensagem = '
		<html>
		<head>
		 <title>'.$assunto.'</title>
		 <style>*{font-size:14px;}</style>
		</head>
		<body>
		<p>Ola '.$nome.'!</p>
		<table height="60">
			<tr>
				<th colspan="2" align="left">Dados de Login</th>
			</tr>
			<tr>
				<td>Email: </td><td>'.$email.'</td>
			</tr>
			<tr>
				<td>Password: </td><td>'.$password.'</td>
			</tr>
		</table>
		<p>Melhores Cumprimentos</p>
		<br><hr>
		
		</body>
		</html>
		';

		include('../funcao/email.php');
	}
	else { $retorna = "Email inexistente.";}
}else{ $retorna = "Insira corretamente o email."; }

//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>