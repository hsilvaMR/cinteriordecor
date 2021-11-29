
<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Ci | Interior Decor</title>

<? include '_head.php';?>

<!-- FACEBOOK -->
<?php $linha = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM home WHERE online = 1 ORDER BY rand()"));	
$id = $linha['id'];
$titulo = $linha['titulo_'.$LANG];
$img = $linha['img']; ?>
<meta property="og:title" content="Ci | Interior Decor"/>
<meta property="og:url" content="http://www.ci-interiordecor.com"/>
<meta property="og:image" content="http://www.ci-interiordecor.com/img/faceImagem.png"/>
<meta property="og:description" content="Ci como carinhosamente lhe chamam algumas das pessoas mais importantes da sua vida.
Cidalia Araújo é licenciada em Engenharia Civil pela Universidade do Minho. Nesta área, desempenha funções desde 2004 numa empresa de construção civil, o que lhe proporciona uma grande capacidade de comunicação e negociação, contacto com os mercados internacionais e um vasto conhecimento de marcas e tipologias dos mais diversificados materiais de construção."/>
<meta property="og:type" content="website" />
<!--<meta property="fb:app_id" content="270040710562913"/>-->

<link rel="canonical" href="http://www.ci-interiordecor.com" />
<script>
  $(document).ready(function(){ $.post('https://graph.facebook.com',{id:'http://www.ci-interiordecor.com',scrape:true},function(response){console.log(response);});});
</script>
</head>

<body>
<? include '_header.php'; ?>

<?
	$url = $_SERVER['REQUEST_URI'];
	$urlPartes = explode("/", $url);

	$token = urldecode($urlPartes[2]);
?>

<div id="new_password_RESTORE" class="modal" style="visibility:visible;">
	<div class="modalFundo"></div>
	<div class="modalScroll"></div>
	<div class="news-size-NEW">
		<div style="padding:0px 40px;margin-bottom:20px;">
			<div class="news-close-NEW" onClick="fecharPasswordRes();"></div>
			<h3 class="textl"><? if($LANG=='pt'){echo "NOVA PASSWORD";} if($LANG=='en'){echo "NEW PASSWORD";} ?></h3>
		
			<input id="NEW_PASS" name="NEW_PASS" type="text"  placeholder="<? if($LANG=='pt'){echo "PASSWORD";} if($LANG=='en'){echo "PASSWORD";} ?>"/><br>
		</div>

		<label id="erro_new_pass" class="none vermelho"></label>
		<label id="sucesso_new_pass" class="none textl verde"></label>

		<div style="height:50px;margin-top:40px;">
			<label class="label_entrar" onclick="restorePassword('<? echo $token?>');" style="width:100%;"><? if($LANG=='pt'){echo "GUARDAR";} if($LANG=='en'){echo "SAVE";} ?></label>
		</div>
	</div>
</div>

<!-- HOME -->
<div class="home" style="background:url('<? echo "$img";?>')no-repeat 50% 50%;background-size:cover;">
	<div class="sombraTop"></div>
	<div class="homeCentro">
		<div class="homeCont">
			<section>
				<div class="hometit"><? echo nl2br("$titulo");?></div>
				<a href="/projectos"><input type="button" class="homeBt" value="<? if($LANG=='pt'){echo "SABER MAIS";} if($LANG=='en'){echo "LEARN MORE";} ?>"></a>
				<div class="clear"></div>
			</section>
		</div>
	</div>
	<a href="https://www.apcergroup.com/portugal/index.php/pt/certificacao/40/iso-9001" class="footer-certificacao" target="_blank"><img src="/img/certificacao.png"></a>
	<a href="/pt2020" class="footer-pt2020"><img src="/img/portugal2020.svg"></a>
	<div class="sombraBottom"></div>
</div>
</body>
</html>

<script>
function fecharPasswordRes()
{
	esconder('new_password_RESTORE');
	window.location.href = "http://www.ci-interiordecor.com";
}

function restorePassword($token){
	var token = $token;
	var password = $('#NEW_PASS').val();

	$.post("/_login/js_restorePass.php",{ token:token, password:password })
	.done(function( data ) {
		var jsonRetorna = $.parseJSON(data);
		var aviso = jsonRetorna['aviso'];

		if(aviso == 'SUCESSO') {
			$('#NEW_PASS').val('');
			$('#erro_new_pass').hide();
			$('#sucesso_new_pass').show();
			$('#sucesso_new_pass').html('Alterado com sucesso! Inicie Sessão.');
		}
		else {
			$('#erro_new_pass').html(aviso);
			$('#erro_new_pass').show();
			$('#sucesso_new_pass').hide();
		}
	});	
}
</script>