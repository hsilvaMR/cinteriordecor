<?php
include('../../_connect.php');
include('../funcao/gerar_codigo.php');
session_start();

$id = $_POST["id"];
$campanha = 'dia-dos-namorados';
$nome = trim($_POST["nome"]);
$nome = str_replace("'", "′", $nome);
$nome = str_replace("\"", "“", $nome);
$email = trim(strtolower($_POST["email"]));
$contacto = trim($_POST["contacto"]);
$valor = trim($_POST["valor"]);
$valor = str_replace(",", ".", $valor);
$codigo = trim($_POST["codigo"]);

if(!$codigo){
	do{
		$codigo = gerarCodigoMaiusculas(5);
		$numero = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM sorteio WHERE codigo='$codigo'"));

	}while($numero > 0);
}

/* $numero=1;
while ($numero > 0) {
	$codigo = gerarCodigoMaiusculas(5);
	$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM sorteio WHERE codigo='$codigo'"));
}*/

$vouchers = intval($valor/100);
//echo "$id \n $titulo \n $img";

if($id || $nome || $email || $contacto || $valor){
	if($id){
		mysqli_query($lnk,"UPDATE sorteio SET campanha='$campanha',nome='$nome',email='$email',contacto='$contacto',valor='$valor',codigo='$codigo',vouchers='$vouchers' WHERE id='$id'");
	}
	else{
		mysqli_query($lnk, "INSERT INTO sorteio(campanha,nome,email,contacto,valor,codigo,vouchers) VALUES ('$campanha','$nome','$email','$contacto','$valor','$codigo','$vouchers')");
		$id = mysqli_insert_id($lnk);
	}
}
echo $id;
?>