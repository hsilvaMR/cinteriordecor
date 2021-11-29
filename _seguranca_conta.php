<?php
ob_start();
session_start();
include('../_connect.php');

if(isset($_SESSION['user_session']))
{	
	$id_user = $_SESSION['user_session'];
	$linha_admin = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_user'"));
	$nome = $linha_admin['nome'];
	$email = $linha_admin['email'];
}
else
{	
	
	unset($_SESSION['user_session']);
	setcookie('USER');
	//session_destroy('user_session');
	header('Location: /');
	//exit;
}
?>