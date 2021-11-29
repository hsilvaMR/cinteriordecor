<?php
include('../../_connect.php');
include('../funcao/upload_img.php');
session_start();

$id = $_POST["id"];
$id_tracking_est = $_POST["id_tracking_est"];


if($_FILES['ficheiro']['name']){
	
	$arquivo_tmp = $_FILES['ficheiro']['tmp_name'];
	$arquivo_name = $_FILES['ficheiro']['name'];
	$extensao = strrchr($arquivo_name, '.');
	$extensao = strtolower($extensao);
	if(strstr('.pdf;.docx', $extensao)){
		$novoNome = $id."000";
		$nomeExiste = 'sim';
		while($nomeExiste=='sim'){
			$novoNome++;
			if(strlen($novoNome)==6){$novoNome = "0".$novoNome;}
			if(strlen($novoNome)==5){$novoNome = "00".$novoNome;}
			if(strlen($novoNome)==4){$novoNome = "000".$novoNome;}
			$nome_imagem = "/img/encomendas_faturas/".$novoNome.$extensao;

			$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda WHERE fatura='$nome_imagem'"));
			if(!$numero){$nomeExiste='nao';}
		}
		$destino = '../..'.$nome_imagem;
		move_uploaded_file($arquivo_tmp, $destino); 
		mysqli_query($lnk,"UPDATE venda SET fatura='$nome_imagem' WHERE id='$id'");

	}
	
}

$data = date('Y-m-d');
if($id_tracking_est){ mysqli_query($lnk, "INSERT INTO tracking(id_venda,id_tracking_est,data) VALUES ('$id','$id_tracking_est','$data')"); }

extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM venda WHERE id='$id'")));
$paraNome = $nome;
$paraEmail = $email;
$assunto='';

switch ($id_tracking_est) {
    case "2": //Pagamento recebido
    	$assunto="Pagamento efectuado com sucesso";
    	$img ='<img src="http://www.ci-interiordecor.com/img/emails/pay.png" alt="Pagamento" height="130">';
    	$msg ='O pagamento da sua encomenda<br>'.$tracking.'<br>foi efectuado com sucesso.';
        break;
    case "3": //Encomenda em produção
    	$assunto="Encomenda em produção";
    	$img ='<img src="http://www.ci-interiordecor.com/img/emails/prod.png" alt="Produção" height="130">';
    	$msg ='A sua encomenda<br>'.$tracking.'<br>encontra-se em fase de produção.';
        break;
    case "4": //Encomenda enviada
    	$assunto="Encomenda enviada";
    	$img ='<img src="http://www.ci-interiordecor.com/img/emails/sent.png" alt="Envio" height="130">';
    	$msg ='A sua encomenda<br>'.$tracking.'<br>foi enviada.';
        break;
    case "5": //Encomenda enviada parcialmente
    	$assunto="Encomenda enviada parcialmente";
    	$img ='<img src="http://www.ci-interiordecor.com/img/emails/sent.png" alt="Envio" height="130">';
    	$msg ='A sua encomenda<br>'.$tracking.'<br>foi enviada parcialmente.';
        break;
    case "7": //Encomenda cancelada
    	$assunto="Encomenda cancelada";
    	$img ='<img src="http://www.ci-interiordecor.com/img/emails/cancel.png" alt="Cancelamento" height="130">';
    	$msg ='A sua encomenda<br>'.$tracking.'<br>foi cancelada.';
        break;
    case "8": //Encomenda concluída
    	$assunto="Encomenda concluída";
    	$img ='<img height="375" src="http://www.ci-interiordecor.com/img/emails/fd_email.jpg">';
    	$msg ='Caro Cliente,<br><br>A sua opinião é importante para nós.<br>Com base nela procuramos melhorar continuamente os nossos serviços. Para que tal seja possível,<br>pedimos que responda ao seguinte inquérito, avaliando a sua experiência.<br><br>Com a sua avaliação, presenteamo-lo com um voucher de 10% de desconto numa próxima compra.<br>Este desconto é pessoal e intransmissível com uma validade de 45 dias. Para o receber, é necessário o seu registo na loja online.<br><br>Obrigado por comprar na Ci!<br><br>Inquérito – Link do google forms:<br><br><a href="https://docs.google.com/forms/d/e/1FAIpQLSctNZmRmp7zQTweEL2fvuhpP3VQp00Hj7_W_pet9VsK60bg4A/viewform" style="text-decoration:none;color:#0099A8;">https://docs.google.com/forms/d/e/1FAIpQLSctNZmRmp7zQTweEL2fvuhpP3VQp00Hj7_W_pet9VsK60bg4A/viewform<\a>';
        break;
    //default: //1-Encomenda online registada //5-Encomenda entregue //7-Compra concluída
}

