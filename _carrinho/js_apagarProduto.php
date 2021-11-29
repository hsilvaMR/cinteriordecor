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
*/
$id = isset($_POST['id']) ? $_POST['id'] : '';
//$qtP = filter_var($qtP, FILTER_VALIDATE_INT);

//$retorna['alerta'] = "$id";
//$retorna['aviso']= "aviso";

$precoTotal = 0;
$qtCarrinho = 0;
$carrinho = isset($_COOKIE['CARRINHO']) ? $_COOKIE['CARRINHO'] : '';
$lista = explode(",", $carrinho);
foreach ($lista as $i => $value)
{
	$idqt = explode("-", $value);
	$idC = $idqt[0];
	$qtC = $idqt[1];
	if($idC == $id){
		$parte = "$idC-$qtC";
		$cookie = str_replace($parte, "", $carrinho);
		$cookie = str_replace(",,", ",", $cookie);
		$inicio = substr($cookie, 0, 1);
		if($inicio == ','){$cookie = substr($cookie, 1);}
		$fim = substr($cookie, -1);
		if($fim == ','){$cookie = substr($cookie, 0, -1);}
	}
	else{
		$linha = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM produto WHERE id = '$idC'"));
		$preco = $linha['preco'];
		$id_produto_cat = $linha['id_produto_cat'];
		$preco = number_format($preco, 2, '.', '');

		$desconto = number_format($linha['desconto'], 2, '.', '');
		$saldo = $linha["saldo"];

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

		$precoTotal = $precoTotal + ($preco * $qtC);
		$qtCarrinho = $qtCarrinho + $qtC;
	}
}
//echo "<script>createCookie('CARRINHO','$cookie',168);</script>";
$retorna['qtCarrinho']= "$qtCarrinho";
$retorna['cookie']= "$cookie";
$precoTotal = number_format($precoTotal, 2, '.', '');
$retorna['precoTotal']= "$precoTotal";

//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>