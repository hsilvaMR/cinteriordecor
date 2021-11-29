<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Ci | Interior Decor</title>
<? include '_head.php';?>

</head>

<body>
<? $sepCor='contactos'; include '_header.php';include '_login.php';
	include '_register.php';
	include '_new-password.php';
	include '_modal-boas-vindas.php';?>
<div class="barraH"></div>
<article>
	<div id="map" class="mapa">
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
				<div class="clear"></div>
				<div class="caneta"></div>NIPC 510266835
				
				
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
				<div class="telefone"></div>+244 929 535 554<br>&emsp;&emsp;&ensp;&nbsp;+244 924 973 974
				<div class="clear"></div>
				<div class="carta"></div><a href="mailto:geral@ci-interiordecor.com?Subject=Contacto" target="_top">geral@ci-interiordecor.com</a>
			</div>
			<div class="clear"></div>
		</div>
	</section>
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

<? $sepCor='contactos'; include '_footer.php';?>
<script>
function initMap() {
    var myLatLng  = {lat: 41.557285, lng: -8.414971};
    var map = new google.maps.Map(document.getElementById('map'), {
      center: myLatLng ,
      zoom: 15
    });
    var marker = new google.maps.Marker({
      position: myLatLng ,
      map: map,
      title: 'Ci-Interior',
      //icon: image
    });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAd7Lc4QqOTkbCHRMKl1mCqSEk8kM-_N4Y&callback=initMap" async defer></script>
</script>
</body>
</html>