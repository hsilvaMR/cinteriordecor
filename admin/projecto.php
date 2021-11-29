<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Projecto</title>
	<? include '_head.php';?>
	<!-- ORDENAR -->
	<script src="/admin/funcao/sortable/jquery-ui.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<?
	$url = $_SERVER['REQUEST_URI'];
	$urlPartes = explode("/", $url);
	$id = urldecode($urlPartes[3]);
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM projeto WHERE id='$id'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM projeto WHERE id='$id'")));}

	$sep=3;
	if(!$existe){ $sub=3.2; }
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? if($existe){echo "Editar";}else{echo "Novo";}?> Projecto<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/projectos">Projectos</a>
				<div class="ponto"></div>
				<a href="">Projecto</a>
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
								<textarea class="teX" rows="3" name="titulo_pt" autofocus required><? echo $titulo_pt?></textarea>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Nome:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="3" name="nome_pt" maxlength="60" required><? echo $nome_pt?></textarea>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Texto:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="4" name="texto_pt" maxlength="400"><? echo $texto_pt?></textarea>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Fotografias:</div>
							<div class="grupoDir">
								<div class="upload_file btY"><span id="FICHEIRO">SELECIONAR FICHEIROS</span>
								<input type="file" name="imagem[]" accept="image/*" onchange="lerFicheiros(this);" multiple>
								</div>
								<div class="linhaScroll">
									<table id="sortable" class="listagem">
										<thead>
										<tr>
											<th class="compMin">Imagem</th>
			                                <th>Nome</th>
											<th>Capa</th>
											<th>Online</th>
											<th>Opção</th>
										</tr>
										</thead>
										<tbody>
			                            <? $risca=1;
			                            $query = mysqli_query($lnk,"SELECT * FROM projeto_gal WHERE id_projeto='$id' ORDER BY ordem ASC");
										while($linha = mysqli_fetch_array($query))
										{
											$id_foto = $linha["id"];
											$img = $linha["img"];
											$capa = $linha["capa"];
											$online = $linha["online"];
											if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
											$risca++; ?>
				                            <tr id="linha_<? echo $id_foto?>" class="tabelaMover <? echo $classe?>">
												<td>
													<img src="<? echo $img?>" class="img" alt="<? echo $img?>">
												</td>
												<td>
													&nbsp;<? echo $img?>
												</td>
												<td>
				                                	<input type="radio" id="capa<?echo $id_foto;?>" name="radiobutton" class="RD" value="1" onClick="onunico('<?echo $id_foto;?>')" <?if($capa)echo "checked";?>>
				          							<label for="capa<?echo $id_foto;?>">&nbsp;</label>
												</td>
												<td>
				                                	<input type="checkbox" id="check<?echo $id_foto;?>" class="RD" value="1" onClick="onoff('<?echo $id_foto;?>')" <?if($online)echo "checked";?>>
				          							<label for="check<?echo $id_foto;?>">&nbsp;</label>
												</td>
												<td>
													<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id_foto;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
												</td>
											</tr>
			                            <?}?>
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
								<textarea class="teX" rows="3" name="titulo_en"><? echo $titulo_en?></textarea>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Nome:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="3" name="nome_en" maxlength="60"><? echo $nome_en?></textarea>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Texto:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="4" name="texto_en" maxlength="400"><? echo $texto_en?></textarea>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/projectos';">CANCELAR</button>					
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
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/projectos';">VOLTAR</button>
		</div>
	</div>
</div>
<div id="APAGAR" class="modal">
	<div class="modalFundo" onClick="esconder('APAGAR');"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="esconder('APAGAR');"></span>
	<div class="modalSize">
		<div class="modalHead">Apagar</div>
		<div class="modalBody">Tem a certeza que deseja apagar?</div>
		<div class="modalFoot">
			<button class="btV modalBt" name="sim" onclick="apagarF()">SIM</button>
			<button class="btA modalBt" name="nao" onclick="esconder('APAGAR');">NÃO</button>
		</div>
	</div>
</div>
<!-- -->
<script>
$(document).keyup(function(e) {
     if (e.keyCode == 27) { esconder('APAGAR'); }
});
function apagarF(){
	$.post("/admin/funcao/js_delfoto.php",{ id:id_del, tabela:'projeto_gal', campo:'img' }) 
    .done(function( data ){
		$('#linha_'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });
}
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
			url: "/admin/_projeto/novo.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				esconder('LOADING');
				if(data){
					mostrar('GUARDAR');
					window.history.pushState("object or string", "Title", "/admin/projecto/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});
function onoff(id){
	$.post("/admin/funcao/js_onoff.php",{ id:id, tabela:'projeto_gal', campo:'online' })
	$.notific8('Guardado com sucesso.', {heading: 'Guardado'});
}
function onunico(id){
	$.post("/admin/funcao/js_onunico.php",{ id:id, tabela:'projeto_gal', campoZ:'id_projeto', campo:'capa' })
	$.notific8('Guardado com sucesso.', {heading: 'Guardado'});
}
// ORDENAR
$("#sortable tbody").sortable({
    opacity: 0.6, cursor: 'move',
    update: function() {
		var order = $(this).sortable("serialize")+'&tabela=projeto_gal&campo=ordem';
		$.post("/admin/funcao/ordenar.php", order);
		$.notific8('Guardado com sucesso.', {heading: 'Guardado'});
    }
}).disableSelection();

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