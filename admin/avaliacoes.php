<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Categoria</title>
	<? include '_head.php';?>
	<!-- PAGINAR -->
  	<link href="/admin/funcao/datatables/jquery.dataTables.css" rel="stylesheet">
	<script src="/admin/funcao/datatables/jquery.dataTables.min.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=15; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Todas as Avaliações<!--<a href="/admin/categoria"><small>nova categoria</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Avaliações</a>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda_avaliacao"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda_avaliacao"));
			$percentagem=round($num_per*100/$numero); ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-database iconH4"></span>
					</div>
					<div class="subH4">AVALIAÇÕES</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda_avaliacao"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda_avaliacao WHERE avaliacao='muito_bom'"));
			$percentagem=round($num_per*100/$numero); ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-eye iconH4"></span>
					</div>
					<div class="subH4">Avaliações Positivas</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">Positivas</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>

				<? $numero_bom=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda_avaliacao"));
				$num_per_bom=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda_avaliacao WHERE avaliacao='bom'"));
				$percentagem_bom=round($num_per_bom*100/$numero_bom); ?>
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteAmarelo"><? echo $num_per_bom?></h4>
						<span class="lnr lnr-eye iconH4"></span>
					</div>
					<div class="subH4">Avaliações intermédias</div>
					<div class="barraFundo"><div class="barraAmarelo" style="width:<? echo $percentagem_bom?>%;"></div></div>
					<div class="linha">
						<span class="legH4">Intermédias</span>
						<span class="perH4"><? echo $percentagem_bom?>%</span>
					</div>
				</div>

				<? $numero_mau=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda_avaliacao"));
				$num_per_mau=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda_avaliacao WHERE avaliacao='mau'"));
				$percentagem_mau=round($num_per_mau*100/$numero_mau); ?>
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVermelho"><? echo $num_per_mau?></h4>
						<span class="lnr lnr-eye iconH4"></span>
					</div>
					<div class="subH4">Avaliações negativas</div>
					<div class="barraFundo"><div class="barraVermelho" style="width:<? echo $percentagem_mau?>%;"></div></div>
					<div class="linha">
						<span class="legH4">Negativas</span>
						<span class="perH4"><? echo $percentagem_mau?>%</span>
					</div>
				</div>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo tabelaBorda">
					<div class="tabelaHead">AVALIAÇÕES</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th class="compMin">#&ensp;</th>
								<th>Encomenda</th>
								<th>Data de Avaliação</th>
								<th>Avaliação</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $query = mysqli_query($lnk,"SELECT * FROM venda_avaliacao ORDER BY id ASC");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$encomenda = $linha["id_venda"];
								$data = $linha["data"];
								$avaliacao = $linha["avaliacao"];

								if($avaliacao == 'mau'){ $texto = '<span class="labelVermelho">Avaliação Negativa</span>';}
								elseif($avaliacao == 'bom'){$texto = '<span class="labelAmarelo">Avaliação Intermédia</span>';}
								else{$texto = '<span class="labelVerde">Avaliação Positiva</span>';}

								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
	                            	<td><? echo $id ?></td>
	                            	<td><a href="/admin/venda/<?echo $encomenda;?>" class="opcoes"><? echo $encomenda ?></a></td>
									<td><? echo $data ?></td>
	                                <td><? echo $texto ?></td>
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

<script>
// GERIR TABELA
$(document).ready(function(){
     $('#sortable').dataTable({
     	aoColumnDefs: [{ "bSortable": false, "aTargets": [ 0 ] }],
     	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
     });
});
</script>
</body>
</html>