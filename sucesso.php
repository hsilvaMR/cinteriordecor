<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Ci | Interior Decor</title>
<? include '_head.php';?>
</head>

<body>
<? $sepCor='essencia'; include '_header.php';?>
<div class="barraH"></div>
<?php
$url_completo = $_SERVER['REQUEST_URI'];
$url_partes = explode("/", $url_completo);
$tracking = urldecode($url_partes[2]);
//$id_linha = filter_var($id_linha, FILTER_VALIDATE_INT);
//$linha = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM venda WHERE id='$id_linha' AND seguranca='$seguranca'"));	
//$id_venda = $linha['id'];
//$hora = $linha['hora'];
//$ref_hora = str_replace(":", "", $hora);
//$tracking = 'CI'.$id_venda.'IN'.$ref_hora;
echo "<script>createCookie('CARRINHO','',-2);</script>";

extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM venda WHERE tracking='$tracking'")));
$paraNome = $nome;
$paraEmail = $email;
$itens='';
$query3 = mysqli_query($lnk,"SELECT * FROM venda_prod WHERE id_venda = '$id'");
while($linha3 = mysqli_fetch_array($query3))
{
	$id_produto = $linha3["id_produto"];
	$quantidade = $linha3["quantidade"];
	$preco = $linha3["preco"];
	$total_prod = $linha3["total"];
	$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto WHERE id='$id_produto'"));
	$produto = $linha4["produto_".$LANG];
	
	$itens.='
		<tr>
			<td align="center" style="color:#666666;font-size:12px;border:1px solid #cccccc;">'.$produto.'</td>
			<td align="center" style="color:#666666;font-size:12px;border:1px solid #cccccc;">'.$quantidade.'</td>
			<td align="center" style="color:#666666;font-size:12px;border:1px solid #cccccc;">'.$preco.' €</td>
			<td align="center" style="color:#666666;font-size:12px;border:1px solid #cccccc;">'.$total_prod.' €</td>
		</tr>
	';
}

