<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Promoções</title>
	<? include '_head.php';?>
	<!-- PAGINAR -->
  	<link href="/admin/funcao/datatables/jquery.dataTables.css" rel="stylesheet">
	<script src="/admin/funcao/datatables/jquery.dataTables.min.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=11; $sub=11.1; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Todas as Promoções<!--<a href="/admin/homepage"><small>nova homepage</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Promoções</a>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM promocao"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM promocao"));
			$percentagem=round($num_per*100/$numero); ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-bullhorn iconH4"></span>
					</div>
					<div class="subH4">PROMOÇÕES</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $hoje=date('Y-m-d');
			$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM promocao"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM promocao WHERE inicio<='$hoje' and fim>='$hoje'"));
			$percentagem=round($num_per*100/$numero); ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVermelho"><? echo $num_per?></h4>
						<span class="lnr lnr-hourglass iconH4"></span>
					</div>
					<div class="subH4">ACTIVAS</div>
					<div class="barraFundo"><div class="barraVermelho" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">ACTIVAS</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo tabelaBorda">
					<div class="tabelaHead">PROMOÇÕES</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th class="none"></th>
								<th class="compMin">#&ensp;</th>
								<th>Nome</th>
								<th>Desconto</th>
								<th>Categoria</th>
								<th>Período</th>
								<th>Opção</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $hoje=date('Y-m-d');
                            $query = mysqli_query($lnk,"SELECT * FROM promocao ORDER BY fim DESC");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$nome = $linha["nome"];
								$valor = $linha["valor"];
								$tipo = $linha["tipo"];
								$inicio = $linha["inicio"];
								$fim = $linha["fim"];
								$id_categoria = $linha["categoria"];
								if($id_categoria){
									$linha_cat = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto_cat WHERE id='$id_categoria'"));
									$categoria = $linha_cat["categoria_pt"];
								}else{ $categoria = 'Todas'; }
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
	                            	<td class="none"></td>
									<td><? echo $id?></td>
									<td><? echo $nome?></td>
									<td><? echo $valor; if($tipo=='percentagem'){ echo '%'; } ?></td>
									<td><? echo $categoria?></td>
	                                <td><!-- labelAmarelo labelVermelho labelVerde labelCinza labelRoxo labelAzul -->
	                                	<?if($inicio<=$hoje && $fim>=$hoje){?><span class="labelVerde"><? echo $inicio.' a '.$fim;?></span>
	                                	<?}elseif($inicio>$hoje){?><span class="labelAmarelo"><? echo $inicio.' a '.$fim;?>
	                                	<?}else{?><span class="labelCinza"><? echo $inicio.' a '.$fim;?><?}?>
	                                	<!--<input type="checkbox" id="check<?echo $id;?>" class="RD" value="1" onClick="onoff('<?echo $id;?>')" <?if($online)echo "checked";?>>
	          							<label for="check<?echo $id;?>">&nbsp;</label>-->
									</td>
									<td>
										<a href="/admin/promocao/<?echo $id;?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>&nbsp;&nbsp;
										<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
									</td>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
					<button class="btV margin-top20 floatr" onClick="window.location.href='/admin/promocao';">ADICIONAR NOVO</button>
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
	$.post("/admin/funcao/js_del.php",{ id:id_del, tabela:'promocao' }) 
    .done(function( data ){
		$('#linha_'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });
}
// GERIR TABELA
$(document).ready(function(){
     $('#sortable').dataTable({
     	aoColumnDefs: [{ "bSortable": false, "aTargets": [ 6 ] }],
     	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
     });
});
</script>
</body>
</html>