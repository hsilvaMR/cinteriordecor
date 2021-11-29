<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Notícia</title>
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
	$id = urldecode($urlPartes[3]);
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id='$id'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM noticia WHERE id='$id'")));}

	$sep=5;
	if(!$existe){ $sub=5.2; }
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? if($existe){echo "Editar";}else{echo "Nova";}?> Notícia<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/noticias">Notícias</a>
				<div class="ponto"></div>
				<a href="">Notícia</a>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo">
					<div class="tabs">
						<div id="TAB1" class="tab-sim" onClick="mudarTab(1);"><span class="DN1024">PT</span><span class="DB1024">Português</span></div>
						<div id="TAB2" class="tab-nao" onClick="mudarTab(2);"><span class="DN1024">EN</span><span class="DB1024">Inglês</span></div>
						<!--<div id="TAB3" class="tab-nao" onClick="mudarTab(3);"><span class="DN1024">FR</span><span class="DB1024">Francês</span></div>
						<div id="TAB4" class="tab-nao" onClick="mudarTab(4);"><span class="DN1024">ES</span><span class="DB1024">Espanhol</span></div>-->
					</div>
					<form id="FORMULARIO" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<? if($existe){ echo $id; }?>">
					<div id="INF1" class="corpoCima">
						<div class="grupo">
							<div class="grupoEsq">Titulo:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="titulo_pt" value="<? echo $titulo_pt?>" autofocus required>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Texto:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="3" name="noticia_pt" maxlength="475" required><? echo $noticia_pt?></textarea>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Data de Criação:</div>
							<div class="grupoDir">
								<?if($criacao=='0000-00-00'){$criacao="";}?>
								<input type="text" class="inP" name="criacao" id="CALENDARIO" maxlength="10" value="<? echo $criacao?>" onchange="mudaCal1(this);">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Data de Publicação:</div>
							<div class="grupoDir">
								<?if($publicacao=='0000-00-00'){$publicacao="";}?>
								<input type="text" class="inP" name="publicacao" id="CALENDARIO2" maxlength="10" value="<? echo $publicacao?>" onchange="mudaCal2(this);">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Fotografia:</div>
							<div class="grupoDir">
								<div class="upload_file btY"><span id="FICHEIRO">SELECIONAR FICHEIRO</span>
								<input type="file" name="imagem" accept="image/*" onchange="lerFicheiros(this);">
								</div>
								<div class="linhaScroll">
									<table class="listagem">
										<thead>
										<tr>
											<th class="compMin">
												Imagem
											</th>
			                                <th>
												Nome
											</th>
										</tr>
										</thead>
										<tbody>
			                            <tr class="tabelaFundoI">
											<td>
												<img src="<? echo $img?>" class="img" alt="<? echo $img?>">
											</td>
											<td>
												&nbsp;<? echo $img?>
											</td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div id="INF2" class="corpoCima none">
						<div class="grupo">
							<div class="grupoEsq">Titulo:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="titulo_en" value="<? echo $titulo_en?>">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Texto:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="3" name="noticia_en" maxlength="475"><? echo $noticia_en?></textarea>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/noticias';">CANCELAR</button>
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
			<button type="button" class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/noticias';">VOLTAR</button>
		</div>
	</div>
</div>
<!-- -->
<script>
$(function() {
	var publicacao = "<? echo $publicacao?>";
	publicacao = publicacao.replace("-",",");
	publicacao = publicacao.replace("-",",");
	$("#CALENDARIO").datepicker({ maxDate: new Date(publicacao) });
	var criacao = "<? echo $criacao?>";
	criacao = criacao.replace("-",",");
	criacao = criacao.replace("-",",");
	$("#CALENDARIO2").datepicker({ minDate: new Date(criacao),maxDate:0 });
});
function mudaCal1(input) {
    var criacao = input.value;
    criacao = criacao.replace("-",",");
	criacao = criacao.replace("-",",");
	$('#CALENDARIO2').datepicker('option', 'minDate', new Date(criacao));
}
function mudaCal2(input) {
    var publicacao = input.value;
    publicacao = publicacao.replace("-",",");
	publicacao = publicacao.replace("-",",");
	$('#CALENDARIO').datepicker('option', 'maxDate', new Date(publicacao));
}
function lerFicheiros(input) {
    var nome = input.value;
	$('#FICHEIRO').html(nome);
}
$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		mostrar('LOADING');
		e.preventDefault();
		$.ajax({
			url: "/admin/_noticia/novo.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				esconder('LOADING');
				if(data){
					mostrar('GUARDAR');
					window.history.pushState("object or string", "Title", "/admin/noticia/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});

function mudarTab(numero) {
	for (var i=2; i>0; i--) {
		if(i==numero){
			$("#TAB"+i).removeClass("tab-nao");
			$("#TAB"+i).addClass("tab-sim");
			$("#INF"+i).css("display","block");
		}
		else{
			$("#TAB"+i).removeClass("tab-sim");
			$("#TAB"+i).addClass("tab-nao");
			$("#INF"+i).css("display","none");
		}
	}
}
</script>
</body>
</html>