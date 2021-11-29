<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Ci | Interior Decor</title>
<? include '_head.php';?>

<!-- SLIDE -->
<link rel="stylesheet" href="/slide/sliderProj.css" type="text/css"> 		
<script type="text/javascript" src="/slide/jquery.api.js"></script>
<script type="text/javascript" src="/slide/jquery.bxslider.js"></script>
<script>
$(document).ready(function(){
   $('.slide_noticias').bxSlider({
    mode: 'horizontal',
	pager: false,
	controls: true,
	//autoHover: true,
	auto: false,
	speed: 1000,
	pause: 6000,
	minSlides:3,
	maxSlides:3,
	slideWidth:'1000/3',
	slideMargin:0,
  });
});
</script>
</head>

<body>
<? $sepCor='projectos'; include '_header.php';?>
<div class="barraH"></div>
<article>
	<?php
	$url_completo = $_SERVER['REQUEST_URI'];
	$url_partes = explode("/", $url_completo);
	$id_linha = urldecode($url_partes[2]);
	$id_linha = filter_var($id_linha, FILTER_VALIDATE_INT);
	$linha = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM projeto WHERE id = '$id_linha' AND online = 1"));	
	$id_projeto = $linha['id'];
	$nome = $linha['nome_'.$LANG];
	$query = mysqli_query($lnk, "SELECT * FROM projeto_gal WHERE id_projeto = '$id_linha' AND online = 1");
	$num = mysqli_num_rows($query);
	if($num==1){
		$linha1 = mysqli_fetch_array($query);
		$img = $linha1['img']; ?>
		<div class="proje" style="background:url('<? echo "$img";?>')no-repeat 50% 50%;background-size:cover;"></div>
		<?php
	}elseif ($num==2) {
		while ($linha2 = mysqli_fetch_array($query)){
			$img = $linha2['img'];
			?>
			<div class="proje" style="width:50%;float:left;background:url('<? echo "$img";?>')no-repeat 50% 50%;background-size:cover;"></div>
			<?php 
		}
	}elseif ($num==3) {
		while ($linha3 = mysqli_fetch_array($query)){
			$img = $linha3['img'];
			?>
			<div class="proje" style="width:33.33333%;float:left;background:url('<? echo "$img";?>')no-repeat 50% 50%;background-size:cover;"></div>
			<?php 
		}
	}else{
		?>
		<div class="slide_noticias">
			<?php	
			while ($linha2 = mysqli_fetch_array($query)){
				$img = $linha2['img'];
				?>
				<div class="proje" style="background:url('<? echo "$img";?>')no-repeat 50% 50%;background-size:cover;"></div>
				<?php 
			}
			?>
		</div>
		<?php
	} ?>
	<div class="projeCont">
		<div class="projeCont2">
			<div class="projeTit"><? echo $nome;?></div>
		</div>
	</div>
	<div class="clear"></div>
</article>
<? include '_footer.php';?>
</body>
</html>