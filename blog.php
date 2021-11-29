<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Ci | Interior Decor</title>
<? include '_head.php';?>

<!-- SLIDE -->
<link rel="stylesheet" href="/slide/slider.css" type="text/css"> 		
<!--<script type="text/javascript" src="/slide/jquery.api.js"></script>-->
<script type="text/javascript" src="/slide/jquery.bxslider.js"></script>
<script>
$(document).ready(function(){
   $('.slide_noticias').bxSlider({
    mode: 'horizontal',
	pager: false,
	controls: true,
	//autoHover: true,
	auto: false,
	speed: 500,
	pause: 6000,
  });
});
</script>
</head>

<body>
<? $sepCor='blog'; include '_header.php';include '_login.php';
	include '_register.php';
	include '_new-password.php';
	include '_modal-boas-vindas.php';?>
<div class="barraH"></div>
<article>
	<div class="slide_noticias">
		<?php
		$query = mysqli_query($lnk, "SELECT * FROM noticia WHERE online = 1 ORDER BY publicacao DESC");	
		while ($linha = mysqli_fetch_array($query))
		{
			$id = $linha['id'];
			$titulo = $linha['titulo_'.$LANG];
			$noticia = $linha['noticia_'.$LANG];
			$criacao = $linha['criacao'];
			$publicacao = $linha['publicacao'];
			if($criacao!='0000-00-00'){ if($LANG=='pt'){ $data="Criado: $criacao"; } if($LANG=='en'){ $data="Created: $criacao"; } }
			if($publicacao!='0000-00-00'){ if($LANG=='pt'){ $data="Publicado: $publicacao"; } if($LANG=='en'){ $data="Published: $publicacao"; } }
			$img = $linha['img'];
			?>
			<div class="noticia" style="background:url('<? echo "$img";?>')no-repeat 100% center;background-size:cover;">
				<div class="notiCont">
					<div class="notiCont2">
						<div class="notTit"><? echo nl2br("$titulo");?></div>
						<div class="notNot"><? echo nl2br("$noticia");?></div>
						<div class="notDat"><? echo $data;?></div>
					</div>
				</div>
			</div><?php 
		} ?>
	</div>
	<div class="clear"></div>
</article>

<button id="myBtn">Top</button>
 <script>
 // scroll to top 
$('#myBtn').on('click', function() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
});

window.onscroll = function() {

    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        $('#myBtn').css("display", "block");
    } else {
        $('#myBtn').css("display", "none");
    }
}
 </script>

<? include '_footer.php';?>
</body>
</html>