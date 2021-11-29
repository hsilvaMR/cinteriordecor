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

$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM banner WHERE id = '$id'"));
$img = $linha["tlm"];
$img2 = $linha["pc"];

if($img && file_exists('../..'.$img)){ unlink('../..'.$img); }
if($img2 && file_exists('../..'.$img2)){ unlink('../..'.$img2); }
mysqli_query($lnk, "DELETE FROM banner WHERE id='$id'");

echo json_encode($id);
?>