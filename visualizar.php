<?php include('_seguranca_conta.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Ci | Interior Decor</title>
<? include '_head.php';?>
<!-- PayPal -->
<script src="paypal/simpleCart.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>

<? include '_header.php';?>
<div class="barraH"></div>
<article>
	
	<div class="clear height30"></div>
	<section style="min-height:600px;">
		<div class="barraAzul"><? if($LANG=='pt'){echo "A MINHA ENCOMENDA";} if($LANG=='en'){echo "MY ORDER";} ?></div>
		<?

		$url = $_SERVER['REQUEST_URI'];
		$urlPartes = explode("/", $url);

		$id_url = urldecode($urlPartes[2]);

		$query = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda_prod where id_venda='$id_url'"));

		if($query){
			$query_enc = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM venda WHERE id='$id_url'"));

			$produtos_enc = $query_enc["produtos"];
			$total_enc = $query_enc["total"];
			$portes_enc = $query_enc["portes"];

			$query2 = mysqli_query($lnk,"SELECT * FROM venda_prod WHERE id_venda='$id_url'");
			echo "<div class=\"cart\">
					ENCOMENDA #$id_url
					<div id=\"cob\" class=\"cobertura\"></div>
					
						
					</div>";
			while($linha = mysqli_fetch_array($query2)){
				# code...
				$id_produto = $linha["id_produto"];
				$query3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto WHERE id='$id_produto'"));

				$preco = $linha["preco"];
				$quantidade = $linha["quantidade"];
				$total = $linha["total"];
				$nome_produto = $query3["produto_pt"];
				
				echo "
					<div class=\"floatl\">
						<div class=\"cartNome\">$nome_produto</div>
						<div class=\"cartRef\"> $preco €</div>
					</div>
					<div class=\"floatr textr\">
						<div class=\"cartNome\">Total de unidades: $quantidade</div>
						<div class=\"cartPreco\"> $total €</div>
					</div>
					<div class=\"clear\"></div>
	    		</div>";
				
			}
			echo "<div id=\"cob\" class=\"cart\"></div>
					<div class=\"floatr textr margin-top10\">
						<div class=\"cartPreco\"> Total : $produtos_enc €</div>
						<div class=\"cartPreco\"> Portes : $portes_enc €</div>
						<div class=\"cartPreco\"> Valor Total : $total_enc €</div>
					</div>


			"

			;

			
		} ?>

	</section>
</article>
<? include '_footer.php';?>

<script>

</script>    
</body>
</html>