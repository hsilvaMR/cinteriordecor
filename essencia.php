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
   $('.slide_essencia').bxSlider({
    mode: 'fade',
	pager: false,
	controls: false,
	auto: true,
	speed: 500,
	pause: 6000,
  });
});
</script>
</head>

<body>
<? 
	$sepCor='essencia'; 
	include '_header.php';
	include '_login.php';
	include '_register.php';
	include '_new-password.php';
	include '_modal-boas-vindas.php';
?>
<div class="barraH"></div>
<article>
	<section>
		<div class="slide_essencia">
		<?php
		$query = mysqli_query($lnk, "SELECT * FROM essencia WHERE online = 1 ORDER BY rand()");	
		while ($linha = mysqli_fetch_array($query)){
			$img = $linha['img']; ?>
			<div class="essenciaFoto" style="background-image:url('<? echo "$img";?>');"></div>
			<?php 
		} ?>
		</div>

	</section>
	<section>
		<div class="essenciaLeft"></div>
		<div class="essenciaRight">
			<? if($LANG=='pt'){echo "<i>“A essência?... o sonho de um dia poder criar!“</i>
			<br>Ci como carinhosamente lhe chamam algumas das pessoas mais importantes da sua vida.
			<br>Cidalia Araújo é licenciada em Engenharia Civil pela Universidade do Minho. Nesta  área, desempenha funções desde 2004 numa empresa de construção civil, o que lhe proporciona uma grande capacidade de comunicação e negociação, contacto com os mercados internacionais e um vasto conhecimento de marcas e tipologias dos mais diversificados materiais de construção. 
			<br>A paixão pela moda e pelo design fez com que perseguisse um outro sonho. Haveria de um dia criar a sua própria marca no mundo da Decoração de Interiores. Ao gosto pessoal juntou formação específica para responder com profissionalismo às necessidades dos clientes e de cada projecto. Com enorme persistência, entrega e paixão, já com projectos desenvolvidos a nível internacional, a Ci é já uma referência, com vontade de se tornar maior e melhor todos os dias!";}
			if($LANG=='en'){echo "<i>“The essence?... the dream of one day being able to create!“</i>
			<br>Ci, as she is affectionately called by some of the most important people of her life.
			<br>Cidalia Araújo holds a Civil Engineering degree from the University of Minho. In this area, she has held functions since 2004 in a civil construction company, which has provided her with a great ability for communication and negotiation, contact with international markets and extensive knowledge of brands and typologies of the most diverse construction materials.
			<br>The passion for fashion and design made her pursue another dream. She would one day create her own brand in the interior decoration world. To her personal taste she added specific training to respond with professionalism to the needs of the clients and of each project. With enormous persistence, dedication and passion, already with projects developed internationally, Ci is alredy a reference, with the will to become bigger and better every day!";} ?>
		</div>
		<div class="clear"></div>
	</section>
	<section>
		<div class="essenciaTit"><? if($LANG=='pt'){echo "SERVIÇOS";} if($LANG=='en'){echo "SERVICES";} ?></div>
		<div class="essenciaServicos">
			<div class="essenciaS1">
				<div class="essenciaCirc1" onClick=""><? if($LANG=='pt'){echo "Representamos a 3 dimensões o espaço decorado e projectado <br>pela nossa equipa.";} if($LANG=='en'){echo "We will <br>represent in 3D the <br>space decorated and <br>designed by our <br>team.";} ?></div>
				<? if($LANG=='pt'){echo "Projectos 3D";} if($LANG=='en'){echo "3D Projects";} ?>
			</div>
			<div class="essenciaS2">
				<div class="essenciaCirc2" onClick=""><? if($LANG=='pt'){echo "Desenhamos e <br>produzimos mobiliário personalizado. A sua peça pode ser única.";} if($LANG=='en'){echo "We design and <br>produce custom <br>furniture. Your piece <br>can be unique.";} ?></div>
				<? if($LANG=='pt'){echo "Mobiliário Personalizado";} if($LANG=='en'){echo "Custom Furniture";} ?>
			</div>
			<div class="essenciaS2">
				<div class="essenciaCirc3" onClick=""><? if($LANG=='pt'){echo "Visitamos o seu <br>espaço e aconselhamos sobre as melhores <br>opções a tomar.";} if($LANG=='en'){echo "We visit <br>your space and advise <br>on the best options to make.";} ?></div>
				<? if($LANG=='pt'){echo "Consultoria";} if($LANG=='en'){echo "Consulting";} ?>
			</div>
			<div class="essenciaS4">
				<div class="essenciaCirc4" onClick=" "><? if($LANG=='pt'){echo "Mudamos a imagem <br>de um espaço, conciliando as suas peças com <br>outras novas.";} if($LANG=='en'){echo "We change the <br>image of any space, <br>uniting your pieces <br>with new ones.";} ?></div>
				<? if($LANG=='pt'){echo "Restyling";} if($LANG=='en'){echo "Restyling";} ?>
			</div>
			<div class="essenciaS2">
				<div class="essenciaCirc5" onClick=""><? if($LANG=='pt'){echo "Pretende novas peças decorativas mas tem dificuldade em encontrar, nós vamos consigo às compras!";} if($LANG=='en'){echo "Do you want new <br>decorative pieces but find <br>it difficult to find them, <br>we go shopping <br>with you!";} ?></div>
				<? if($LANG=='pt'){echo "Personal Shopping";} if($LANG=='en'){echo "Personal Shopping";} ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</section>
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