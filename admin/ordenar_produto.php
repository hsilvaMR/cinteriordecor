<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Ordenar Produto</title>
	<? include '_head.php';?>
	<!-- ORDENAR -->
	<script src="/admin/funcao/sortable/jquery-ui.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<?
	$url = $_SERVER['REQUEST_URI'];
	$urlPartes = explode("/", $url);
	$id = urldecode($urlPartes[3]);
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM produto_cat WHERE id='$id'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto_cat WHERE id='$id'")));}
	else{header('Location: /admin/ordenar_categoria');}
	
	$sep=4; $sub=4.5; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><?echo $categoria;?><!--<a href="/admin/categoria"><small>nova categoria</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/ordenar_categoria">Categorias</a>
				<div class="ponto"></div>
				<a href="">Produtos</a>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM produto_cat"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM produto_cat WHERE online='1'"));
			$percentagem=round($num_per*100/$numero); ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-database iconH4"></span>
					</div>
					<div class="subH4">CATEGORIAS</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">ONLINE</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM produto"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM produto WHERE online='1'"));
			$percentagem=round($num_per*100/$numero); ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVermelho"><? echo $num_per?></h4>
						<span class="lnr lnr-cart iconH4"></span>
					</div>
					<div class="subH4">PRODUTOS</div>
					<div class="barraFundo"><div class="barraVermelho" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">ONLINE</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo tabelaBorda">
					<div class="tabelaHead">ORDENAR PRODUTOS</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th class="compMin">#&ensp;</th>
								<th class="compMin">Fotografia</th>
                                <th>Titulo</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $query = mysqli_query($lnk,"SELECT * FROM produto WHERE id_produto_cat='$id' ORDER BY ordem ASC");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$id_cat = $linha["id_produto_cat"];
								$produto = $linha["produto_pt"];
								$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto_gal WHERE id_produto='$id' AND online=1"));
								$img = $linha2["img"];
								if(!$img){ $img="/admin/icon/default.jpg"; }
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="tabelaMover <? echo $classe?>">
	                            	<td><? echo $id?></td>
									<td><img src="<? echo $img?>" class="img"></td>
									<td><? echo $produto?></td>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</article>
<? include '_footer.php';?>
<script>
// ORDENAR
$("#sortable tbody").sortable({
    opacity: 0.6, cursor: 'move',
    update: function() {
		var order = $(this).sortable("serialize")+'&tabela=produto&campo=ordem';
		$.post("/admin/funcao/ordenar.php", order);
		$.notific8('Guardado com sucesso.', {heading: 'Guardado'});
    }
}).disableSelection();
</script>
</body>
</html>