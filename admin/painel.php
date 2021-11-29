<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Painel</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=1; $sub=0; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Painel<small>estatísticas e relatórios</small><h1>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda")); ?>
			<div class="coluna4">
				<div class="dadosF">
					<span class="lnr lnr-store dadosI"></span>
					<div class="dadosN"><? echo $numero?></div>
					<div class="dadosT">VENDAS</div>
					<a href="/admin/vendas">
						<div class="dadosV">
							<span class="dadosL">VER MAIS</span>
							<span class="lnr lnr-arrow-right-circle dadosR"></span>
						</div>
					</a>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM produto")); ?>
			<div class="coluna4">
				<div class="dadosF">
					<span class="lnr lnr-cart dadosI"></span>
					<div class="dadosN"><? echo $numero?></div>
					<div class="dadosT">PRODUTOS</div>
					<a href="/admin/produtos">
						<div class="dadosV">
							<span class="dadosL">VER MAIS</span>
							<span class="lnr lnr-arrow-right-circle dadosR"></span>
						</div>
					</a>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia")); ?>
			<div class="coluna4">
				<div class="dadosF">
					<span class="lnr lnr-book dadosI"></span>
					<div class="dadosN"><? echo $numero?></div>
					<div class="dadosT">NOTÍCIAS</div>
					<a href="/admin/noticias">
						<div class="dadosV">
							<span class="dadosL">VER MAIS</span>
							<span class="lnr lnr-arrow-right-circle dadosR"></span>
						</div>
					</a>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM projeto")); ?>
			<div class="coluna4">
				<div class="dadosF">
					<span class="lnr lnr-rocket dadosI"></span>
					<div class="dadosN"><? echo $numero?></div>
					<div class="dadosT">PROJECTOS</div>
					<a href="/admin/projectos">
						<div class="dadosV">
							<span class="dadosL">VER MAIS</span>
							<span class="lnr lnr-arrow-right-circle dadosR"></span>
						</div>
					</a>
				</div>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna2">
				<div class="corpo tabelaBorda">
					<div class="tabelaHead">ÚLTIMAS VENDAS</div>
					<div class="linhaScroll">
						<table class="listagem">
							<thead>
							<tr>
								<th>Nome</th>
                                <th>Data da Venda</th>
								<th>Etapa</th>
								<!--<th>Estado</th>-->
							</tr>
							</thead>
							<tbody>
                            <? $query = mysqli_query($lnk,"SELECT * FROM venda ORDER BY id DESC LIMIT 10");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$nome = $linha["nome"];
								$data = $linha["data"];
								$estado = $linha["estado"];
								$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tracking WHERE id_venda='$id' ORDER BY id DESC"));
								$id_tracking_est = $linha2["id_tracking_est"];
								$data_tracking = $linha2["data"];
								$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tracking_est WHERE id='$id_tracking_est'"));
								$descricao = $linha3["descricao_pt"]; ?>
	                            <tr>
									<td><? echo $nome?></td>
									<td><? echo $data?></td>
	                                <td><? echo $data_tracking?> - <? echo $descricao?></td>
	                                <!--<td>
	                                	<?if($estado=='pendente'){?><span class="labelAmarelo">Pendente</span><?}?>
	                                	<?if($estado=='pago'){?><span class="labelVermelho">Pago</span><?}?>
	                                	<?if($estado=='enviada'){?><span class="labelVerde">Enviada</span><?}?>
	                                	<?if($estado=='devolvida'){?><span class="labelCinza">Devolvida</span><?}?>
	                                	<?if($estado=='oferecida'){?><span class="labelRoxo">Oferecida</span><?}?>
	                                	<?if($estado=='concluida'){?><span class="labelAzul">Concluida</span><?}?>
									</td>-->
									<!--<td>
										<span class="opcoes"><i class="lnr lnr-hand"></i> Ver</span>
										<a href="" class="opcoes"><span class="lnr lnr-pencil"></span> Editar</a>
									</td>-->
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="coluna2">
				<div class="corpo tabelaBorda">
					<div class="tabelaHead">ÚLTIMAS NOTICIAS</div>
					<div class="linhaScroll">
						<table class="listagem">
							<thead>
							<tr>
								<th>Titulo</th>
                                <th>Data</th>
								<th>Estado</th>
							</tr>
							</thead>
							<tbody>
                            <? $query = mysqli_query($lnk,"SELECT * FROM noticia ORDER BY criacao DESC LIMIT 10");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$titulo = $linha["titulo_pt"];
								$data = $linha["criacao"];
								$publicacao = $linha["publicacao"];
								$online = $linha["online"]; ?>
	                            <tr>
									<td><? echo $titulo?></td>
									<td><? echo $data?></td>
	                                <td>
	                                	<?if($online){?><span class="labelVerde">Online</span><?}
	                                	else{?><span class="labelVermelho">Offline</span><?}?>      	
									</td>
									<!--<td>
										<span class="opcoes"><i class="lnr lnr-hand"></i> Ver</span>
										<a href="" class="opcoes"><span class="lnr lnr-pencil"></span> Editar</a>
									</td>-->
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
</body>
</html>