<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Venda</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<?
	$url = $_SERVER['REQUEST_URI'];
	$urlPartes = explode("/", $url);
	$id = urldecode($urlPartes[3]);
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda WHERE id='$id'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM venda WHERE id='$id'")));}

	$sep=8;
	if(!$existe){ $sub=8.2; }
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? if($existe){echo "Editar";}else{echo "Nova";}?> Venda<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/vendas">Vendas</a>
				<div class="ponto"></div>
				<a href="">Venda</a>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo">
					<form id="FORMULARIO" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<? if($existe){ echo $id; }?>">
					<div class="corpoCima">
						<div class="grupo">
							<div class="grupoEsq"><b>Adicionar fatura</b></div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Fatura:</div>
							<div class="grupoDir">
								<div class="upload_file btY"><span id="FICHEIRO">SELECIONAR FICHEIROS</span>
								<input type="file" name="ficheiro" accept="" onchange="lerFicheiros(this);"/>

							</div>
							<a style="line-height:50px;" href="<? echo $fatura?>"><span class="menuIcon lnr lnr-download"></span>descarregar fatura</a>
						</div>
						<div class="grupo">
							<div class="grupoEsq"><b>Faturação</b></div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Nome:</div>
							<div class="grupoDir"><!-- autofocus disabled readonly -->
								<input type="text" class="inP" name="nome" value="<? echo $nome?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Rua:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="rua" value="<? echo $rua?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Código Postal:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="postal" value="<? echo $postal?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Localidade:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="localidade" value="<? echo $localidade?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Região:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="regiao" value="<? echo $regiao?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Contacto:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="contacto" value="<? echo $contacto?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">NIF:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="nif" value="<? echo $nif?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Email:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="email" value="<? echo $email?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq"><b>Destino</b></div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Nome:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="nome2" value="<? echo $nome2?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Rua:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="rua2" value="<? echo $rua2?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Código Postal:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="postal2" value="<? echo $postal2?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Localidade:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="localidade2" value="<? echo $localidade2?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Região:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="regiao2" value="<? echo $regiao2?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Contacto:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="contacto2" value="<? echo $contacto2?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq"><b>Dados de Venda</b></div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Valor dos produtos (€):</div>
							<div class="grupoDir">
								<input type="number" class="inP" name="produtos" value="<? echo $produtos?>" step="0.01" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Valor de transporte (€):</div>
							<div class="grupoDir">
								<input type="number" class="inP" name="portes" value="<? echo $portes?>" step="0.01" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Total (€):</div>
							<div class="grupoDir">
								<input type="number" class="inP" name="total" value="<? echo $total?>" step="0.01" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Metodo:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="metodo" value="<? echo $metodo?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Estado:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="estado" value="<? echo $estado?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Transação:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="transid" value="<? echo $transid?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Tracking:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="tracking" value="<? echo $tracking?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Data:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="data" value="<? echo $data.' '.$hora?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq"><b>Detalhes</b></div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Produtos</div>
							<div class="grupoDir">
								<?$query3 = mysqli_query($lnk,"SELECT * FROM venda_prod WHERE id_venda = '$id'");
								while($linha3 = mysqli_fetch_array($query3))
								{
									$id_produto = $linha3["id_produto"];
									$quantidade = $linha3["quantidade"];
									$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto WHERE id='$id_produto'"));
									$produto = $linha4["produto_pt"];
									?>
		                            <input type="text" class="inP" name="tracking_estado" value="<? echo $quantidade.'x '.$produto?>" readonly>
	                            <?}?>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq"><b>Tracking</b></div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Etapas da venda:</div>
							<div class="grupoDir">
								<? $query2 = mysqli_query($lnk,"SELECT * FROM tracking where id_venda='$id'");
								while($linha2 = mysqli_fetch_array($query2)){
									$id_tracking = $linha2['id'];
									$id_tracking_est = $linha2['id_tracking_est'];
									$data_tracking = $linha2['data'];
									$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tracking_est where id='$id_tracking_est'"));
									$descricao = $linha3['descricao_pt'];
									?>
                                	<input type="text" class="inP" name="tracking_estado" value="<? echo $data_tracking.' - '.$descricao?>" readonly>
                                <? }?>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Nova etapa:</div>
							<div class="grupoDir">
								<select class="seL" name="id_tracking_est">
									<option class="selS" value="0">Atualize o estado da encomenda...</option>
                                	<? $query4 = mysqli_query($lnk,"SELECT * FROM tracking_est where id!=1");
									while($linha4 = mysqli_fetch_array($query4)){
										$id_est4 = $linha4['id'];
										$descricao4 = $linha4['descricao_pt'];?>
                                    	<option class="selS" value="<? echo $id_est4?>"><? echo $descricao4?></option>
                                    <? }?>	
                                </select>
							</div>
						</div>
						
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/vendas';">CANCELAR</button>					
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</article>
<? include '_footer.php';?>
<!-- MODALS -->
<div id="GUARDAR" class="modal">
	<div class="modalFundo" onClick="window.location.reload();"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="window.location.reload();"></span>
	<div class="modalSize">
		<div class="modalHead">Guardado</div>
		<div class="modalBody">Guardado com sucesso.</div>
		<div class="modalFoot">
			<button class="btV modalBt" name="nao" onclick="window.location.reload();">FECHAR</button>
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/vendas';">VOLTAR</button>
		</div>
	</div>
</div>
<!-- -->
<script>
$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		mostrar('LOADING');
		e.preventDefault();
		$.ajax({
			url: "/admin/_venda/etapa.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				esconder('LOADING');
				if(data){
					mostrar('GUARDAR');
					window.history.pushState("object or string", "Title", "/admin/venda/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});

function lerFicheiros(input) {
    var quantidade = input.files.length;
    var nome = input.value;
    if(quantidade==1){$('#FICHEIRO').html(nome);}
    else{$('#FICHEIRO').html(quantidade+' FICHEIROS');}
}
</script>
</body>
</html>