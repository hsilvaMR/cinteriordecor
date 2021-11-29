<?php
include('../../_connect.php');
session_start();
$id_user = $_SESSION['id_admin'];
$linha_user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM admin WHERE id = '$id_user'"));
$password_user = $linha_user['password'];

$antiga = $_POST["antiga"];
$nova = $_POST["nova"];
$nova = trim($nova);
$confirmacao = $_POST["confirmacao"];
$confirmacao = trim($confirmacao);
$str = strlen($nova);

if($password_user==$antiga){
	if($str>5){
		if($nova==$confirmacao){
			mysqli_query($lnk,"UPDATE admin SET password='$nova' WHERE id='$id_user'");
			$aviso='TM';
		}else{ $aviso='As password\'s não coincidem.';}
	}else{ $aviso='Nova password demasiado curta. <br>Mínimo 6 caracteres.';}
}else{ $aviso='Password incorreta.';}
echo $aviso;
?>