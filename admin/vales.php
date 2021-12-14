<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">

<head>
	<meta charset="utf-8">
	<title>Portes</title>
	<? include '_head.php'; ?>
	<!-- PAGINAR -->
	<link href="/admin/funcao/datatables/jquery.dataTables.css" rel="stylesheet">
	<script src="/admin/funcao/datatables/jquery.dataTables.min.js"></script>
</head>

<body>
	<? include '_header.php'; ?>
	<article>
		<? $sep = 17;
		$sub = 17.1;
		include '_menu.php'; ?>
		<div class="conteudo">
			<div class="linha">
				<div class="titulo">
					<h1>Todos os Vales de Desconto
						<!--<a href="/admin/homepage"><small>nova homepage</small></a>-->
						<h1>
							<a href="/admin/painel">Painel</a>
							<div class="ponto"></div>
							<a href="">Vales de Desconto</a>
				</div>
			</div>
			<div class="linhaScroll">
				<div class="coluna1">
					<div class="corpo tabelaBorda">
						<div class="tabelaHead">VALES DE DESCONTO</div>
						<div class="linhaScroll">
							<table id="sortable" class="listagem">
								<thead>
									<tr>
										<th class="none"></th>
										<th class="compMin">#&ensp;</th>
										<th>Nome</th>
										<th>Código</th>
										<th>Desconto</th>
										<th>Período</th>
										<th>Opção</th>
									</tr>
								</thead>
								<tbody>
									<? $risca = 1;
									$hoje = date('Y-m-d');
									$query = mysqli_query($lnk, "SELECT * FROM vales_desconto ORDER BY data_fim DESC");
									while ($linha = mysqli_fetch_array($query)) {
										$id = $linha["id"];
										$nome = $linha["nome"];
										$codigo = $linha["codigo"];
										$tipo = $linha["tipo"];
										$inicio = $linha["data_inicio"];
										$fim = $linha["data_fim"];

										$tipo = $linha["tipo"];
										$valor_desconto = $linha["valor_desconto"];
										$valor_condicao = $linha["valor_condicao"];
										$gratis = $linha["gratis"];



										if (($risca % 2) == 0) {  // verificar paridade é par 
											$classe = "tabelaFundoP";
										} else {
											$classe = "tabelaFundoI";
										}
										$risca++; ?>
										<tr id="linha_<? echo $id ?>" class="<? echo $classe ?>">
											<td class="none"></td>
											<td><? echo $id ?></td>
											<td><? echo $nome ?></td>
											<td><? echo $codigo ?></td>
											<td>
												<?
												if ($tipo == 'acima_de') {
													echo "Acima de $valor_condicao € <br>";
													if ($valor_desconto > 0) {
														echo "Desconto de $valor_desconto % <br>";
													} elseif ($gratis == 1) {
														echo "<span class=\"labelRoxo\">Portes gratuitos</span>";
													}
												} elseif ($tipo == 'desconto_perc') {
													echo "Desconto de $valor_desconto % <br>";
													if ($valor_condicao > 0) {
														echo "Acima de $valor_condicao € <br>";
													}
												} elseif ($tipo == 'cupao') {
													echo "Cupão de $valor_desconto € <br>";
													if ($valor_condicao > 0) {
														echo "Acima de $valor_condicao € <br>";
													}
												} else {
													echo "<span class=\"labelRoxo\">Portes gratuitos</span>";
												}

												?>
											</td>
											<td>
												<!-- labelAmarelo labelVermelho labelVerde labelCinza labelRoxo labelAzul -->
												<? if ($inicio <= $hoje && $fim >= $hoje) { ?><span class="labelVerde"><? echo $inicio . ' a ' . $fim; ?></span>
												<? } elseif ($inicio > $hoje) { ?><span class="labelAmarelo"><? echo $inicio . ' a ' . $fim; ?>
													<? } else { ?><span class="labelCinza"><? echo $inicio . ' a ' . $fim; ?><? } ?>
											</td>

											<td>
												<a href="/admin/vale/<? echo $id; ?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>&nbsp;&nbsp;
												<span class="opcoes" onclick="mostrar('APAGAR',<? echo $id; ?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
											</td>
										</tr>
									<? } ?>

								</tbody>
							</table>
						</div>
						<button class="btV margin-top20 floatr" onClick="window.location.href='/admin/vale';">ADICIONAR NOVO</button>
						<div class="clear"></div>
					</div>
				</div>
			</div>

			<!-- VOUCHER UNICO -->
			<? include '_voucherUnico.php'; ?>
		</div>
	</article>
	<? include '_footer.php'; ?>
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
			if (e.keyCode == 27) {
				esconder('APAGAR');
			}
		});

		function apagar() {
			$.post("/admin/funcao/js_del.php", {
					id: id_del,
					tabela: 'vales_desconto'
				})
				.done(function(data) {
					$('#linha_' + id_del).css("display", "none");
					esconder('APAGAR');
					$.notific8('Apagado com sucesso.', {
						heading: 'Apagado'
					});
				});
		}
		// GERIR TABELA
		$(document).ready(function() {
			$('#sortable').dataTable({
				aoColumnDefs: [{
					"bSortable": false,
					"aTargets": [6]
				}],
				lengthMenu: [
					[10, 25, 50, -1],
					[10, 25, 50, "Todos"]
				],
			});
		});

		// GERIR TABELA VOUCHER UNICO
		$(document).ready(function() {
			$('#sortable1').dataTable();
		});
	</script>
</body>

</html>