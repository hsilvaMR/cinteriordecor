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
	$id_user = urldecode($urlPartes[3]);
	$id_morada = urldecode($urlPartes[4]);
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user_morada WHERE id='$id_morada'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user_morada WHERE id='$id_morada'")));}

	$sep=11;
	if(!$existe){ $sub=11.2; }
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? if($existe){echo "Editar";}else{echo "Nova";}?> Morada do Cliente<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/clientes">Clientes</a>
				<div class="ponto"></div>
				<a href="/admin/cliente/<? echo $id_user; ?>">Cliente</a>
				<div class="ponto"></div>
				<a href="">Morada</a>
			</div>
		</div>

		

		<div class="linha">
			<div class="coluna1">
				<div class="corpo">

					<form id="FORMULARIO" method="post" enctype="multipart/form-data">
						<input type="hidden" name="id_morada" value="<? if($existe){ echo $id_morada; }?>">
						<input type="hidden" name="id_user" value="<?echo $id_user;?>">

						<div class="corpoCima">
							<div class="grupo">
								<div class="grupoEsq">Nome de identificação:</div>
								<div class="grupoDir">
									<input type="text" class="inP" name="nome_morada" value="<? echo $nome_morada?>">
								</div>
							</div>

							<div class="grupo">
								<div class="grupoEsq">Nome:</div>
								<div class="grupoDir">
									<input type="text" class="inP" name="nome" value="<? echo $nome?>">
								</div>
							</div>

							<div class="grupo">
								<div class="grupoEsq">Apelido:</div>
								<div class="grupoDir">
									<input type="text" class="inP" name="apelido" value="<? echo $apelido?>">
								</div>
							</div>

							<div class="grupo">
								<div class="grupoEsq">Rua:</div>
								<div class="grupoDir">
									<input type="text" class="inP" name="endereco" value="<? echo $endereco?>">
								</div>
							</div>

							<div class="grupo">
								<div class="grupoEsq">Localidade:</div>
								<div class="grupoDir">
									<input type="text" class="inP" name="localidade" value="<? echo $localidade?>">
								</div>
							</div>

							<div class="grupo">
								<div class="grupoEsq">Código-Postal:</div>
								<div class="grupoDir">
									<input type="text" class="inP" name="codigo_postal" value="<? echo $codigo_postal?>">
								</div>
							</div>

							<div class="grupo">
								<div class="grupoEsq">País:</div>
								<div class="grupoDir">
									<select class="seL" name="pais">
										<option class='selS' value='0' selected disabled>Região</option>
										<option class="selS" value="Portugal" <? if($pais=='Portugal'){echo "selected";}?>>Portugal Continental</option>
	                                	<option class="selS" value="Madeira" <? if($pais=='Madeira'){echo "selected";}?>>Arquipélago da Madeira</option>
	                                	<option class="selS" value="Acores" <? if($pais=='Acores'){echo "selected";}?>>Arquipélago dos Açores</option>
	                                </select>
								</div>
							</div>

							<div class="grupo">
								<div class="grupoEsq">Contacto:</div>
								<div class="grupoDir">
									<input type="text" class="inP" name="contacto" value="<? echo $telemovel?>">
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

$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		mostrar('LOADING');
		e.preventDefault();
		$.ajax({
			url: "/admin/_morada/novo.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				esconder('LOADING');
	
				if(data){
					mostrar('GUARDAR');
					window.history.pushState("object or string", "Title", "/admin/morada/<?echo $id_user?>/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});

</script>
</body>
</html>