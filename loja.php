<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Ci | Interior Decor</title>
<? include '_head.php';?>
</head>

<body>
<? $sepCor='loja'; 
	include '_header.php';
	include '_login.php';
	include '_register.php';
	include '_new-password.php';
	include '_modal-boas-vindas.php';
?>
<div class="barraH"></div>
<article>
	<div id="lojaHeader" class="lojaonline">
		<?
		$query = mysqli_query($lnk,"SELECT * FROM produto_cat WHERE online = 1 ORDER BY categoria_".$LANG." ASC");
		while($linha = mysqli_fetch_array($query))
		{
			$id = $linha["id"];
			$categoria = $linha["categoria_".$LANG];?>
			<div class="categoria" onClick="scrollDiv('<? echo $id?>','300');"><? echo $categoria;?></div>
			<?php 
		} ?>
	</div>
	<div class="lojaonline">
		<?
		$query = mysqli_query($lnk,"SELECT * FROM produto_cat WHERE online = 1 ORDER BY categoria_".$LANG." ASC");
		while($linha = mysqli_fetch_array($query))
		{
			$id = $linha["id"];
			$categoria = $linha["categoria_".$LANG];?>
			<div  class="categoria" onClick="scrollDiv('<? echo $id?>','300');"><? echo $categoria;?></div>
			<?php 
		} ?>
	</div>
	<section class="banners">
		<? $hoje=date('Y-m-d');
		$queryBanner = mysqli_query($lnk,"SELECT * FROM banner WHERE inicio<='$hoje' AND fim>='$hoje' AND (tlm!='' || pc!='') ORDER BY ordem ASC");
		while($linhaBanner = mysqli_fetch_array($queryBanner))
		{
			$id_ban=$linhaBanner["id"];
			$tlm_ban=$linhaBanner["tlm"];
			$pc_ban=$linhaBanner["pc"];
			$url_ban=$linhaBanner["url"];
			if(is_numeric($url_ban)){
				$linha_cat = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto_cat WHERE id='$url_ban'"));
				$id_cat_banner = $linha_cat["id"];
				$categoria_banner = $linha_cat["categoria_".$LANG];
				$url_banner = str_replace(" ", "-", $categoria_banner);
				$url_banner = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$url_banner);
				$url_banner = '/produtos/'.$id_cat_banner.'/'.$url_banner;
			}
			else{ $url_banner = $url_ban; }
			if($url_banner){?><a href="<? echo $url_banner;?>"><? }
			if($tlm_ban){?>
				<img  src="<? echo $tlm_ban;?>" class="banner <?if($pc_ban){echo 'DN768';}?>"><?
			}
			if($pc_ban){?>
				<img  src="<? echo $pc_ban;?>" class="banner <?if($tlm_ban){echo 'DB768';}?>"><?
			}
			if($url_banner){?></a><?}
		}?>
	</section>
	<? include '_countdown.php';?>
	<section class="listaComp">
		<?
		$hoje=date('Y-m-d');
		$query = mysqli_query($lnk,"SELECT * FROM produto_cat WHERE online = 1 ORDER BY categoria_".$LANG." ASC");
		while($linha = mysqli_fetch_array($query))
		{
			$id_cat = $linha["id"];
			$categoria = $linha["categoria_".$LANG];
			$url_categoria = str_replace(" ", "-", $categoria);
			$url_categoria = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$url_categoria);
			
			//PROMOÇÃO
			$linhaPromo = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM promocao WHERE (categoria='$id_cat' OR categoria=0) AND inicio<='$hoje' AND fim>='$hoje' ORDER BY valor DESC"));
			$valorPromo = $linhaPromo["valor"];
			?>
			<div id="infoDiv<? echo $id_cat?>" class="categoriaTit"><b><? echo $categoria;?></b></div>
			<div class="listaProd">
			<?
			$query2 = mysqli_query($lnk,"SELECT * FROM produto WHERE id_produto_cat = '$id_cat' AND online = 1 ORDER BY ordem ASC LIMIT 8");
			while($linha2 = mysqli_fetch_array($query2))
			{
				$id_prod = $linha2["id"];
				$produto = $linha2["produto_".$LANG];
				$url_produto = str_replace(" ", "-", $produto);
				$url_produto = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$url_produto);
				$preco = number_format($linha2["preco"], 2, '.', '');
				$desconto = number_format($linha2["desconto"], 2, '.', '');
				$saldo = $linha2["saldo"];
				if($valorPromo){
					$desconto = (100-$valorPromo)*$preco/100;
					$desconto = number_format($desconto, 2, '.', '');
					$percentagem=round(100-($desconto*100/$preco));
				}
				else{
					if($saldo && $desconto!='0.00' && $desconto<$preco){
						$percentagem=round(100-($desconto*100/$preco));
					}else{ $saldo = 0; }
				}

				$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto_gal WHERE id_produto = '$id_prod' AND online = 1 ORDER BY ordem ASC"));
				$img = $linha3["img"];?>
				<a href="/produto/<? echo "$id_prod/$url_produto";?>">
					<div class="produto">
						<? if($saldo || $valorPromo){ echo '<div class="descontoPer">-'.$percentagem.'%</div>'; } ?>
						<div class="produtoImg" style="background-image:url(<? echo $img;?>);"></div>
						<div class="produtoTit"><? echo $produto;?></div>
						<div class="produtoPre"><? if($saldo || $valorPromo){ echo '<strike>'.$preco.' €</strike> &nbsp;&nbsp;&nbsp;'.$desconto.' €'; }else{ echo $preco.' €';} ?></div>
					</div>
				</a>
				<?php 
			} ?>
			</div>

			<div class="clear"></div>
			<a href="/produtos/<?echo $id_cat.'/'.$url_categoria;?>"><div class="vermais"><? if($LANG=='pt'){echo "Ver mais...";} if($LANG=='en'){echo "View more...";} ?></div></a>
			<div class="clear"></div>
			<?php
		} ?>
	</section>
</article>

<button id="myBtn">Top</button>

<? include '_footer.php';?>
<? include '_newsletter.php';?>
<!--<input type="button" class="B16R nomeP" value="<? echo $nome?>" onClick="bt_prof('<? echo $id?>','<? echo $aux?>');">-->
<script>

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




$(window).on("scroll", function () {
	if ($(this).scrollTop() > 70){ $('#lojaHeader').css("display","block"); }
	else{ $('#lojaHeader').css("display","none"); }
});
function scrollDiv(id,tempo){
	$('html, body').animate({ scrollTop: $('#infoDiv'+id).offset().top-50}, tempo);
}

/*function test(){
    
  
    var x = window.innerWidth;
    if (x <= 800) {
         console.log("test screen <=800"); 
    }
    else{
        
          console.log("test screen > 800");  
    }
}*/

/*$('.header_aviso').on('mouseenter', function() {
     test()
});*/

// update here
/*function scrollDivV2(id,tempo){
    
    //console.log("test media");
    
   // var x = window.innerWidth;
  //  if (x <= 768) {
        //event.preventDefault();
       // modal.style.display = "block";
        // console.log("test media  medium " );
      // $('html, body').animate({ scrollTop: $('#infoDiv'+id).offset().top-50},
       $('html, body').animate({ scrollTop: $('#infoDiv'+id).offset().top-50}, tempo);
   // } else {
        // console.log("test media large " );
   // }
    
   
}*/
</script>
</body>
</html>