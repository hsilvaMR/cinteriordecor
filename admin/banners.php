<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Banners</title>
	<? include '_head.php';?>
	<!-- ORDENAR -->
	<script src="/admin/funcao/sortable/jquery-ui.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=10; $sub=10.1; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Todos os Banners<!--<a href="/admin/homepage"><small>nova homepage</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Banners</a>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM banner"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM banner"));
			$percentagem=round($num_per*100/$numero); ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-picture iconH4"></span>
					</div>
					<div class="subH4">BANNERS</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $hoje=date('Y-m-d');
			$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM banner"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM banner WHERE inicio<='$hoje' and fim>='$hoje'"));
			$percentagem=round($num_per*100/$numero); ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVermelho"><? echo $num_per?></h4>
						<span class="lnr lnr-eye iconH4"></span>
					</div>
					<div class="subH4">ONLINE</div>
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
					<div class="tabelaHead">BANNERS</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th class="none"></th>
								<th class="compMin">#&ensp;</th>
								<th class="compMin">Telemóvel</th>
								<th class="compMin">Computador</th>
								<th>Nome</th>
								<th>Online</th>
								<th>Opção</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $hoje=date('Y-m-d');
                            $query = mysqli_query($lnk,"SELECT * FROM banner ORDER BY ordem ASC");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$nome = $linha["nome"];
								$pc = $linha["pc"];
								if(!$pc){ $pc="/admin/icon/default.jpg"; }
								$tlm = $linha["tlm"];
								if(!$tlm){ $tlm="/admin/icon/default.jpg"; }
								$inicio = $linha["inicio"];
								$fim = $linha["fim"];
								$online = $linha["online"];
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="tabelaMover <? echo $classe?>">
	                            	<td class="none"></td>
	                            	<td><? echo $id?></td>
									<td><img src="<? echo $tlm?>" class="img"></td>
									<td><img src="<? echo $pc?>" class="img"></td>
									<td><? echo $nome?></td>
	                                <td><!-- labelAmarelo labelVermelho labelVerde labelCinza labelRoxo labelAzul -->
	                                	<?if($inicio<=$hoje && $fim>=$hoje){?><span class="labelVerde"><? echo $inicio.' a '.$fim;?></span>
	                                	<?}else{?><span class="labelVermelho"><? echo $inicio.' a '.$fim;?><?}?>
	                                	<!--<input type="checkbox" id="check<?echo $id;?>" class="RD" value="1" onClick="onoff('<?echo $id;?>')" <?if($online)echo "checked";?>>
	          							<label for="check<?echo $id;?>">&nbsp;</label>-->
									</td>
									<td>
										<a href="/admin/banner/<?echo $id;?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>&nbsp;&nbsp;
										<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
									</td>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
					<button class="btV margin-top20 floatr" onClick="window.location.href='/admin/banner';">ADICIONAR NOVO</button>
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
function onoff(id){
	$.post("/admin/funcao/js_onoff.php",{ id:id, tabela:'banner', campo:'online' })
	$.notific8('Guardado com sucesso.', {heading: 'Guardado'});	
}
function apagar(){
	$.post("/admin/_banner/js_del.php",{ id:id_del }) 
    .done(function( data ){
		$('#linha_'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });
}
// ORDENAR
$("#sortable tbody").sortable({
    opacity: 0.6, cursor: 'move',
    update: function() {
		var order = $(this).sortable("serialize")+'&tabela=banner&campo=ordem';
		$.post("/admin/funcao/ordenar.php", order);
		$.notific8('Guardado com sucesso.', {heading: 'Guardado'});
    }
}).disableSelection();
</script>
</body>
</html>