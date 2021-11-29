<?php
include('../_connect.php');

$id_exist = isset($_POST['id_exist']) ? $_POST['id_exist'] : 0;
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$apelido = isset($_POST['apelido']) ? $_POST['apelido'] : '';
$morada = isset($_POST['morada']) ? $_POST['morada'] : '';
$localidade = isset($_POST['localidade']) ? $_POST['localidade'] : '';
$postal = isset($_POST['postal']) ? $_POST['postal'] : '';
$pais = isset($_POST['pais']) ? $_POST['pais'] : '';
$telemovel = isset($_POST['telemovel']) ? $_POST['telemovel'] : '';
$nome_morada = isset($_POST['nome_morada']) ? $_POST['nome_morada'] : '';

$user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id_user='$id_exist'"));

$retorna['aviso']=''; $aviso='';

if($LANG=='pt'){
	if(!$nome){$retorna['aviso'] = "Campo nome vazio!"; $aviso=1;}
	else if(!$apelido && $user['tipo_cliente']=='empresa'){$retorna['aviso'] = "Campo apelido vazio!"; $aviso=1;}
	else if(!$morada){$retorna['aviso'] = "Campo endereço vazio!"; $aviso=1;}
	else if(!$localidade){$retorna['aviso'] = "Campo localidade vazio!"; $aviso=1;}
	else if(!$postal){$retorna['aviso'] = "Campo código postal vazio!"; $aviso=1;}
	else if(!$pais){$retorna['aviso'] = "Campo país vazio!"; $aviso=1;}
	else if(!$telemovel){$retorna['aviso'] = "Campo telemóvel vazio!"; $aviso=1;}
}

if($LANG=='en'){
	if(!$nome){$retorna['aviso'] = "Empty name field!"; $aviso=1;}
	else if(!$apelido && $user['tipo_cliente']=='empresa'){$retorna['aviso'] = "Empty nickname field!"; $aviso=1;}
	else if(!$morada){$retorna['aviso'] = "Empty address field!"; $aviso=1;}
	else if(!$localidade){$retorna['aviso'] = "Locality field empty!"; $aviso=1;}
	else if(!$postal){$retorna['aviso'] = "Empty postal code field!"; $aviso=1;}
	else if(!$pais){$retorna['aviso'] = "Empty country field!"; $aviso=1;}
	else if(!$telemovel){$retorna['aviso'] = "Empty mobile phone field!"; $aviso=1;}
}


if((!$aviso)){

	if ($_COOKIE["USER"]) {
		$id_user = $_COOKIE["USER"];
	}

	
	if($id_exist){

		mysqli_query($lnk,"UPDATE user_morada SET nome='$nome',apelido='$apelido',endereco='$morada',localidade='$localidade',codigo_postal='$postal',pais='$pais',telemovel='$telemovel',nome_morada='$nome_morada' WHERE id='$id_exist'");
	}else{

		mysqli_query($lnk,"INSERT INTO user_morada (id_user, nome, apelido, endereco, localidade, codigo_postal, pais, telemovel, nome_morada) VALUES ('$id_user', '$nome', '$apelido', '$morada', '$localidade', '$postal', '$pais', '$telemovel', '$nome_morada')");
	}

	$retorna['sucesso'] = "MORADA GUARDADA COM SUCESSO!";
}

//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>