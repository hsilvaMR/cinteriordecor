<?php
include('../../_connect.php');
session_start();

//$id = $_POST["id"];
$email = strtolower(trim($_POST["email"]));
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
//echo "$id \n $titulo \n $img";

if($email){
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM newsletter WHERE email = '$email'"));
	if(!$existe)
	{
		$data = date('Y-m-d');
		mysqli_query($lnk,"INSERT INTO newsletter (email, data) VALUES ('$email', '$data')");
	}
	//echo "TM";
}else{ echo "Insira corretamente o email!"; }
?>