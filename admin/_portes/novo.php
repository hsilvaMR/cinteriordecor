<?php
include('../../_connect.php');
session_start();

$id = $_POST["id"];
$id_categoria = json_encode($_POST["id_categoria"]);
$id_produtos = json_encode($_POST["id_produtos"]);


$nome = trim($_POST["nome"]);
$codigo = trim($_POST["codigo"]);
$inicio = $_POST["inicio"];
$fim = $_POST["fim"];
$descricao = $_POST["descricao"];


$oferta = $_POST["oferta"];

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
}
else{
	$gratis = 1;
}


if($id || $nome){
	if($id){

		if ($id_categoria == 'null') {
			$id_categoria = '';
		}

		if ($id_produtos == 'null') {
			$id_produtos = '';
		}

		mysqli_query($lnk,"UPDATE portes SET id_categoria='$id_categoria',id_produto='$id_produtos',nome='$nome',codigo='$codigo',valor_desconto='$valor_desconto',valor_condicao='$valor_condicao',gratis='$gratis',data_inicio='$inicio',data_fim='$fim',descricao='$descricao',tipo='$oferta' WHERE id='$id'");
	}
	else{

		if ($id_categoria == 'null') {
			$id_categoria = '';
		}

		if ($id_produtos == 'null') {
			$id_produtos = '';
		}

		mysqli_query($lnk, "INSERT INTO portes(id_categoria,id_produto,nome,codigo,valor_desconto,valor_condicao,gratis,data_inicio,data_fim,descricao,tipo) VALUES ('$id_categoria','$id_produtos','$nome','$codigo','$valor_desconto','$valor_condicao','$gratis','$inicio','$fim','$descricao','$oferta')");
		$id = mysqli_insert_id($lnk);
	}
}
echo $id;
?>