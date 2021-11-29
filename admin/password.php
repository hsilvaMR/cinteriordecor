<?php $permissao='guest'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Password</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=9; include '_menu.php'; ?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Alterar Password<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Password</a>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo">
					<form id="FORMULARIO" method="post">
					<div id="INF1" class="corpoCima">
						<div class="grupo">
							<div class="grupoEsq">Password antiga:</div>
							<div class="grupoDir">
								<input type="password" class="inP" name="antiga" value="" required autofocus>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Password nova:</div>
							<div class="grupoDir">
								<input type="password" class="inP" name="nova" value="" required>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Password confirmação:</div>
							<div class="grupoDir">
								<input type="password" class="inP" name="confirmacao" value="" required>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/painel';">CANCELAR</button>					
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
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/painel';">VOLTAR</button>
		</div>
	</div>
</div>
<!-- -->
<script>
$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
			url: "/admin/_password/novo.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				if(data){
					if(data=='TM'){mostrar('GUARDAR');}
					else{$.notific8(data, {heading: 'Erro', theme: 'ruby'});}
					//window.history.pushState("object or string", "Title", "/admin/moeda/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});
</script>
</body>
</html>