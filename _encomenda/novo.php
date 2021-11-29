<?php
include('../_connect.php');
session_start();

$id = '';
if (isset($_POST["id"])) { $id = $_POST["id"]; }
$produto = '';
if (isset($_POST["produto"])) { $produto = $_POST["produto"]; }
$nome = '';
if (isset($_POST["nome"])) { $nome = trim($_POST["nome"]); $nome = str_replace("'", "′", $nome); $nome = str_replace("\"", "“", $nome); }
$email = '';
if (isset($_POST["email"])) { $email = trim($_POST["email"]); $email = str_replace("'", "′", $email); $email = str_replace("\"", "“", $email); }
$contacto = '';
if (isset($_POST["contacto"])) { $contacto = trim($_POST["contacto"]); $email = str_replace("'", "′", $contacto); $contacto = str_replace("\"", "“", $contacto); }
$quantidade = '';
if (isset($_POST["quantidade"])) { $quantidade = trim($_POST["quantidade"]); $email = str_replace("'", "′", $quantidade); $quantidade = str_replace("\"", "“", $quantidade); }
$mensagem = '';
if (isset($_POST["mensagem"])) { $mensagem = trim($_POST["mensagem"]); $email = str_replace("'", "′", $mensagem); $mensagem = str_replace("\"", "“", $mensagem); }
//echo "$id \n $titulo \n $nome";

if($id && $nome && $email && $contacto && $quantidade && $mensagem){
	if(filter_var($email, FILTER_VALIDATE_EMAIL)){
		$data = date('Y-m-d');
		mysqli_query($lnk, "INSERT INTO encomenda(id_produto,nome,email,contacto,quantidade,mensagem,data) VALUES ('$id','$nome','$email','$contacto','$quantidade','$mensagem','$data')");


		$paraNome = 'Encomenda Site';
		$paraEmail = 'geral@ci-interiordecor.com';

		$assunto = "Contacto Site (encomenda)";
		$mensagem = '
		<html>
	        <head>
	            <title>Contacto</title>
	            <style>*{font-size:14px;} .espaco{height:30px}</style>
	        </head>
			<body>
				<br>
				<table>
					<tr><th class="espaco" colspan="2" align="left">Dados de Contacto</th></tr>
					<tr><td class="espaco">Nome: </td><td>'.$nome.'</td></tr>
					<tr><td class="espaco">Email: </td><td>'.$email.'</td></tr>
					<tr><td class="espaco">Contacto: </td><td>'.$contacto.'</td></tr>
					<tr><td class="espaco">Quantidade: </td><td>'.$produto.'</td></tr>
					<tr><td class="espaco">Quantidade: </td><td>'.$quantidade.'</td></tr>
					<tr><td class="espaco" align="left">Informação Adicional: </td><td>'.nl2br($mensagem).'</td></tr>
				</table>
				<br><hr>
			</body>
		</html>
		';

		include('../admin/funcao/email.php');
		echo "TM";
	}else{ if($LANG=='pt'){echo "Email inválido!";} if($LANG=='en'){echo "Invalid email!";} }
}else{ if($LANG=='pt'){echo "Todos os campos são de preenchimento obrigatório!";} if($LANG=='en'){echo "All fields are required!";} }
?>