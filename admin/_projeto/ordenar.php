<?php
include('../../_connect.php');
$array	= $_POST['linha'];

$count = 1;
foreach ($array as $idval) {
	mysqli_query($lnk,"UPDATE projeto SET ordem='$count' WHERE id='$idval'");
	$count ++;	
}
?>