if($LANG=='pt'){
	$assunto="Encomenda efectuada com sucesso";
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
		<body style="width:100%;background-color:#ffffff;margin:0;padding:0;font-size:14px;-webkit-font-smoothing:antialiased;cursor:default;color:#222222;">

			<table style="background:#222222;padding:20px 10px;" border="0" cellpadding="0" width="100%">
			  <tbody>
			  <tr>
			    <td align="left" width="400">
			      <a href="http://www.ci-interiordecor.com" target="_blank" style="text-decoration:none;color:#ffffff;">
		            <img style="font-size:34px;font-weight:bold;color:#ffffff;" src="http://www.ci-interiordecor.com/img/emails/ci.png" alt="Ci-interiordecor" height="30">
		          </a>
			    </td>
			  </tr>
			  </tbody>
			</table>

			<table style="padding:0px 10px;padding-top:75px;" border="0" cellpadding="0" width="100%">
				<tbody>
				  <tr>
					<td align="center" width="400">
					  <table align="center" border="0" cellpadding="0" cellspacing="0" height="90" width="400">
					    <tbody>
					      <tr>
						    <td width="400" align="center"><img src="http://www.ci-interiordecor.com/img/emails/order.png" alt="Encomenda" height="130"></td>
						  </tr>
						</tbody>
					  </table>
				    </td>
				  </tr>
				</tbody>
			</table>

			<table style="padding:0px 10px;padding-top:50px;" border="0" cellpadding="0" width="100%">
				<tbody>
				  <tr>
					<td align="center" width="400">
					  <table align="center" border="0" cellpadding="0" cellspacing="0" width="400">
					    <tbody>
					      <tr>
						    <td width="400" align="center" style="color:#222222;font-size:14px;line-height:20px;">A sua encomenda<br>'.$tracking.'<br>foi efectuada com sucesso.</td>
						  </tr>
						</tbody>
					  </table>
				    </td>
				  </tr>
				</tbody>
			</table>

			<table style="padding-top:50px;" border="0" cellpadding="0" width="100%">
				<tbody>
				  <tr>
					<td align="center" width="400">
					  <table align="center" border="0" cellpadding="6" cellspacing="0" width="400" style="border-collapse:collapse;">
					    <tbody>
					      <tr>
						    <td align="center" style="color:#666666;font-size:12px;border:1px solid #cccccc;"><b>Produto</b></td>
						    <td align="center" style="color:#666666;font-size:12px;border:1px solid #cccccc;"><b>Qt</b></td>
						    <td align="center" style="color:#666666;font-size:12px;border:1px solid #cccccc;"><b>Preço</b></td>
						    <td align="center" style="color:#666666;font-size:12px;border:1px solid #cccccc;"><b>Subtotal</b></td>
						  </tr>
						  '.$itens.'
						  <tr>
							<td></td>
							<td></td>
							<td align="center" style="color:#666666;font-size:12px;"><b>Transporte</b></td>
							<td align="center" style="color:#666666;font-size:12px;border:1px solid #cccccc;white-space:nowrap;">'.$portes.' €</td>
						  </tr>
						  <tr>
							<td></td>
							<td></td>
							<td align="center" style="color:#666666;font-size:12px;"><b>Total</b></td>
							<td align="center" style="color:#666666;font-size:12px;border:1px solid #cccccc;white-space:nowrap;"><b>'.$total.' €</b></td>
						  </tr>
						</tbody>
					  </table>
				    </td>
				  </tr>
				</tbody>
			</table>

			<table style="padding:0px 10px;padding-top:50px;" border="0" cellpadding="0" width="100%">
				<tbody>
				  <tr>
					<td align="center" width="400">
					  <table align="center" border="0" cellpadding="0" cellspacing="0" width="400">
					    <tbody>
					      <tr>
						    <td width="400" align="center" style="color:#222222;font-size:14px;line-height:20px;">Obrigado.</td>
						  </tr>
						</tbody>
					  </table>
				    </td>
				  </tr>
				</tbody>
			</table>

			<table style="padding:0px 10px;padding-top:50px;" border="0" cellpadding="0" width="100%">
				<tbody>
				  <tr>
					<td align="center" width="400">
					  <table align="center" border="0" cellpadding="0" cellspacing="0" width="400">
					    <tbody>
					      <tr>
						    <td width="400" align="center" style="color:#222222;font-size:14px;line-height:20px;">
						    	Pode acompanhar o estado da sua encomenda em:<br>
						    	<a href="http://www.ci-interiordecor.com/tracking" target="_blank" style="text-decoration:none;color:#0099A8;">
					            	http://www.ci-interiordecor.com/tracking
					            </a>
						    </td>
						  </tr>
						</tbody>
					  </table>
				    </td>
				  </tr>
				</tbody>
			</table>

			<table style="padding:0px 10px;padding-top:75px;" border="0" cellpadding="0" width="100%">
				<tbody>
				  <tr>
					<td align="center" width="400">
					  <table align="center" border="0" cellpadding="0" cellspacing="0" width="400">
					    <tbody>
					      <tr>
						    <td width="400" align="center"  style="color:#666666;font-size:11px;line-height:15px;">
						    	Para mais informações, envie um email para 
						    	<a href="mailto:geral@ci-interiordecor.com?subject=Encomenda '.$tracking.'" target="_blank" style="text-decoration:none;color:#0099A8;">
					            geral@ci-interiordecor.com</a> mencionando o número de encomenda.
							</td>
						  </tr>
						</tbody>
					  </table>
				    </td>
				  </tr>
				</tbody>
			</table>

			<table style="padding-top:50px;" border="0" cellpadding="0" width="100%">
				<tbody>
				  <tr>
					<td align="center" width="400">
				    </td>
				  </tr>
				</tbody>
			</table>

		</body>
		</html>
		';
}
if($LANG=='en'){
	$assunto="Order made successfully";
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
		<body style="width:100%;background-color:#ffffff;margin:0;padding:0;font-size:14px;-webkit-font-smoothing:antialiased;cursor:default;color:#222222;">

			<table style="background:#222222;padding:20px 10px;" border="0" cellpadding="0" width="100%">
			  <tbody>
			  <tr>
			    <td align="left" width="400">
			      <a href="http://www.ci-interiordecor.com" target="_blank" style="text-decoration:none;color:#ffffff;">
		            <img style="font-size:34px;font-weight:bold;color:#ffffff;" src="http://www.ci-interiordecor.com/img/emails/ci.png" alt="Ci-interiordecor" height="30">
		          </a>
			    </td>
			  </tr>
			  </tbody>
			</table>

			<table style="padding:0px 10px;padding-top:75px;" border="0" cellpadding="0" width="100%">
				<tbody>
				  <tr>
					<td align="center" width="400">
					  <table align="center" border="0" cellpadding="0" cellspacing="0" height="90" width="400">
					    <tbody>
					      <tr>
						    <td width="400" align="center"><img src="http://www.ci-interiordecor.com/img/emails/order.png" alt="Order" height="130"></td>
						  </tr>
						</tbody>
					  </table>
				    </td>
				  </tr>
				</tbody>
			</table>

			<table style="padding:0px 10px;padding-top:50px;" border="0" cellpadding="0" width="100%">
				<tbody>
				  <tr>
					<td align="center" width="400">
					  <table align="center" border="0" cellpadding="0" cellspacing="0" width="400">
					    <tbody>
					      <tr>
						    <td width="400" align="center" style="color:#222222;font-size:14px;line-height:20px;">Your order<br>'.$tracking.'<br>was successful.</td>
						  </tr>
						</tbody>
					  </table>
				    </td>
				  </tr>
				</tbody>
			</table>

			<table style="padding-top:50px;" border="0" cellpadding="0" width="100%">
				<tbody>
				  <tr>
					<td align="center" width="400">
					  <table align="center" border="0" cellpadding="6" cellspacing="0" width="400" style="border-collapse:collapse;">
					    <tbody>
					      <tr>
						    <td align="center" style="color:#666666;font-size:12px;border:1px solid #cccccc;"><b>Product</b></td>
						    <td align="center" style="color:#666666;font-size:12px;border:1px solid #cccccc;"><b>Qt</b></td>
						    <td align="center" style="color:#666666;font-size:12px;border:1px solid #cccccc;"><b>Price</b></td>
						    <td align="center" style="color:#666666;font-size:12px;border:1px solid #cccccc;"><b>Subtotal</b></td>
						  </tr>
						  '.$itens.'
						  <tr>
							<td></td>
							<td></td>
							<td align="center" style="color:#666666;font-size:12px;"><b>Shipping</b></td>
							<td align="center" style="color:#666666;font-size:12px;border:1px solid #cccccc;white-space:nowrap;">'.$portes.' €</td>
						  </tr>
						  <tr>
							<td></td>
							<td></td>
							<td align="center" style="color:#666666;font-size:12px;"><b>Total</b></td>
							<td align="center" style="color:#666666;font-size:12px;border:1px solid #cccccc;white-space:nowrap;"><b>'.$total.' €</b></td>
						  </tr>
						</tbody>
					  </table>
				    </td>
				  </tr>
				</tbody>
			</table>

			<table style="padding:0px 10px;padding-top:50px;" border="0" cellpadding="0" width="100%">
				<tbody>
				  <tr>
					<td align="center" width="400">
					  <table align="center" border="0" cellpadding="0" cellspacing="0" width="400">
					    <tbody>
					      <tr>
						    <td width="400" align="center" style="color:#222222;font-size:14px;line-height:20px;">Thank you.</td>
						  </tr>
						</tbody>
					  </table>
				    </td>
				  </tr>
				</tbody>
			</table>

			<table style="padding:0px 10px;padding-top:50px;" border="0" cellpadding="0" width="100%">
				<tbody>
				  <tr>
					<td align="center" width="400">
					  <table align="center" border="0" cellpadding="0" cellspacing="0" width="400">
					    <tbody>
					      <tr>
						    <td width="400" align="center" style="color:#222222;font-size:14px;line-height:20px;">
						    	You can track the status of your order at:<br>
						    	<a href="http://www.ci-interiordecor.com/tracking" target="_blank" style="text-decoration:none;color:#0099A8;">
					            	http://www.ci-interiordecor.com/tracking
					            </a>
						    </td>
						  </tr>
						</tbody>
					  </table>
				    </td>
				  </tr>
				</tbody>
			</table>

			<table style="padding:0px 10px;padding-top:75px;" border="0" cellpadding="0" width="100%">
				<tbody>
				  <tr>
					<td align="center" width="400">
					  <table align="center" border="0" cellpadding="0" cellspacing="0" width="400">
					    <tbody>
					      <tr>
						    <td width="400" align="center"  style="color:#666666;font-size:11px;line-height:15px;">
						    	For more information, send an email to 
						    	<a href="mailto:geral@ci-interiordecor.com?subject=Encomenda '.$tracking.'" target="_blank" style="text-decoration:none;color:#0099A8;">
					            geral@ci-interiordecor.com</a> mentioning the order number.
							</td>
						  </tr>
						</tbody>
					  </table>
				    </td>
				  </tr>
				</tbody>
			</table>

			<table style="padding-top:50px;" border="0" cellpadding="0" width="100%">
				<tbody>
				  <tr>
					<td align="center" width="400">
				    </td>
				  </tr>
				</tbody>
			</table>

		</body>
		</html>
		';
}
include('admin/funcao/email.php');
?>

