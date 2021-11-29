<?php
include('../_connect.php');
session_start();


$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
$id_encomenda = isset($_POST['id_encomenda']) ? $_POST['id_encomenda'] : '';


$retorna['aviso']=''; $aviso='';

$existe = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM venda_avaliacao WHERE id_venda = '$id_encomenda'"));
$id_tracking_est = 8;
$data = date('Y-m-d');

$existe_track = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tracking WHERE id_venda = '$id_encomenda' AND id_tracking_est = '$id_tracking_est'"));
if($existe)
{
	$id = $existe['id'];
	mysqli_query($lnk,"UPDATE venda_avaliacao SET avaliacao='$tipo', data='$data' WHERE id='$id'");	
}else{
	mysqli_query($lnk,"INSERT INTO venda_avaliacao (id_venda, avaliacao, data) VALUES ('$id_encomenda', '$tipo','$data')");
}

if (!$existe_track){
	mysqli_query($lnk,"INSERT INTO tracking (id_venda, id_tracking_est, data) VALUES ('$id_encomenda', '$id_tracking_est','$data')");
}
   
if($LANG=='pt'){
	$retorna['aviso'] = "Obrigado pela sua avaliação!"; $aviso = 1;
}

if($LANG=='en'){
	$retorna['aviso'] = "Thank you for your rating!"; $aviso = 1;
}


//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>