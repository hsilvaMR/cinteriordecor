<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Promoção</title>
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
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM promocao WHERE id='$id'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM promocao WHERE id='$id'")));}

	$sep=11;
	if(!$existe){ $sub=11.2; }
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? if($existe){echo "Editar";}else{echo "Nova";}?> Promoção<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/promocoes">Promoções</a>
				<div class="ponto"></div>
				<a href="">Promoção</a>
			</div>
		</div>
		<div class="linha">
			<div class="coluna1">
				<div class="corpo">
					<form id="FORMULARIO" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<? if($existe){ echo $id; }?>">
					<div class="corpoCima">
						<div class="grupo">
							<div class="grupoEsq">Nome:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="nome" value="<? echo $nome?>" autofocus>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Percentagem:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="valor" value="<? echo $valor?>">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Promoção:</div>
							<div class="grupoDir">
								<select class="seL" name="categoria">
									<option class="selS" value="0" <? if(!$categoria){echo "selected";}?>>Todas as Categorias</option>
                                	<? $query = mysqli_query($lnk,"SELECT * FROM produto_cat");
									while($linha = mysqli_fetch_array($query)){
										$id_cat = $linha['id'];
										$nome_cat = $linha['categoria_pt'];?>
                                    	<option class="selS" value="<? echo $id_cat?>" <? if($id_cat==$categoria){echo "selected";}?>>Categoria <? echo $nome_cat?></option>
                                    <? }?>	
                                </select>
							</div>
						</div>						
						<div class="grupo">
							<div class="grupoEsq">Produtos:</div>
							<div class="grupoDir">
								<select class="seL" name="produtos">
									<option class="selS" value="stock" <? if($produtos=='stock'){echo "selected";}?>>Em Stock</option>
                                	<option class="selS" value="todos" <? if($produtos=='todos'){echo "selected";}?>>Todos</option>
                                </select>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Início:</div>
							<div class="grupoDir">
								<?if($inicio=='0000-00-00'){$inicio="";}?>
								<input type="text" class="inP" name="inicio" id="CALENDARIO" maxlength="10" value="<? echo $inicio?>" onchange="mudaCal1(this);">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Fim:</div>
							<div class="grupoDir">
								<?if($fim=='0000-00-00'){$fim="";}?>
								<input type="text" class="inP" name="fim" id="CALENDARIO2" maxlength="10" value="<? echo $fim?>" onchange="mudaCal2(this);">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Countdown:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="countdown" value="<? echo $countdown?>">
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/promocoes';">CANCELAR</button>					
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
$(function() {
	var fim = "<? echo $fim?>";
	fim = fim.replace("-",",");
	fim = fim.replace("-",",");
	$("#CALENDARIO").datepicker({ maxDate: new Date(fim) });
	var inicio = "<? echo $inicio?>";
	inicio = inicio.replace("-",",");
	inicio = inicio.replace("-",",");
	$("#CALENDARIO2").datepicker({ minDate: new Date(inicio) });
});
function mudaCal1(input) {
    var inicio = input.value;
    inicio = inicio.replace("-",",");
	inicio = inicio.replace("-",",");
	$('#CALENDARIO2').datepicker('option', 'minDate', new Date(inicio));
}
function mudaCal2(input) {
    var fim = input.value;
    fim = fim.replace("-",",");
	fim = fim.replace("-",",");
	$('#CALENDARIO').datepicker('option', 'maxDate', new Date(fim));
}
function lerFicheiros(input,id) {
    var nome = input.value;
	$('#'+id).html(nome);
}
$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		mostrar('LOADING');
		e.preventDefault();
		$.ajax({
			url: "/admin/_promocao/novo.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				esconder('LOADING');
				if(data){
					mostrar('GUARDAR');
					window.history.pushState("object or string", "Title", "/admin/promocao/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});
</script>
</body>
</html>