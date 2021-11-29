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

$id = $valores["id"];

$query = mysqli_query($lnk,"SELECT * FROM produto_gal WHERE id_produto='$id'");
while($linha = mysqli_fetch_array($query))
{
	$img = $linha["img"];
	if($img && file_exists('../..'.$img)){ unlink('../..'.$img); }
}
mysqli_query($lnk, "DELETE FROM produto_gal WHERE id_produto='$id'");
mysqli_query($lnk, "DELETE FROM produto WHERE id='$id'");

echo json_encode($id);
?>