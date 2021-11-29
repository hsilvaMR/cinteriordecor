<?php
include('../_connect.php');
session_start();

$jsonReceiveData = json_encode($_POST);
$jsonIterator = new RecursiveIteratorIterator(new RecursiveArrayIterator(json_decode($jsonReceiveData, TRUE)),RecursiveIteratorIterator::SELF_FIRST);

$valores = array();
foreach ($jsonIterator as $key => $val)
{
   if(is_array($val)) { foreach($val as $key1 => $val1) { $valores[$key][$key1] = $val1; } }
   else { $valores[$key] = $val; }
}

$email = $valores['email'];
$email = trim($email);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);

$retorna['aviso']=''; $aviso='';


$login = mysqli_query($lnk,"SELECT * FROM user WHERE email = '$email'");
$num_util = mysqli_num_rows($login);
if($num_util == 1)
{

	$linha = mysqli_fetch_array($login);
	$nome = $linha['nome'];
	$password = $linha['password'];
	$token = $linha['token'];

	$para = $nome." <".$email.">";
	$paraEmail = $email;
	$paraNome = $nome;
	$De = "Admin <cvieira@mredis.com>";
	$Cc = "";
	$CcOculto = "";
	$respPara = "";

	$assunto = "Ativar Conta";

	$img ='<img src="http://www.ci-interiordecor.com/img/emails/user.png" alt="Produção" height="80" width="80">';

	if($LANG=='pt'){
		$thank_you_tx = "Obrigado por se registar na nossa página. <br>Por favor, ative a sua conta.";
		$tx_bt = "ATIVAR";
		$terms_tx = "Por favor, não responda a este email.<br>
					O endereço de envio serve apenas para transmitir mensagens autómaticas.<br>
					Se necessitar de algum esclarecimento, consulte a nossa página <br>
					de"; 
		$terms = "Termos e Condições";
		$contact_tx = "Para ter a certeza que recebe sempre os nossos e-mails
						e notificações, adicione o nosso e-mail aos seus contactos:";
	}

	if($LANG=='en'){
		$thank_you_tx = "Thank you for registering on our page. <br>Please activate your account.";
		$tx_bt = "ACTIVATE";
		$terms_tx = "Please do not reply to this email. <br>
					The shipping address is only for transmitting automated messages. <br>
					If you need any clarification, consult our page <br>
					in"; 
		$terms = "Terms and conditions";
		$contact_tx = "To make sure you always receive our emails
						and notifications, add our email to your contacts:";
	}

	$mensagem = '
	<!doctype html>
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	    <title></title>
	    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700,600,800" rel="stylesheet" type="text/css">
	    <link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
	    <style type="text/css">
	        body, table, td, a { font-family:"Raleway",Arial,sans-serif;}
	        a:link, a:hover, a:visited, a:active {text-decoration:none;}
	    </style>
	    <!--[if mso]>
	    <style type="text/css">
	    body, table, td, a, center {font-family: Arial, Helvetica, sans-serif !important;cursor:default;}
	    </style>
	    <![endif]-->
	</head>
	<body style="width:100%;background-color:#96C7D0;margin:0;padding:0;font-size:14px;-webkit-font-smoothing:antialiased;cursor:default;color:#222222;">
		<table style="padding:0px;" border="0" cellpadding="0" width="40%" align="center">
			<table style="background-color:#222222;padding:20px 10px;" border="0" cellpadding="0" width="100%">
			  	<tbody>
				  	<tr>
					    <td align="left" width="400">
					      <a href="http://www.ci-interiordecor.com" target="_bank" style="text-decoration:none;color:#ffffff;">
				            <img style="font-size:34px;font-weight:bold;color:#ffffff;" src="http://www.ci-interiordecor.com/img/emails/ci.png" alt="Ci-interiordecor" height="30">
				          </a>
					    </td>
				  	</tr>
			  	</tbody>
			</table>

			<table style="background-color:#fff;padding:0px 10px;padding-top:75px;" border="0" cellpadding="0" width="100%">
				<tbody>
				  <tr>
					<td align="center" width="400">
					  <table align="center" border="0" cellpadding="0" cellspacing="0" height="90" width="400">
					    <tbody>
					      <tr>
						    <td width="400" align="center">'.$img.'</td>
						  </tr>
						</tbody>
					  </table>
				    </td>
				  </tr>
				</tbody>
			</table>

		<table style="background-color:#fff;padding:0px 10px;padding-top:20px;" border="0" cellpadding="0" width="100%">
			<tbody>
			  <tr>
				<td align="center" width="400">
				  <table align="center" border="0" cellpadding="0" cellspacing="0" width="400">
				    <tbody>
				      <tr>
					    <td width="400" align="center" style="color:#000000;font-size: 15px;line-height: 24px;font-family:Open Sans;font-style: normal;font-weight: normal;">
					    	'.$nome.'!<br>
							'.$thank_you_tx.'
					    </td>
					  </tr>
					</tbody>
				  </table>
			    </td>
			  </tr>
			</tbody>
		</table>

		<table bgcolor="#fff" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #fff; width: 100%;padding-top:40px;" valign="top" width="100%">

			<tr style="vertical-align: top;" valign="top" align="center">
				<td style="word-break: break-word; vertical-align: top; border-collapse: collapse;" valign="top">	
				
					<!--[if (!mso)&(!IE)]><!-->
					<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:10px; padding-bottom:10px; padding-right: 0px; padding-left: 0px;">
					<!--<![endif]-->
					<div align="center" class="button-container" style="padding-top:0px;padding-right:30px;padding-bottom:30px;padding-left:30px;width:100px;">
					<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-top: 0px; padding-right: 30px; padding-bottom: 30px; padding-left: 30px" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://www.ci-interiordecor.com/_register/js_ativarConta/'.$token.'" style="height:31.5pt; width:100pt; v-text-anchor:middle;" arcsize="96%" stroke="false" fillcolor="#4197A6"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#ffffff; font-family:\'Open Sans\',sans-serif;font-weight: 300; font-size:14px"><![endif]-->
					<a href="http://www.ci-interiordecor.com/_register/js_ativarConta/'.$token.'" target="_blank"><div style="text-decoration:none;display:block;color:#ffffff;background-color:#4197A6;border-radius:25px;-webkit-border-radius:25px;-moz-border-radius:25px;width:100%; width:calc(100% - 2px);;border-top:1px solid #4197A6;border-right:1px solid #4197A6;border-bottom:1px solid #4197A6;border-left:1px solid #4197A6;padding-top:5px;padding-bottom:5px;font-family:\'Open Sans\',sans-serif;text-align:center;mso-border-alt:none;word-break:keep-all;font-weight: 300;">
						<span style="padding-left:5px;padding-right:5px;font-size:16px;display:inline-block;">
						<span style="font-size:14px;line-height:32px;color:#ffffff;">'.$tx_bt.'</span>
						</span>
					</div></a>
					<!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
					</div>
					</div>
			
				</td>
			</tr>
		</table>

		<table style="background-color:#fff;padding:0px 10px;padding-top:75px;" border="0" cellpadding="0" width="100%">
			<tbody>
			  <tr>
				<td align="center" width="400">
				  <table align="center" border="0" cellpadding="0" cellspacing="0" width="400">
				    <tbody>
				      <tr>
					    <td width="400" align="center" style="color:#000;font-family: \'Open Sans\',sans-serif;font-style: normal;font-weight: 300;font-size: 11px;line-height: 15px;">
					    	'.$terms_tx.' <a href="http://www.ci-interiordecor.com/termos" style="text-decoration:none;color:#96C7D0;">'.$terms.'</a>
							<br>
							<br>
							'.$contact_tx.'
							<a href="no-reply@ci-interiordecor.com" target="_bank" style="text-decoration:none;color:#96C7D0;">
				            no-reply@ci-interiordecor.com</a>
					    </td>
					  </tr>
					</tbody>
				  </table>
			    </td>
			  </tr>
			</tbody>
		</table>

		<table style="background-color:#fff;padding:0px 10px;padding-top:30px;" border="0" cellpadding="0" width="100%">
			<tbody>
			  <tr>
				<td align="center" width="400">
				  <table align="center" border="0" cellpadding="0" cellspacing="0" width="400">
				    <tbody>
				      <tr>
					    <td width="400" align="center" style="font-family:\'Open Sans\',sans-serif;font-style:normal;font-weight:300;font-size: 10px;line-height:14px;color:#96C7D0;">
					    	<a href="http://www.ci-interiordecor.com" style="text-decoration:none;color:#96C7D0;">www.ci-interior decor.com</a>
						</td>
					  </tr>
					</tbody>
				  </table>
			    </td>
			  </tr>
			</tbody>
		</table>


		<table style="background-color:#fff;padding-top:10px;" border="0" cellpadding="0" width="100%">
			<tbody>
			  <tr>
				<td align="center" width="400">
					<a href="https://www.facebook.com/ci.interiordecor" target="_bank"><img src="http://www.ci-interiordecor.com/img/emails/facebook.png" alt="facebook" height="12" width="12"></a>&ensp;
					<a href="https://www.pinterest.pt/cidecor/" target="_bank"><img src="http://www.ci-interiordecor.com/img/emails/pintrest.png" alt="pintrest" height="12" width="12"></a>&ensp;
					<a href="https://www.instagram.com/ci.interiordecor/" target="_bank"><img src="http://www.ci-interiordecor.com/img/emails/instagram.png" alt="facebook" height="12" width="12"></a>
			    </td>
			  </tr>
			</tbody>
		</table>

		<table style="background-color:#fff;padding-top:50px;" border="0" cellpadding="0" width="100%">
			<tbody>
			  <tr>
				<td align="center" width="400">
			    </td>
			  </tr>
			</tbody>
		</table>
	</table>
	</body>
	</html>
	';

	include('../admin/funcao/email.php');
}


//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>