<?php
include('../../_connect.php');
session_start();

$jsonReceiveData = json_encode($_POST);
$jsonIterator = new RecursiveIteratorIterator(new RecursiveArrayIterator(json_decode($jsonReceiveData, TRUE)),RecursiveIteratorIterator::SELF_FIRST);

$valores = array();
foreach ($jsonIterator as $key => $val)
{
   if(is_array($val)) { foreach($val as $key1 => $val1) { $valores[$key][$key1] = $val1; } }
   else { $valores[$key] = $val; }
}

$id = $valores['id'];
$tabela = $valores['tabela'];

$linha = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM $tabela WHERE id='$id'"));
$online = $linha["online"];

if($online=='1'){$aux = 0;}else{$aux = 1;}
mysqli_query($lnk, "UPDATE $tabela SET online='$aux' WHERE id='$id'");

echo json_encode($aux);
?>