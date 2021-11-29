<?php
date_default_timezone_set('Europe/Lisbon');
/***** LIGAR BASE DE DADOS *****/

 global $lnk;
 
$lnk = mysqli_connect("localhost", "ciinteri_oruser", "BsX=^ag9.@2+", "ciinteri_orbase")or die("Erro BD" . mysqli_error($lnk));
mysqli_set_charset($lnk, "utf8");
?>

<?php
$LANG = (isset($_COOKIE['LINGUA']) && $_COOKIE['LINGUA']) ? $_COOKIE['LINGUA'] : '';
if(!$LANG){
	echo "<script>createCookie('LINGUA','pt',720);</script>";
	$LANG = 'pt';
}
//echo "<script>createCookie('LINGUA','en',720);</script>";
?>