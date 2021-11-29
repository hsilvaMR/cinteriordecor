<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Produtos vendidos</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<? 
	$url = $_SERVER['REQUEST_URI'];
	$urlPartes = explode("/", $url);
	$id_linha = urldecode($urlPartes[3]);
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda_prod WHERE id_venda='$id_linha'"));
	if(!$existe){ header('Location: /admin/vendas'); }
	
	$sep=8;
	$sub=8.1;
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Produtos vendidos<!--<a href="/admin/prato/<?echo $id_menu;?>"><small>novo prato</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/vendas">Vendas</a>
				<div class="ponto"></div>
				<a href="">Produtos vendidos</a>
			</div>
		</div>
		<div class="linha">
			<? $total = 0;
			$query = mysqli_query($lnk,"SELECT * FROM venda_prod WHERE id_venda='$id_linha'");
			while($linha = mysqli_fetch_array($query)){ $total=$total+$linha["quantidade"]; }
			$percentagem=round($total*100/$total); ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $total?></h4>
						<span class="lnr lnr-magic-wand iconH4"></span>
					</div>
					<div class="subH4">PRODUTOS</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem;?>%</span>
					</div>
				</div>
			</div>
			<? $total = 0;
			$query = mysqli_query($lnk,"SELECT * FROM venda_prod");
			while($linha = mysqli_fetch_array($query)){ $total=$total+$linha["quantidade"]; }
			$percentagem=round($total*100/$total); ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVermelho"><? echo $total?></h4>
						<span class="lnr lnr-eye iconH4"></span>
					</div>
					<div class="subH4">TOTAL</div>
					<div class="barraFundo"><div class="barraVermelho" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo tabelaBorda">
					<div class="tabelaHead">PRODUTOS</div>
					<div class="linhaScroll">
						<table class="listagem">
							<thead>
							<tr>
                                <th>Nome</th>
								<th>Preço</th>
								<th>Quantidade</th>
								<th>Total</th>
								<!--<th>Opção</th>-->
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $query = mysqli_query($lnk,"SELECT * FROM venda_prod WHERE id_venda = '$id_linha'");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$id_produto = $linha["id_produto"];
								$preco = $linha["preco"];
								$quantidade = $linha["quantidade"];
								$total = $linha["total"];
								$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto WHERE id='$id_produto'"));
								$produto = $linha2["produto_pt"];
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha<? echo $id?>" class="<? echo $classe?>">
									<td><? echo $produto?></td>
	                                <td>€ <? echo $preco?></td>
	                                <td><? echo $quantidade?></td>
	                                <td>€ <? echo $total?></td>
									<!--<td>
										<a href="/admin/prato/<?echo $id_menu.'/'.$id;?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>&nbsp;&nbsp;
										<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
									</td>-->
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
					<button type="button" class="btA margin-top20 margin-left10 floatr" onClick="window.location.href='/admin/vendas';">VOLTAR</button>
					<!--<button type="button" class="btV margin-top20 floatr" onClick="window.location.href='/admin/prato/<?echo $id_menu;?>';">ADICIONAR NOVO</button>-->
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
</article>
<? include '_footer.php';?>
<!-- MODALS -->
<div id="APAGAR" class="modal">
	<div class="modalFundo" onClick="esconder('APAGAR');"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="esconder('APAGAR');"></span>
	<div class="modalSize">
		<div class="modalHead">Apagar</div>
		<div class="modalBody">Tem a certeza que deseja apagar?</div>
		<div class="modalFoot">
			<button class="btV modalBt" name="sim" onclick="apagar()">SIM</button>
			<button class="btA modalBt" name="nao" onclick="esconder('APAGAR');">NÃO</button>
		</div>
	</div>
</div>
<!-- -->
<script>
$(document).keyup(function(e) {
     if (e.keyCode == 27) { esconder('APAGAR'); }
});
function apagar(){
	$.post("/admin/funcao/js_del.php",{ id:id_del, tabela:'venda_prod' }) 
    .done(function( data ){
		$('#linha'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });
}
</script>
</body>
</html>