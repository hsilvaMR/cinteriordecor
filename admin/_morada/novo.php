<?php
include('../../_connect.php');
session_start();

$id_user = $_POST['id_user'];
$id_morada = $_POST['id_morada'];
$nome_morada = $_POST['nome_morada'];
$nome = $_POST['nome'];
$apelido = $_POST['apelido'];
$endereco = $_POST['endereco'];
$localidade = $_POST['localidade'];
$codigo_postal = $_POST['codigo_postal'];
$pais = $_POST['pais'];
$contacto = $_POST['contacto'];



if($id_morada){
	mysqli_query($lnk,"UPDATE user_morada SET id_user='$id_user', nome='$nome', apelido='$apelido', endereco='$endereco', localidade='$localidade', codigo_postal='$codigo_postal', pais='$pais', telemovel='$contacto', nome_morada='$nome_morada'  WHERE id='$id_morada'");
}
else{
	mysqli_query($lnk, "INSERT INTO user_morada(id_user, nome, apelido, endereco, localidade, codigo_postal, pais, telemovel, nome_morada) VALUES ('$id_user', '$nome', '$apelido', '$endereco', '$localidade', '$codigo_postal', '$pais', '$contacto', '$nome_morada')");
	$id_user = mysqli_insert_id($lnk);
}
echo $id_user;
?>