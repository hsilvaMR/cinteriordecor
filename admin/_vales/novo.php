<?php
include('../../_connect.php');
session_start();

$id = $_POST["id"];

$nome = trim($_POST["nome"]);
$codigo = trim($_POST["codigo"]);
$inicio = $_POST["inicio"];
$fim = $_POST["fim"];


$oferta = $_POST["oferta"];
$descricao = $_POST["descricao"];

if($oferta == 'acima_de'){
	$valor_condicao = $_POST["codigo_acima"];
	$oferta_opcao = $_POST["oferta_opcao"];

	if ($oferta_opcao == 'desconto_perc_acima') {
		$valor_desconto = $_POST["desc_Acima"];
	}else{
		$valor_desconto = '';
		$gratis = 1;
	}
}elseif ($oferta == 'desconto_perc') {
	$valor_desconto = $_POST["desconto_desc"];
	$valor_condicao = $_POST["desconto_acima"];

}elseif ($oferta == 'cupao') {
	$valor_desconto = $_POST["desconto_cupao"];
	$valor_condicao = $_POST["desconto_acima_cupao"];
}
else{
	$gratis = 1;
}


if($id || $nome){
	if($id){
		mysqli_query($lnk,"UPDATE vales_desconto SET nome='$nome',codigo='$codigo',valor_desconto='$valor_desconto',valor_condicao='$valor_condicao',gratis='$gratis',data_inicio='$inicio',data_fim='$fim',descricao='$descricao',tipo='$oferta' WHERE id='$id'");
	}
	else{

		mysqli_query($lnk, "INSERT INTO vales_desconto(nome,codigo,valor_desconto,valor_condicao,gratis,data_inicio,data_fim,descricao,tipo) VALUES ('$nome','$codigo','$valor_desconto','$valor_condicao','$gratis','$inicio','$fim','$descricao','$oferta')");
		$id = mysqli_insert_id($lnk);
	}
}
echo $id;
?>