<?ob_start()?>
<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Ci | Interior Decor</title>
<? include '_head.php';?>

<!-- FACEBOOK -->
<? $url_completo = $_SERVER['REQUEST_URI'];
$url_partes = explode("/", $url_completo);
$id_linha = urldecode($url_partes[2]);
$id_linha = filter_var($id_linha, FILTER_VALIDATE_INT);
$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM produto WHERE id = '$id_linha' AND online = 1"));

if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto WHERE id = '$id_linha' AND online = 1")));
}else{header('Location: /loja');}

$existe_categoria = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM produto_cat WHERE id = '$id_produto_cat' AND online = 1"));
if(!$existe_categoria){header('Location: /loja');}

//['id']['produto']['preco']['referencia']['descricao']['data']['referencia']
$preco = number_format($preco, 2, '.', '');
$linha4 = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM produto_gal WHERE id_produto = '$id_linha' AND online = 1 ORDER BY ordem ASC"));
$img = $linha4['img']; ?>
<meta property="og:title" content="<? echo $produto_pt?>"/>
<meta property="og:url" content="http://www.ci-interiordecor.com<? echo $url_completo;?>"/>
<meta property="og:image" content="http://www.ci-interiordecor.com<? echo $img;?>"/>
<meta property="og:site_name" content="Ci-interiordecor"/>
<meta property="og:description" content="<? echo $descricao_pt?>"/>

<link rel="canonical" href="http://www.ci-interiordecor.com<? echo $url_completo;?>" />
<script>
  $(document).ready(function(){ $.post('https://graph.facebook.com',{id:'http://www.ci-interiordecor.com<? echo $url_completo;?>',scrape:true},function(response){console.log(response);});});
</script>

<!-- SLIDE -->
<link rel="stylesheet" href="/slide/sliderMini.css" type="text/css">
<!--<script type="text/javascript" src="/slide/jquery.api.js"></script>-->
<script type="text/javascript" src="/slide/jquery.bxslider.js"></script>
<script>
$(document).ready(function(){
  $('.slide_galeria').bxSlider({
    mode: 'horizontal',
	pager: false,
	controls: true,
	//autoHover: true,
	auto: false,
	speed: 500,
	pause: 6000,
  });
  $('.slide_mini').bxSlider({
    mode: 'horizontal',
	pager: false,
	controls: true,
	//autoHover: true,
	auto: false,
	speed: 500,
	pause: 6000,
	minSlides:2,
	maxSlides:2,
	slideWidth:70,
	slideMargin:30,
  });
});
</script>
<!-- ZOOM 		
<script type="text/javascript" src="/js/jquery.elevatezoom.js"></script> -->

</head>

<body>
<? $sepCor='lojaonline'; 
	include '_header.php';
	include '_login.php';
	include '_register.php';
	include '_new-password.php';
	include '_modal-boas-vindas.php';?>
