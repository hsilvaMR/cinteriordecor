<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Ci | Interior Decor</title>
<? include '_head.php';?>
</head>

<body>
<? $sepCor='projectos'; 
	include '_header.php'; 
	include '_login.php';
	include '_register.php';
	include '_new-password.php';
	include '_modal-boas-vindas.php';
?>
<div class="barraH"></div>
<article class="fundoC">
	<?php
	$query = mysqli_query($lnk, "SELECT * FROM projeto WHERE online = 1 ORDER BY ordem ASC");	
	while ($linha = mysqli_fetch_array($query))
	{
		$id = $linha['id'];
		$titulo = $linha['titulo_'.$LANG];
		$url_titulo = str_replace(" ", "-", $titulo);
		$url_titulo = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$url_titulo);
		$linha2 = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM projeto_gal WHERE id_projeto = '$id' AND capa = 1 AND online = 1"));
		$img = $linha2['img'];
		if(!$img){
			$linha2 = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM projeto_gal WHERE id_projeto = '$id' AND online = 1"));
			$img = $linha2['img'];
		} ?>
		<a href="projecto/<? echo "$id/$url_titulo";?>">
			<div class="projeto" style="background:url('<? echo "$img";?>')no-repeat 50% 50%;background-size:cover;">
				<div class="projSomb"><? echo nl2br("$titulo");?></div>
			</div>
		</a>
		<?php 
	} ?>
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