<?php
include('../../_connect.php');
$array	= $_POST['linha'];
$tabela = $_POST['tabela'];
$campo = $_POST['campo'];

$count = 1;
foreach ($array as $idval) {
	mysqli_query($lnk,"UPDATE $tabela SET $campo='$count' WHERE id='$idval'");
	$count ++;	
}
?>