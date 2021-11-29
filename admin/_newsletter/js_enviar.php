<?php
include('../../_connect.php');
session_start();

$query = mysqli_query($lnk,"SELECT * FROM newsletter");
while($linha = mysqli_fetch_array($query))
{
	$id = $linha["id"];
	$email = $linha["email"];
	$data = $linha["data"];

	$paraEmail = $email;
	$paraNome = '';
	$De = "Ci-interiordecor <geral@ci-interiordecor.com>";
	$Cc = "";
	$CcOculto = "";
	$respPara = "";

	$assunto = "Descontos até 50%";
	$mensagem = '

	<!doctype html>
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	    <title></title>
	    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,500,600,700" rel="stylesheet">
	    <style type="text/css">
	        body, table, td, a { font-family:"Open Sans",Arial,sans-serif;}
	        a:link, a:hover, a:visited, a:active {text-decoration:none;}
	    </style>
	    <!--[if mso]>
	    <style type="text/css">
	    body, table, td, a, center {font-family: Arial, Helvetica, sans-serif !important;cursor:default;}
	    </style>
	    <![endif]-->
	</head>
	<body style="width:100%;background-color:#f1f1f1;margin:0;padding:0;font-size:14px;-webkit-font-smoothing:antialiased;cursor:default;color:#4c4c4c;text-align:center;">
	    <table border="0" cellpadding="0" align="center" width="100%">
	        <tr>
	            <td style="padding:0 10px;">
	                
	                <table style="padding-top:80px;" border="0" cellpadding="0" width="100%">
					  <tr>
					    <td width="100%" align="center">
					      <a href="http://www.ci-interiordecor.com/loja" target="_blank" style="text-decoration:none;color:#0084B6;">
					        <img src="http://www.ci-interiordecor.com/img/newsletters/ci-logo.png" alt="Ci-interiordecor" height="65">
					      </a>
					    </td>
					  </tr>
					</table>


					<!-- ICON -->
					<table style="padding-top:50px;" border="0" cellpadding="0" width="100%">
					   <tr>
						  <td align="center" width="100%">
						    <img src="http://www.ci-interiordecor.com/img/newsletters/ci-01.png" alt="Ainda não aproveitou as nossas promoções?" width="340">
						  </td>
						</tr>
					</table>

					<!-- TEXTO -->
					<table style="padding-top:50px;" border="0" cellpadding="0" width="100%">
					   <tr>
						    <td align="center" width="100%" style="color:#4c4c4c;font-size:14px;line-height:20px;">
						        Então apresse-se porque só tem esta oportunidade até ao final deste mês...
							</td>
						</tr>
					</table>
					<!-- 50% -->
					<table style="padding-top:50px;" border="0" cellpadding="0" width="100%">
					   <tr>
						  <td align="center" width="100%">
						    <img style="font-size:50px;line-height:56px;color:#0099a8;" src="http://www.ci-interiordecor.com/img/newsletters/ci-02.png" alt="Descontos até 50%"  width="305">
						  </td>
						</tr>
					</table>
					<!-- PRODUTOS -->
					<table style="padding-top:50px;" border="0" cellpadding="0" width="100%">
					   <tr>
						  <td align="center" width="100%">
						    <a href="http://www.ci-interiordecor.com/loja" target="_blank" style="text-decoration:none;color:#0084B6;">
						      <img style="font-size:50px;line-height:56px;color:#0099a8;" src="http://www.ci-interiordecor.com/img/newsletters/ci-03.png" alt="Produtos a 50% de desconto"  width="500">
						    </a>
						  </td>
						</tr>
					</table>

					<!-- BOTAO -->
					<table style="padding-top:50px;" border="0" cellpadding="0" width="100%">
					   <tr>
						  	<td align="center" width="100%">
							    <table style="font-size:10px;padding:8px 13px;color:#ffffff;background-color:#0099a8;">
									<tr><td><a href="http://www.ci-interiordecor.com/loja" target="_blank" style="color:#ffffff;text-decoration:none;background:#0099a8;">VISITAR O SITE</a></td></tr>
								</table>
							</td>
						</tr>
					</table>

					<!-- TEXTO -->
					<table style="padding-top:50px;padding-bottom:25px;" border="0" cellpadding="0" width="100%">
					   <tr>
						    <td align="center" width="100%" style="color:#4c4c4c;font-size:12px;line-height:16px;">
						        *válido para artigos em stock
							</td>
						</tr>
					</table>

					<!-- RODAPE -->
					<table style="padding-top:25px;padding-bottom:50px;background:#3c3c3c;color:#ffffff" border="0" cellpadding="0" width="100%">
					   <tr>
						    <td align="center" width="100%" style="font-size:12px;line-height:16px;">
						        CI - INTERIOR DECOR
								<br><br>
						        Rua de S.Domingos, 178<br>4710-435 Braga
								<br><br>
						        +351 253 295 674 | +351 253 042 965<br><a href="mailto:geral@ci-interiordecor.com" target="_blank" style="color:#0099a8;text-decoration:none;">geral@ci-interiordecor.com</a>
								<br><br>
						        Para deixar de receber as nossas promoções,<br>responda com o assunto "REMOVER".
							</td>
						</tr>
					</table>

	            </td>
	        </tr>
	    </table>
	</body>
	</html>
	';

	include('../funcao/email.php');

}
//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>