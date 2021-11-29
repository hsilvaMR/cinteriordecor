
<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Ci | Interior Decor</title>
<? include '_head.php';?>
</head>

<body>
<? $sepCor='tracking'; include '_header.php';include '_login.php';
	include '_register.php';
	include '_new-password.php';
	include '_modal-boas-vindas.php';?>
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
?>
<article class="alturaM">
	<section class="sucesso-titulo"><? if($LANG=='pt'){echo "Acompanhar Encomenda";} if($LANG=='en'){echo "Order Tracking";} ?></section>
	<section>
		<div class="sucesso-texto">
			<? if($LANG=='pt'){echo "Insira a referência da encomenda para verificar o seu estado.";} if($LANG=='en'){echo "Enter the order reference number to check its status.";} ?>			
			<br><input type="text" id="tracking" class="tracking-input" value="" placeholder="<? if($LANG=='pt'){echo "Encomenda";} if($LANG=='en'){echo "Order";} ?>" onKeyPress="if(event.keyCode == 13){tracking();}">
			<button class="sucesso-bt" onClick="tracking();"><? if($LANG=='pt'){echo "PROCURAR";} if($LANG=='en'){echo "SEARCH";} ?></button>
		</div>
		<div id="RESULTADO"></div>
		<div class="sucesso-logo"></div>
		<div class="clear"></div>
	</section>
	<div class="clear"></div>
</article>
<? include '_footer.php';?>
<script type="text/javascript">
function tracking()
{
	var tracking = $('#tracking').val();
	jQuery.ajax({
	 type: "POST",
	 url: "/_tracking/consulta.php",
	 data: 'tracking='+tracking,
	 success: function(data){
	   $("#RESULTADO").html(data);
	 }
	});
}
</script>
</body>
</html>