
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
<?  include '_header.php'; ?>
<? include '_login.php';?>
<? include '_register.php';?>
<? include '_new-password.php';?>
<? include '_modal-boas-vindas.php';?>

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