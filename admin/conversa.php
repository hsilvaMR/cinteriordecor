<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Cliente</title>
	<? include '_head.php';?>
	<!-- PAGINAR -->
	<link href="/admin/funcao/datatables/jquery.dataTables.css" rel="stylesheet">
	<script src="/admin/funcao/datatables/jquery.dataTables.min.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<?
	$url = $_SERVER['REQUEST_URI'];
	$urlPartes = explode("/", $url);
	$id = urldecode($urlPartes[3]);
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda_conversa WHERE id_venda='$id'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM venda_conversa WHERE id_venda='$id'")));$id_url = urldecode($urlPartes[3]);}

	$sep=11;
	if(!$existe){ $sub=11.2; }
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Encomenda #<? echo $id_url;?><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/clientes">Clientes</a>
				<div class="ponto"></div>
				<a href="">Conversa</a>
			</div>
		</div>

		<div class="linha">
			<div class="coluna1">
				<div class="corpo">
					<div class="grupo">
						<div class="grupoEsq">Conversa:</div>
						<div class="grupoDir">
							<? 
								$query = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM venda_conversa WHERE id_venda='$id_url'"));

								$id_linha = $query['id'];
								$query2 = mysqli_query($lnk,"SELECT * FROM venda_conversa_msg WHERE id_venda_conversa='$id_linha'");

								echo "<div class=\"chat_conv\">		

										<div class=\"chat_conv_msg\">";

											while($linha = mysqli_fetch_array($query2)){
										
												$id_linha_msg = $linha["id"];
												$respondido = $linha["respondido"];
												$mensagem = $linha["mensagem"];

												$query3 = mysqli_query($lnk,"SELECT * FROM venda_conversa_ficheiro WHERE id_msg='$id_linha_msg'");

												$nome_file = '';
												while($linha3 = mysqli_fetch_array($query3)){
													$nome = $linha3["nome"];
													$file = $linha3["ficheiro"];
													$nome_file = $nome_file.'<a href="'.$file.'" download>'.$nome.' <img src="/img/download.png"></a><br>';


												}
												
												
												if ($respondido == 'cliente') {
													echo "<div class=\"chat_conv_client\">
																<div>
																	<label class=\"chat_div_span\">Cliente / </label> 
																	<span class=\"fonte12\"> $mensagem</span>
																</div>"; 
																if ($nome_file != '') {
																	echo "<div class=\"textr fonte12\">
																			$nome_file
																		</div>";
																}
																
															echo "</div>";
												}
												else{
													echo "<div class=\"chat_conv_bo\">
																<div>
																	<label class=\"chat_div_span\">Ci / </label> 
																	<span class=\"fonte12\"> $mensagem</span>
																</div>"; 
																if ($nome_file != '') {
																	echo "<div class=\"textr fonte12\">
																			$nome_file
																		</div>";
																}
																
															echo "</div>";
												}
												

											}

								echo "	</div>
									</div>";
							?>
						</div>
					</div>

					<form id="FORMULARIO" method="post" enctype="multipart/form-data">
						<input type="hidden" name="id_encomenda" value="<? if($existe){ echo $id_url; }?>">

						<div class="corpoCima">
							<div class="grupo">
								<div class="grupoEsq">Assunto:</div>
								<div class="grupoDir">
									<input type="text" class="inP" value="<? echo $assunto?>" disabled>
								</div>
							</div>

							<div class="grupo">
								<div class="grupoEsq">Data de Abertura:</div>
								<div class="grupoDir">
									<input type="text" class="inP" value="<? echo $data?>" disabled>
								</div>
							</div>

							<div class="grupo">
								<div class="grupoEsq">Mensagem:</div>
								<div class="grupoDir">
									<textarea class="teX" name="mensagem"></textarea>
								</div>
							</div>

							<div class="grupo">
								<div class="grupoEsq">Ficheiros:</div>
								<div class="grupoDir">
									<div class="upload_file btY"><span id="FICHEIRO">SELECIONAR FICHEIROS</span>
									<input type="file" name="imagem[]" accept="image/*" onchange="lerFicheiros(this);" multiple>
								</div>
							</div>

							<div class="clear"></div>
						</div>
						

							

						<div class="corpoBaixo">
							<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
							<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/clientes';">CANCELAR</button>
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
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/promocoes';">VOLTAR</button>
		</div>
	</div>
</div>
<!-- -->
<script>
function lerFicheiros(input) {
    var quantidade = input.files.length;
    var nome = input.value;
    if(quantidade==1){$('#FICHEIRO').html(nome);}
    else{$('#FICHEIRO').html(quantidade+' FICHEIROS');}
}

$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		mostrar('LOADING');
		e.preventDefault();
		$.ajax({
			url: "/admin/_conversa/novo.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				esconder('LOADING');

				if(data){
					mostrar('GUARDAR');
					window.history.pushState("object or string", "Title", "/admin/conversa/<? echo $id_url;?>");
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});

</script>
</body>
</html>