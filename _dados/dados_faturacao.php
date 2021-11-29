<?php
include('../_connect.php');
 
session_start();
$id = $_POST['id'];
$quantStock = $_POST['quantStock'];
$quantidade = $_POST['quantidade'];
$qtRestante = $_POST['qtRestante'];


$qtCarrinho = 0;

$carrinho = $_COOKIE['CARRINHO'];
if($carrinho)
{
  $lista = explode(",", $carrinho);
  $ex = 'nao';
  foreach ($lista as $i => $value)
  {
	$idqt = explode("-", $value);
	$idC = $idqt[0];
	$qtC = $idqt[1];
	$qtCarrinho = $qtCarrinho + $qtC;
	if($idC == $id)
	{
	  $parte = "$idC-$qtC";
	  $qtC = $qtC + $quantidade;
	  $parteNova = "$idC-$qtC";
	  $ex = 'sim';
	}
  }
  if($ex == 'sim'){$cookie = str_replace($parte, $parteNova, $carrinho);}
  else{$cookie = $carrinho.",$id-$quantidade";}
}
else{$cookie = "$id-$quantidade";}

echo "<script>createCookie('CARRINHO','$cookie',168);</script>";

//$carrinho = $cookie;
//$total = number_format($total, 2, ',', '');
/*echo "<script>document.getElementById('TOTAL').innerHTML='$total';</script>";*/
$noCarrinho="sim";
$qtCarrinho = $qtCarrinho + $quantidade;
$qtRestante = $qtRestante-$quantidade;
include "_quantidade.php";?>