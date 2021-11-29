<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Ci | Interior Decor</title>
<? include '_head.php';?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAd7Lc4QqOTkbCHRMKl1mCqSEk8kM-_N4Y"></script>
<script type="text/javascript" src="js/maps/map.js"></script>
</head>

<body>
<? $sepCor='contactos'; include '_header.php';?>
<div class="barraH"></div>
<article>
	<div id="canva" class="mapa">
		<div id="map-canvas" class="mapaScrolloff"></div>
	</div>
	<section>
		<h1>CI - INTERIOR DECOR</h1>
		<div class="moradas">
			<div class="morada morada1">
				<span class="moradaTit">PORTUGAL</span>
				<div class="clear"></div>
				<div class="casa"></div>Rua de S.Domingos<br>&emsp;&emsp;&ensp;&nbsp;178 4710-435 Braga
				<div class="clear"></div>
				<div class="telefone"></div>+351 253 295 674
				<div class="clear"></div>
				<div class="carta"></div><a href="mailto:geral@ci-interiordecor.com?Subject=Contacto" target="_top">geral@ci-interiordecor.com</a>
			</div>
			<!--<div class="morada morada2">
				<span class="moradaTit">PORTUGAL&nbsp;</span>
				<div class="clear"></div>
				<div class="casa"></div>Rua do Ouro, 384 4150-553 Porto
				<div class="clear"></div>
				<div class="telefone"></div>+351 223 213 158
				<div class="clear"></div>
				<div class="carta"></div><a href="mailto:geral@ci-interiordecor.com?Subject=Contacto" target="_top">geral@ci-interiordecor.com</a>
			</div>-->
			<div class="morada morada3">
				<span class="moradaTit">ANGOLA</span>
				<div class="clear"></div>
				<div class="casa"></div>Urbanização Lar do Patriota<br>&emsp;&emsp;&ensp;&nbsp;Rua n.º1<br>&emsp;&emsp;&ensp;&nbsp;Prédio do Vidro B, loja 3
					<!--Rua Rainha Ginga, Coqueiro - Luanda-->
				<div class="clear"></div>
				<div class="telefone"></div>+244 930 163 328<br>&emsp;&emsp;&ensp;&nbsp;+244 924 973 974
				<div class="clear"></div>
				<div class="carta"></div><a href="mailto:geral@ci-interiordecor.com?Subject=Contacto" target="_top">geral@ci-interiordecor.com</a>
			</div>
			<div class="clear"></div>
		</div>
	</section>
	<div class="clear"></div>
</article>
<? $sepCor='contactos'; include '_footer.php';?>
<script>
$(document).ready(function () {
    $('#canva').on('click', function () { $('#map-canvas').removeClass('mapaScrolloff'); });
    $("#map-canvas").mouseleave(function () { $('#map-canvas').addClass('mapaScrolloff'); });
});
</script>
</body>
</html>