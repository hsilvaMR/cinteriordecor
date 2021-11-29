<?php
include('../_connect.php');
session_start();


$mail = isset($_POST['mail']) ? strtolower($_POST['mail']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';


$retorna['aviso']=''; $aviso='';


if($LANG=='pt'){
	if(!$mail){$retorna['aviso'] = "Campo email vazio!"; $aviso=1;}
	else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) { $retorna['aviso'] = "Email inválido, introduza um email válido!"; $aviso=1;}
	else if(!$password){$retorna['aviso'] = "Campo password vazio!"; $aviso=1;}
	else if(strlen($password) < 8){$retorna['aviso'] = "Password inválida!"; $aviso=1;}
}

if($LANG=='en'){
	if(!$mail){$retorna['aviso'] = "Empty email field!"; $aviso=1;}
	else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) { $retorna['aviso'] = "Invalid email, please enter a valid email!"; $aviso=1;}
	else if(!$password){$retorna['aviso'] = "Empty password field!"; $aviso=1;}
	else if(strlen($password) < 8){$retorna['aviso'] = "Invalid password!"; $aviso=1;}
}


if((!$aviso)){
	
	$existe = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE email = '$mail'"));
	if(!$existe)
	{
		if($LANG=='pt'){
			$retorna['aviso'] = "Este email não tem conta associada. Crie uma nova conta."; $aviso=1;
		}

		if($LANG=='en'){
			$retorna['aviso'] = "This email has no associated account. Create a new account."; $aviso=1;
		}
	
	}else{
		
		if(!password_verify($password, $existe['password'])){
			if($LANG=='pt'){
				$retorna['aviso'] = "Password inválida!"; $aviso=1;
			}

			if($LANG=='en'){
				$retorna['aviso'] = "Invalid password!"; $aviso=1;
			}
		}
		else{

			//criar cookie se sessão
			$id_user = $existe['id'];
			$nome = $existe['nome'];
			$apelido = $existe['apelido'];


			//createCookie('USER',$id_user,1);
			//setcookie("USER", $id_user);
			
			$data = date('Y-m-d');
			mysqli_query($lnk,"UPDATE user SET ultimo_acesso='$data' WHERE id='$id_user'");
			$_SESSION['user_session'] = $id_user;
			$retorna['id_user'] = $id_user;
		}
	}
   
	
}

//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>