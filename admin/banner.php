<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Banner</title>
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
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM banner WHERE id='$id'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM banner WHERE id='$id'")));}

	$sep=10;
	if(!$existe){ $sub=10.2; }
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? if($existe){echo "Editar";}else{echo "Nova";}?> Banner<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/banners">Banners</a>
				<div class="ponto"></div>
				<a href="">Banner</a>
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
						<div class="grupo linhaScroll">
							<div class="grupoEsq">Telemóvel:</div>
							<div class="grupoDir">
								<div class="upload_file btY"><span id="FICHEIRO">SELECIONAR FICHEIRO</span>
								<input type="file" name="tlm" accept="image/*" onchange="lerFicheiros(this,'FICHEIRO');">
								</div>
								<div class="linhaScroll">
									<table class="listagem">
										<thead>
										<tr>
											<th class="compMin">Imagem</th>
			                                <th>Nome</th>
										</tr>
										</thead>
										<tbody>
			                            <tr class="tabelaFundoI">
											<td><img src="<? echo $tlm?>" class="img" alt="<? echo $tlm?>"></td>
											<td>&nbsp;<? echo $tlm?></td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="grupo linhaScroll">
							<div class="grupoEsq">Computador:</div>
							<div class="grupoDir">
								<div class="upload_file btY"><span id="FILE">SELECIONAR FICHEIRO</span>
								<input type="file" name="pc" accept="image/*" onchange="lerFicheiros(this,'FILE');">
								</div>
								<div class="linhaScroll">
									<table class="listagem">
										<thead>
										<tr>
											<th class="compMin">Imagem</th>
			                                <th>Nome</th>
										</tr>
										</thead>
										<tbody>
			                            <tr class="tabelaFundoI">
											<td><img src="<? echo $pc?>" class="img" alt="<? echo $pc?>"></td>
											<td>&nbsp;<? echo $pc?></td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Link:</div>
							<div class="grupoDir">
								<select class="seL" name="url">
									<option class="selS" value=""></option>
									<option class="selS" value="/loja" <? if('/loja'==$url){echo "selected";}?>>Loja Online</option>
                                	<? $query = mysqli_query($lnk,"SELECT * FROM produto_cat");
									while($linha = mysqli_fetch_array($query)){
										$id_cat = $linha['id'];
										$categoria = $linha['categoria_pt'];?>
                                    	<option class="selS" value="<? echo $id_cat?>" <? if($id_cat==$url){echo "selected";}?>>Categoria <? echo $categoria?></option>
                                    <? }?>	
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
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/banners';">CANCELAR</button>					
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
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/banners';">VOLTAR</button>
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
			url: "/admin/_banner/novo.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				esconder('LOADING');
				if(data){
					mostrar('GUARDAR');
					window.history.pushState("object or string", "Title", "/admin/banner/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});
</script>
</body>
</html>