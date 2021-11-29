<?php
include('../_connect.php');


$id = isset($_POST['id']) ? $_POST['id'] : 0;



if($id){

	mysqli_query($lnk, "DELETE FROM user_morada WHERE id='$id'");

		$retorna['sucesso'] = "MORADA APAGADA COM SUCESSO!";
}

//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>