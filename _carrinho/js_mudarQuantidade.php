<?php
include('../_connect.php');
/*
$jsonReceiveData = json_encode($_POST);
$jsonIterator = new RecursiveIteratorIterator(new RecursiveArrayIterator(json_decode($jsonReceiveData, TRUE)),RecursiveIteratorIterator::SELF_FIRST);

$valores = array();
foreach ($jsonIterator as $key => $val)
{
   if(is_array($val)) { foreach($val as $key1 => $val1) { $valores[$key][$key1] = $val1; } }
   else { $valores[$key] = $val; }
}

$id = $valores['id'];
$qtP = $valores['qtP'];
*/
$id = isset($_POST['id']) ? $_POST['id'] : '';
$qtP = isset($_POST['qtP']) ? $_POST['qtP'] : '';
//$qtP = filter_var($qtP, FILTER_VALIDATE_INT);

//$retorna['alerta'] = "$id = $qtP";
//$retorna['aviso']= "aviso";

$precoProdu = 0;
$precoTotal = 0;
$qtCarrinho = 0;
$carrinho = isset($_COOKIE['CARRINHO']) ? $_COOKIE['CARRINHO'] : '';
$lista = explode(",", $carrinho);
foreach ($lista as $i => $value)
{
	$idqt = explode("-", $value);
	$idC = $idqt[0];
	$qtC = $idqt[1];
	if($idC == $id)
	{
		$parte = "$idC-$qtC";
		$qtC = $qtP;
		$parteNova = "$idC-$qtP";
		$cookie = str_replace($parte, $parteNova, $carrinho);

		$linhaP = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM produto WHERE id = '$idC'"));
		$precoP = number_format($linhaP['preco'], 2, '.', '');
		$id_produto_catP = $linhaP['id_produto_cat'];

		$descontoP = number_format($linhaP['desconto'], 2, '.', '');
		$saldoP = $linhaP["saldo"];

		//PROMOÇÃO
		$hoje=date('Y-m-d');
		$linhaPromo = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM promocao WHERE (categoria='$id_produto_catP' OR categoria=0) AND inicio<='$hoje' AND fim>='$hoje' ORDER BY valor DESC"));
		$valorPromo = $linhaPromo["valor"];

		if($valorPromo){
			$descontoP = (100-$valorPromo)*$precoP/100;
			$descontoP = number_format($descontoP, 2, '.', '');
			$precoP = $descontoP;
		}
		else{ if($saldoP && $descontoP!='0.00' && $descontoP<$precoP){ $precoP = $descontoP; } }
		//if($saldoP && $descontoP!='0.00' && $descontoP<$precoP){ $precoP = $descontoP; }

		$precoProdu = $precoP * $qtC;
		
	}
	$linha = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM produto WHERE id = '$idC'"));
	$preco = $linha['preco'];
	$desconto = $linha["desconto"];
	$saldo = $linha["saldo"];
	$id_produto_cat = $linha['id_produto_cat'];

	//PROMOÇÃO
	$hoje=date('Y-m-d');
	$linhaPromo = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM promocao WHERE (categoria='$id_produto_cat' OR categoria=0) AND inicio<='$hoje' AND fim>='$hoje' ORDER BY valor DESC"));
	$valorPromo = $linhaPromo["valor"];

	if($valorPromo){
		$desconto = (100-$valorPromo)*$preco/100;
		$desconto = number_format($desconto, 2, '.', '');
		$preco = $desconto;
	}
	else{ if($saldo && $desconto!='0.00' && $desconto<$preco){ $preco = $desconto; } }
	//if($saldo && $desconto!='0.00' && $desconto<$preco){ $preco = $desconto; }
	
	$precoTotal = $precoTotal + ($preco * $qtC);
	$qtCarrinho = $qtCarrinho + $qtC;
}
//echo "<script>createCookie('CARRINHO','$cookie',168);</script>";
$retorna['qtCarrinho']= "$qtCarrinho";
$retorna['cookie']= "$cookie";
$precoProdu = number_format($precoProdu, 2, '.', '');
$retorna['precoProdu']= "$precoProdu";
$precoTotal = number_format($precoTotal, 2, '.', '');
$retorna['precoTotal']= "$precoTotal";

//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>