<div class="barraH"></div>
<article>
	<div class="lojaonline">
		<? $query = mysqli_query($lnk,"SELECT * FROM produto_cat WHERE online = 1 ORDER BY categoria_".$LANG." ASC");
		while($linha = mysqli_fetch_array($query))
		{
			$id_cat = $linha["id"];
			$categoria = $linha["categoria_".$LANG];
			$url_categoria = str_replace(" ", "-", $categoria);
			$url_categoria = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$url_categoria);
			?>
			<a href="/produtos/<?echo $id_cat.'/'.$url_categoria;?>"><div class="categoria"><? echo $categoria;?></div></a>
			<?php 
		} ?>
	</div>
	<section>
		<div class="prodLista">
			<?
			$url_completo = $_SERVER['REQUEST_URI'];
			$url_partes = explode("/", $url_completo);
			$id_linha = urldecode($url_partes[2]);
			$id_linha = filter_var($id_linha, FILTER_VALIDATE_INT);
			extract(mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM produto WHERE id = '$id_linha' AND online = 1")));
			//['id']['produto']['preco']['referencia']['descricao']['data']['referencia']
			$preco = number_format($preco, 2, '.', '');
			$desconto = number_format($desconto, 2, '.', '');

			//PROMOÇÃO
			$hoje=date('Y-m-d');
			$linhaPromo = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM promocao WHERE (categoria='$id_produto_cat' OR categoria=0) AND inicio<='$hoje' AND fim>='$hoje' ORDER BY valor DESC"));
			$valorPromo = $linhaPromo["valor"];
			$quaisProdutos = $linhaPromo["produtos"];

			if($valorPromo){
				$desconto = (100-$valorPromo)*$preco/100;
				$desconto = number_format($desconto, 2, '.', '');
				$percentagem=$valorPromo;
			}
			else{
				if($saldo && $desconto!='0.00' && $desconto<$preco){
					$percentagem=round(100-($desconto*100/$preco));
				}else{ $saldo = 0; }
			}
			?>
			<div class="prodP1"><? if($LANG=='pt'){echo $produto_pt;} if($LANG=='en'){echo $produto_en;} ?></div>
			<div class="DN768">
				<div class="slide_galeria">
					<?php
					$d=1;
					$query = mysqli_query($lnk, "SELECT * FROM produto_gal WHERE id_produto = '$id_linha' AND online = 1 ORDER BY ordem ASC");
					while ($linha = mysqli_fetch_array($query))
					{
						$id_img = $linha['id'];
						$img = $linha['img'];
						?>
						<div class="prodP2" style="background:url('<? echo $img;?>')no-repeat 50% 50%;">
							<? if($d && $percentagem){ echo '<div class="descontoPerG">-'.$percentagem.'%</div>'; } $d=0; ?>
						</div>
						<?php 
					}
					?>
				</div>
			</div>
			<?
			$linha4 = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM produto_gal WHERE id_produto = '$id_linha' AND online = 1 ORDER BY ordem ASC"));
			$img = $linha4['img'];
			?>
			<div class="partilhar DN768">
				<div class="facePart"></div>
				<div class="twitPart"></div>
				<div class="envePart"></div>
			</div>
			
			<div id="IMGTROCA">
				<div id="IMGD" class="prodP2 DB768" style="background:url('<? echo $img;?>')no-repeat 50% 50%;" data-zoom-image="<? echo $img;?>">
					<? if($percentagem){ echo '<div class="descontoPerG">-'.$percentagem.'%</div>'; } ?>
				</div>
			</div>
			<!--<div id="IMGD" class="prodP2 DB768" style="background:url('<? echo $img;?>')no-repeat 50% 50%;"></div>-->

			<div class="prodP3">
				<div class="prodDesc">
					<b><? if($LANG=='pt'){echo "REFERÊNCIA";} if($LANG=='en'){echo "REFERENCE";} ?>:</b> <? echo $referencia;?>
					<? if($dimensoes){?><br><b><? if($LANG=='pt'){echo "DIMENSÕES";} if($LANG=='en'){echo "DIMENSIONS";} ?>:</b> <? echo $dimensoes;}?>
					<br><br><? if($LANG=='pt'){echo $descricao_pt;} if($LANG=='en'){echo $descricao_en;} ?>
				</div>
				<div class="prodPreco"><? if($saldo || $valorPromo){ echo '<strike>'.$preco.' €</strike> &nbsp;&nbsp;&nbsp;'.$desconto.' €'; }else{ echo $preco.' €';} ?></div>
				<div id="Qt_Bt">
					<?
					$quantStock=$quantidade;
					if($produzir && $quaisProdutos!='stock'){$quantidade = 30;}
				
					$qtRestante = $quantidade;
					if($carrinho)
					{
					    $lista = explode(",", $carrinho);
					    foreach ($lista as $i => $value)
					    {
							$idqt = explode("-", $value);
							$idC = $idqt[0];
							$qtC = $idqt[1];
							if($idC == $id){$qtRestante=$qtRestante-$qtC; $noCarrinho="sim";}
						}
					}
					include "_carrinho/_quantidade.php";
					?>
				</div>
				<div class="slideMiniW DB768">
					<div class="slide_mini">
						<?php
						$query = mysqli_query($lnk, "SELECT * FROM produto_gal WHERE id_produto = '$id_linha' AND online = 1 ORDER BY ordem ASC");	
						while ($linha = mysqli_fetch_array($query))
						{
							$id_img = $linha['id'];
							$img = $linha['img'];
							?>
							<div onClick="preVisualizar('<? echo $img;?>')" class="prodP2mini" style="background:url('<? echo $img;?>')no-repeat 50% 50%;"></div>
							<?php 
						}
						?>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="partilhar DB768">
				<a onClick="window.open('http://www.facebook.com/share.php?u=http://www.ci-interiordecor.com<? echo $url_completo;?>','sharer','toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)"><div class="facePart"></div></a>
				<a href="https://twitter.com/share" target="_blank" data-url="http://www.ci-interiordecor.com<? echo $url_completo;?>" data-hashtags="ss"><div class="twitPart"></div></a>
				<a href="mailto:?subject=Ci-interiordecor&body= Olá, olha este fantástico produto... http://www.ci-interiordecor.com<? echo $url_completo;?>"><div class="envePart"></div></a>
			</div>
			<div class="clear"></div>
		</div>
	</section>
</article>
<article class="fundo_cinza">
	<section>
		<div class="sugTit"><? if($LANG=='pt'){echo "SUGESTÕES";} if($LANG=='en'){echo "SUGGESTIONS";} ?></div>
		<?php
		$sugestoes = 1;
		$query2 = mysqli_query($lnk, "SELECT * FROM produto WHERE /*id!='$id_linha' AND*/ online=1 ORDER BY rand()");	
		while ($linha2 = mysqli_fetch_array($query2) and $sugestoes <= 4)
		{
			$id_prod = $linha2['id'];
			$produto = $linha2['produto_'.$LANG];
			$url_produto = str_replace(" ", "-", $produto);
			$preco = $linha2['preco'];
			$linha3 = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM produto_gal WHERE id_produto='$id_prod' AND online=1 AND ambiente=1 ORDER BY rand()"));
			$img = $linha3['img'];
			if($img){ ?>
				<a href="/produto/<? echo "$id_prod/$url_produto";?>">
					<div class="sugestao <? echo "sug_mg$sugestoes";?>" style="background:url('<? echo "$img";?>')no-repeat 50% 50%;background-size:cover;"></div>
				</a> <?php
				$sugestoes++;
			}
		}
		?>
		<div class="clear"></div>
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

<? include '_footer.php';?>
<? include '_newsletter.php';?>
<script>
$(window).on("scroll", function () {
	if ($(this).scrollTop() > 70){ $("#header_loja").css("position", "fixed"); }
	else{ $("#header_loja").css("position", "inherit"); }
});
function scrollDiv(id,tempo){
	$('html, body').animate({ scrollTop: $('#infoDiv'+id).offset().top-32}, tempo);
}
function adiCarrinho(id)
{
	document.getElementById("bt_adicionar").value="<? if($LANG=='pt'){echo "ADICIONAR";} if($LANG=='en'){echo "ADD";} ?>";
	var quantidade = document.getElementById("qtP").value;
	var qtRestante = document.getElementById("qtRestante").value;
	var quantStock = document.getElementById("quantStock").value;
	jQuery.ajax({
		type: "POST",
		url: "/_carrinho/adicionar.php",
		data: 'id='+id+"&quantidade="+quantidade+"&qtRestante="+qtRestante+"&quantStock="+quantStock,
		success: function(data){
			$('#Qt_Bt').html(data);
			var qtCarrinho = document.getElementById("qtCarrinho").value;
			$('#TPH').html(qtCarrinho);
			$('#TPH').css("display","block");
			//setTimeout(function(){ document.getElementById("bt_adicionar").value="ADICIONAR"; },1000);
			/*document.getElementById("carrinho").innerHTML = data;
			var total = document.getElementById('TOTAL').innerHTML;
			$('#TOTAL_HEADER').html(total);
			$('html, body').animate({ scrollTop: $("#topocarrinho").offset().top-50 }, 800);*/
			jQuery.ajax({
				type: "POST", data: 'id='+id, url: "/_carrinho/atualizarHeader.php",
				success: function(data){ $('#CARRINHO').html(data); }
			});
		}
	});
}

function preVisualizar(img){
	$("#IMGTROCA").html("<div id='IMGD' class='prodP2 DB768' style='background:url("+img+")no-repeat 50% 50%;' data-zoom-image='"+img+"'></div>");
	/*$('#IMGD').elevateZoom({
	    zoomType: 'lens',
	    lensShape: 'round',
	    lensSize: 200,
		scrollZoom:true,
	});*/
	//$("#IMGD").css("background", "url("+img+")no-repeat 50% 50%");
	//$("#IMGD").css("background-size", "contain");
}
/*$('#IMGD').elevateZoom({
    zoomType: 'lens',
    lensShape: 'round',
    lensSize: 200,
	scrollZoom:true,
});*/
</script>
</body>
</html>