if($assunto && $id_tracking_est!='8'){
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
		    <td align="center" width="400">
		      <a href="http://www.ci-interiordecor.com" target="_bank" style="text-decoration:none;color:#ffffff;">
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
					    <td width="400" align="center">'.$img.'</td>
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
					    <td width="400" align="center" style="color:#222222;font-size:14px;line-height:20px;">'.$msg.'</td>
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
					    	<a href="http://www.ci-interiordecor.com/tracking" target="_bank" style="text-decoration:none;color:#0099A8;">
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
					    	<a href="mailto:geral@ci-interiordecor.com?subject=Encomenda '.$tracking.'" target="_bank" style="text-decoration:none;color:#0099A8;">
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

	include('../funcao/email.php');
}else{
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
		    <td align="center" width="400">
		      <a href="http://www.ci-interiordecor.com" target="_bank" style="text-decoration:none;color:#ffffff;">
	            <img style="font-size:34px;font-weight:bold;color:#ffffff;" src="http://www.ci-interiordecor.com/img/emails/ci.png" alt="Ci-interiordecor" height="30">
	          </a>
		    </td>
		  </tr>
		  </tbody>
		</table>

		

		<table style="padding:0px 10px;padding-top:50px;" border="0" cellpadding="0" width="100%">
			<tbody>
			  <tr>
				<td width="400">
				  <table align="center" border="0" cellpadding="0" cellspacing="0" width="400">
				    <tbody>
				      <tr>
					    <td width="400" align="left" style="color:#666666;font-size:16px;line-height:24px;">'.$msg.'</td>
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

		<table style="padding:0px 10px;padding-top:75px;" border="0" cellpadding="0" width="100%">
			<tbody>
			  <tr>
				<td align="center" width="400">
				  <table align="center" border="0" cellpadding="0" cellspacing="0" width="400">
				    <tbody>
				      <tr>
					    <td width="400" align="center"  style="color:#666666;font-size:12px;line-height:15px;">
					    	Deixe a sua avaliação nas nossas redes sociais
						</td>
					  </tr>
					</tbody>
				  </table>
			    </td>
			  </tr>
			</tbody>
		</table>

		<table style="padding:0px 10px;padding-top:30px;" border="0" cellpadding="0" width="100%">
			<tbody>
			  <tr>
				<td align="center" width="400">
				  <table align="center" border="0" cellpadding="0" cellspacing="0" width="400">
				    <tbody>
				      <tr>
					    <td width="400" align="center"  style="color:#666666;font-size:11px;line-height:15px;">
					    	<a href="https://www.facebook.com/ci.interiordecor">
					    		<img src="http://www.ci-interiordecor.com/img/emails/icon_face.png" alt="facebook" height="75">
					    	</a>
					    	<a href="https://www.instagram.com/ci.interiordecor/">
					    		<img src="http://www.ci-interiordecor.com/img/emails/icon_insta.png" alt="instagram" height="75">
					    	</a>
					    	<a href="https://pt.linkedin.com/in/ci-interior-decor-97585a150">
					    		<img src="http://www.ci-interiordecor.com/img/emails/icon_lk.png" alt="linkedin" height="75">
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
					    	<a href="mailto:geral@ci-interiordecor.com?subject=Encomenda '.$tracking.'" target="_bank" style="text-decoration:none;color:#0099A8;">
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

	include('../funcao/email.php');
}

echo $id;
?>