<?php
ob_start();
session_start();
include('../_connect.php');

if(isset($_SESSION['id_admin']))
{
	$id_admin = $_SESSION['id_admin'];
	$linha_admin = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM admin WHERE id = '$id_admin'"));
	$nome_admin = $linha_admin['nome'];
	$email_admin = $linha_admin['email'];
}
else
{
	session_destroy();
	header('Location: /admin');
}
?>