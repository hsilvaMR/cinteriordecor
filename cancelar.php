<?php
$url_completo = $_SERVER['REQUEST_URI'];
$url_partes = explode("/", $url_completo);
$id = urldecode($url_partes[2]);
$seguranca = urldecode($url_partes[3]);

include('_connect.php');


$query = mysqli_query($lnk,"SELECT * FROM venda_prod WHERE id_venda='$id'");
while($linha = mysqli_fetch_array($query))
{
	$id_produto = $linha["id_produto"];
	$quantidade = $linha["quantidade"];
	
	$linha2 = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM produto WHERE id='$id_produto'"));
	$produ2 = $linha2['produzir'];
	$quant2 = $linha2['quantidade'];

	if(!$produ2){
		$nova_quant = $quantidade + $quant2;
		mysqli_query($lnk,"UPDATE produto SET quantidade='$nova_quant' WHERE id='$id_produto'");
	}
}

mysqli_query($lnk, "DELETE FROM venda WHERE id='$id' AND seguranca='$seguranca'");

header('Location: /carrinho');
?>