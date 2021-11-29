<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Newsletters</title>
	<? include '_head.php';?>
	<!-- GERIR TABELA -->
  	<link href="/admin/funcao/datatables/jquery.dataTables.css" rel="stylesheet">
	<script src="/admin/funcao/datatables/jquery.dataTables.min.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=13; $sub=13.1; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Todos os Emails<!--<a href="/admin/homepage"><small>nova homepage</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Emails</a>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM newsletter"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM newsletter"));
			$percentagem=round($num_per*100/$numero); ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-spell-check iconH4"></span>
					</div>
					<div class="subH4">EMAILS</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<div class="coluna2">
				<div class="dadosF">
					<span class="lnr lnr-cloud-download dadosI"></span>
					<div class="dadosN"><? echo $numero?></div>
					<div class="dadosT">EMAILS</div>
					<a href="/admin/_newsletter/exportar">
						<div class="dadosV">
							<span class="dadosL">EXPORTAR</span>
							<span class="lnr lnr-arrow-right-circle dadosR"></span>
						</div>
					</a>
				</div>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo tabelaBorda">
					<div class="tabelaHead">EMAILS</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th class="none"></th>
								<th class="compMin">#&ensp;</th>
								<th>Email</th>
								<th>Data</th>
								<th>Opção</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $query = mysqli_query($lnk,"SELECT * FROM newsletter ORDER BY id DESC");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$email = $linha["email"];
								$data = $linha["data"];
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
	                            	<td class="none"></td>
	                            	<td><? echo $id?></td>
									<td><? echo $email?></td>
									<td><? echo $data?></td>
	                                <!--<td>labelAmarelo labelVermelho labelVerde labelCinza labelRoxo labelAzul -->
	                                	<!--<span class="labelVermelho">Registo</span>
									</td>-->
									<td>
										<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
									</td>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
					<button class="btV margin-top20 floatr" onClick="window.location.href='/admin/newsletter';">ADICIONAR NOVO</button>
					<?php if($_SESSION['id_admin']==1){?>
					<!--<button class="btA margin-top20 floatr margin-right10" onClick="enviar();">ENVIAR NEWSLETTER</button>-->
					<?php } ?>
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
	$.post("/admin/funcao/js_del.php",{ id:id_del, tabela:'newsletter' }) 
    .done(function( data ){
		$('#linha_'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });
}
function enviar(){
	$.post("/admin/_newsletter/js_enviar.php",{}) 
    .done(function( data ){
		$.notific8('Enviado com sucesso.', {heading: 'Enviado'});
    });
}
// GERIR TABELA
$(document).ready(function(){
     $('#sortable').dataTable({
     	aoColumnDefs: [{ "bSortable": false, "aTargets": [ 4 ] }],
     	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
     });
});
</script>
</body>
</html>