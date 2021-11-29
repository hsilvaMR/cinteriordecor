<?php $LANG = isset($_COOKIE['LINGUA']) ? $_COOKIE['LINGUA'] : 'pt' ; ?>
<div class="seta_carrinho"></div>
<div class="carTit"><? if($LANG=='pt'){ if($carrinho) echo "PRODUTOS";else echo "SEM PRODUTOS";} if($LANG=='en'){ if($carrinho) echo "PRODUCTS";else echo "NO PRODUCTS";}?></div>
<div class="carProd <? if(!$carrinho) echo "none";?>">
	<?
	if($carrinho){
		$QTP = 0;
		$lista = explode(",", $carrinho);
		foreach ($lista as $i => $value){
			$idqt = explode("-", $value);
			$idC = $idqt[0];
			$qtC = $idqt[1];
			$QTP=$QTP+$qtC;
			$linhaC = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM produto WHERE id = '$idC' AND online = 1"));
			$produtoC = $linhaC['produto_'.$LANG];
			$url_produtoC = str_replace(" ", "-", $produtoC);
			$linhaC = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM produto_gal WHERE id_produto = '$idC' AND online = 1"));
			$imgC = $linhaC['img'];
			?>
			<a href="/produto/<? echo "$idC/$url_produtoC";?>">
				<div class="carImg" style="background:url('<? echo $imgC;?>')no-repeat 50% 50%;"></div>
				<div class="carNome"><? echo $produtoC;?></div>
				<div class="carQt">Qt. <? echo $qtC;?></div>
    			<div class="clear"></div>
			</a>
			<?
		}
	}
	else{ if($LANG=='pt'){echo "SEM PRODUTOS";} if($LANG=='en'){echo "NO PRODUCTS";} }
	?>
	<div class="clear"></div>
</div>
<a href="/carrinho"><div class="carFin <? if(!$carrinho) echo "none";?>"><? if($LANG=='pt'){echo "VER CARRINHO";} if($LANG=='en'){echo "VIEW CART";} ?></div></a>