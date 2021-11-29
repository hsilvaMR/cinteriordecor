<?php
//include('../_connect.php');

$jsonReceiveData = json_encode($_POST);
$jsonIterator = new RecursiveIteratorIterator(new RecursiveArrayIterator(json_decode($jsonReceiveData, TRUE)),RecursiveIteratorIterator::SELF_FIRST);

$valores = array();
foreach ($jsonIterator as $key => $val)
{
   if(is_array($val)) { foreach($val as $key1 => $val1) { $valores[$key][$key1] = $val1; } }
   else { $valores[$key] = $val; }
}

$Fnome = '';
if(isset($valores['Fnome'])){$Fnome = $valores['Fnome'];}
$Frua = '';
if(isset($valores['Frua'])){$Frua = $valores['Frua'];}
$Fcodpostal = '';
if(isset($valores['Fcodpostal'])){$Fcodpostal = $valores['Fcodpostal'];}
$Flocalidade = '';
if(isset($valores['Flocalidade'])){$Flocalidade = $valores['Flocalidade'];}
$Fzona = '';
if(isset($valores['Fzona'])){$Fzona = $valores['Fzona'];}
$Fnif = '';
if(isset($valores['Fnif'])){$Fnif = filter_var($valores['Fnif'], FILTER_VALIDATE_INT);}
$Fcontacto = '';
if(isset($valores['Fcontacto'])){$Fcontacto = filter_var($valores['Fcontacto'], FILTER_VALIDATE_INT);}
$Femail = '';
if(isset($valores['Femail'])){$Femail = filter_var($valores['Femail'], FILTER_VALIDATE_EMAIL);}

$Enome = '';
if(isset($valores['Enome'])){$Enome = $valores['Enome'];}
$Erua = '';
if(isset($valores['Erua'])){$Erua = $valores['Erua'];}
$Ecodpostal = '';
if(isset($valores['Ecodpostal'])){$Ecodpostal = $valores['Ecodpostal'];}
$Elocalidade = '';
if(isset($valores['Elocalidade'])){$Elocalidade = $valores['Elocalidade'];}
$Ezona = '';
if(isset($valores['Ezona'])){$Ezona = $valores['Ezona'];}
$Econtacto = '';
if(isset($valores['Econtacto'])){$Econtacto = filter_var($valores['Econtacto'], FILTER_VALIDATE_INT);}

$dados = $Fnome.'||'.$Frua.'||'.$Fcodpostal.'||'.$Flocalidade.'||'.$Fzona.'||'.$Fnif.'||'.$Fcontacto.'||'.$Femail.'||'.$Enome.'||'.$Erua.'||'.$Ecodpostal.'||'.$Elocalidade.'||'.$Ezona.'||'.$Econtacto;
//echo "<script>createCookie('CARRINHO','$cookie',168);</script>";

echo json_encode($dados);
?>