<article class="alturaM">
	<section class="sucesso-titulo"><? if($LANG=='pt'){echo "Obrigado pela sua encomenda.";} if($LANG=='en'){echo "Thank you for your order.";} ?></section>
	<section>
		<div class="sucesso-texto">
			<? if($LANG=='pt'){ ?>
				Assim que verificarmos o seu pagamento a sua encomenda será enviada.<br>
				Pode acompanhar a sua encomenda em <b><a href="http://www.ci-interiordecor.com/tracking">http://www.ci-interiordecor.com/tracking</a></b>, inserindo a seguinte referência <b><?echo $tracking;?></b>.
				<br><a href="/" class="sucesso-bt">VOLTAR AO WEBSITE</a>
			<? } if($LANG=='en'){ ?>
				Once we verify your payment your order will be sent.<br>
				You can track your order in <b><a href="http://www.ci-interiordecor.com/tracking">http://www.ci-interiordecor.com/tracking</a></b>, inserting the following reference <b><?echo $tracking;?></b>.
				<br><a href="/" class="sucesso-bt">BACK TO THE WEBSITE</a>
			<? } ?>			
		</div>
		<div class="sucesso-logo"></div>
		<div class="clear"></div>
	</section>
	<div class="clear"></div>
</article>
<? include '_footer.php';?>
</body>
</html>