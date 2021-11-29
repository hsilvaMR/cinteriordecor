<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Vendas</title>
	<? include '_head.php';?>
	<!-- GERIR TABELA -->
  	<link href="/admin/funcao/datatables/jquery.dataTables.css" rel="stylesheet">
	<script src="/admin/funcao/datatables/jquery.dataTables.min.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=8; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Todas as Vendas<!--<a href="/admin/homepage"><small>nova homepage</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Vendas</a>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda"));
			$percentagem=round($num_per*100/$numero); ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-chart-bars iconH4"></span>
					</div>
					<div class="subH4">VENDAS</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
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
						<span class="lnr lnr-shirt iconH4"></span>
					</div>
					<div class="subH4">PRODUTOS VENDIDOS</div>
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
					<div class="tabelaHead">VENDAS</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th class="none"></th>
								<th class="compMin">#&ensp;</th>
								<th>Nome</th>
								<th>Email</th>
								<th>Contacto</th>
								<th>Etapa</th>
								<th>Método de envio</th>
								<th>Data da Venda</th>
								<th>Opção</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $query = mysqli_query($lnk,"SELECT * FROM venda ORDER BY id DESC");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$id_produto = $linha["id_produto"];
								$nome = $linha["nome"];
								$email = $linha["email"];
								$contacto = $linha["contacto"];
								$data = $linha["data"];
								$hora = $linha["hora"];
								$hora = substr($hora, 0, 5);
								$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tracking where id_venda='$id' ORDER BY id DESC"));
								$id_tracking = $linha2["id_tracking_est"];
								$data_tracking = $linha2["data"];
								$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tracking_est where id='$id_tracking'"));
								$etapa = $linha3["descricao_pt"];
								$metodo_envio = $linha["metodo_envio"];
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
	                            	<td class="none"></td>
	                            	<td><? echo $id?></td>
									<td><a href="/admin/venda/<?echo $id;?>" class="opcoes"><? echo $nome?></a></td>
									<td><a href="mailto:<? echo $email?>"><? echo $email?></a></td>
									<td><? echo $contacto?></td>
									<td>
										<a href="/admin/venda_tracking/<?echo $id;?>" class="opcoes">
											<?if($id_tracking=='1'){?><span class="labelAzul"><? echo $etapa?></span><?}?>
											<?if($id_tracking=='2'){?><span class="labelVermelho"><? echo $etapa?></span><?}?>
											<?if($id_tracking=='3'){?><span class="labelRoxo"><? echo $etapa?></span><?}?>
		                                	<?if($id_tracking=='4'){?><span class="labelAmarelo"><? echo $etapa?></span><?}?>
		                                	<?if($id_tracking=='5'){?><span class="labelAzul"><? echo $etapa?></span><?}?>
		                                	<?if($id_tracking=='6'){?><span class="labelVerde"><? echo $etapa?></span><?}?>
		                                	<?if($id_tracking=='7'){?><span class="labelCinza"><? echo $etapa?></span><?}?>
	                                	</a>
									</td>
									<td>
										<?if($metodo_envio=='envio'){?><span class="labelAzul">Envio ao domicílio</span><?}?>
										<?if($metodo_envio=='levantamento'){?><span class="labelAmarelo">Levantamento na loja</span><?}?>
									</td>
	                                <td><? echo $data." ".$hora?></td>
									<td>
										<a href="/admin/venda_produtos/<?echo $id;?>" class="opcoes"><span class="lnr lnr-menu-circle"></span>&nbsp;Produtos</a>&nbsp;&nbsp;
										<a href="/admin/venda/<?echo $id;?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>&nbsp;&nbsp;
										<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
									</td>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
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
	$.post("/admin/_venda/apagar.php",{ id:id_del, tabela:'venda' }) 
    .done(function( data ){
		$('#linha_'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });
}
// GERIR TABELA
$(document).ready(function(){
     $('#sortable').dataTable({
     	aoColumnDefs: [{ "bSortable": false, "aTargets": [ 8 ] }],
     	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
     });
});
</script>
</body>
</html>