<?php
include('../_connect.php');
session_start();

$id_linha = $_POST["id_enc"];

$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tracking where id_venda='$id_linha' ORDER BY id DESC"));
$id_tracking = $linha2["id_tracking_est"];


if (($id_tracking == 1) || ($id_tracking == 7)) {
	$venda = mysqli_query($lnk,"SELECT * FROM venda_prod WHERE id_venda='$id_linha'");

	foreach ($venda as $val){

		$id_produto = $val['id_produto'];

		$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM produto WHERE id='$id_produto'"));
		if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto WHERE id='$id_produto'")));}
		
		$quantidade_total = $val['quantidade'] + $quantidade;

		mysqli_query($lnk,"UPDATE produto SET quantidade='$quantidade_total' WHERE id='$id_produto'");
	}

	mysqli_query($lnk, "DELETE FROM venda WHERE id='$id_linha'");
}
else{
	mysqli_query($lnk, "DELETE FROM venda WHERE id='$id_linha'");
}



   
if($LANG=='pt'){
	$retorna['aviso'] = "Cancelada com sucesso!"; $aviso = 1;
}

if($LANG=='en'){
	$retorna['aviso'] = "Successfully canceled!"; $aviso = 1;
}


//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>