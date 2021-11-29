<?php
include('../_connect.php');
session_start();


$url = $_SERVER['REQUEST_URI'];
$urlPartes = explode("/", $url);

$token = urldecode($urlPartes[3]);



	
$existe = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE token='$token'"));
if($existe)
{
	
	$estado = 'ativo';
	mysqli_query($lnk,"UPDATE user SET estado='$estado' WHERE token='$token'");
}
   
header( 'Location: http://www.ci-interiordecor.com' );
?>