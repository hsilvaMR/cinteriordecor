<?php
include('../../_connect.php');
session_start();

$email = $_POST['email'];
$email = trim($email);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
$password = $_POST['password'];
$password = trim($password);

if($email && $password){
	$login = mysqli_query($lnk,"SELECT * FROM admin WHERE email = '$email' AND password = '$password'");
	$num_util = mysqli_num_rows($login);
	if($num_util == 1)
	{
		$linha = mysqli_fetch_array($login);
		$id = $linha['id'];   
		$_SESSION['id_admin'] = $id;
		echo "TM";
	}
	else { echo "Dados incorretos.";}
}else{ echo "Insira os seus dados corretamente."; }
?>