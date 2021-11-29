<?php
include('../../_connect.php');
session_start();

$id_user = $_POST["id_user"];
$oferta = $_POST["oferta"];
$hoje=date('Y-m-d');

if($id_user){
	mysqli_query($lnk, "INSERT INTO user_vales(id_user,id_vale,data) VALUES ('$id_user','$oferta','$hoje')");
}

echo $id_user;
?>