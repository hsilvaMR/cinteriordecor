<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Portes</title>
	<? include '_head.php';?>

	<!-- CALENDARIO -->
	<link href="/admin/funcao/datepicker/jquery-ui.css" rel="stylesheet">
	<script src="/admin/funcao/datepicker/jquery-ui.js" type="text/javascript"></script>



</head>

<body>
<? include '_header.php';?>

<article>
	<?
	$url = $_SERVER['REQUEST_URI'];
	$urlPartes = explode("/", $url);
	$id_url = urldecode($urlPartes[3]);

	$sep=16;
	if(!$existe){ $sub=16.2; }
	include '_menu.php';
	?>

	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? if($existe){echo "Editar";}else{echo "Atribuir";}?> Vale de Desconto<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/clientes">Clientes</a>
				<div class="ponto"></div>
				<a href="">Vale de Desconto</a>
			</div>
		</div>
		<div class="linha">
			<div class="coluna1">
				<div class="corpo">
					<form id="FORMULARIO_" method="post" enctype="multipart/form-data">
						<input type="hidden" name="id_user" value="<? echo $id_url;?>">
						<div class="corpoCima">
							<div class="grupo">
								<div class="grupoEsq">Vale de Desconto:</div>
								<div class="grupoDir">
									<select id="history" class="seL" name="oferta">
										<option class="selS" disabled selected>Selecione o vale de desconto para atribuir ao cliente</option>
										<?
											$query = mysqli_query($lnk,"SELECT * FROM vales_desconto");
											$hoje=date('Y-m-d');

											while($linha = mysqli_fetch_array($query))
											{	
												$nome = $linha["nome"];
												$id_linha = $linha["id"];
												$inicio = $linha["data_inicio"];
												$fim = $linha["data_fim"];

												$query_user = mysqli_query($lnk,"SELECT * FROM user_vales WHERE id_vale='$id_linha'");
												$cupao = mysqli_fetch_assoc($query_user);

												if ($inicio<=$hoje && $fim>=$hoje) {
													$txt = '';
													if($cupao["id_vale"] == $id_linha){ $txt = 'disabled'; };
												
													echo "<option class=\"selS\" value=\"$id_linha\" $txt>$nome</option>";
												}
											}
											
										?>
			                        </select>
								</div>
							</div>

							<div class="clear"></div>			
						</div>
						<div class="corpoBaixo">
							<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
							<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/vales';">CANCELAR</button>					
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
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/cliente/<?echo $id_url?>';">VOLTAR</button>
		</div>
	</div>
</div>
<!-- -->
<script>
$(document).ready(function (e) {
	$("#FORMULARIO_").on('submit',(function(e) {
		//mostrar('LOADING');
		e.preventDefault();
		$.ajax({
			url: "/admin/_vales/atribuir.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				console.log(data);
				//esconder('LOADING');
				if(data){
					mostrar('GUARDAR');
					window.history.pushState("object or string", "Title", "/admin/cliente/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});
</script>
</body>
</html>