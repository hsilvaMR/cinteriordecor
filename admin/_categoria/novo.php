<?php
include('../../_connect.php');
session_start();

$id = $_POST["id"];
$categoria_pt = mysqli_real_escape_string($lnk,trim($_POST["categoria_pt"]));
$categoria_en = mysqli_real_escape_string($lnk,trim($_POST["categoria_en"]));

//echo "$id \n $nome";

if($id || $categoria_pt || $categoria_en){
	if($id){
		mysqli_query($lnk,"UPDATE produto_cat SET categoria_pt='$categoria_pt', categoria_en='$categoria_en' WHERE id='$id'");
	}
	else{
		mysqli_query($lnk, "INSERT INTO produto_cat(categoria_pt, categoria_en) VALUES ('$categoria_pt', '$categoria_en')");
		$id = mysqli_insert_id($lnk);
	}
}
echo $id;
?>