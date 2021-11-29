<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Produto</title>
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

	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM produto WHERE id='$id'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto WHERE id='$id'")));}

	$sep=4;
	if(!$existe){ $sub=4.2; }
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? if($existe){echo "Editar";}else{echo "Novo";}?> Produto<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/produtos">Produtos</a>
				<div class="ponto"></div>
				<a href="">Produto</a>
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
							<div class="grupoEsq">Referência:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="referencia" value="<? echo $referencia?>" autofocus required>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Titulo:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="produto_pt" value="<? echo htmlentities($produto_pt);?>" required>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Categoria:</div>
							<div class="grupoDir">
								<select class="seL" name="id_categoria">
                                	<? $query = mysqli_query($lnk,"SELECT * FROM produto_cat");
									while($linha = mysqli_fetch_array($query)){
										$id_cat = $linha['id'];
										$categoria = $linha['categoria_pt'];?>
                                    	<option class="selS" value="<? echo $id_cat?>" <? if($id_cat==$id_produto_cat){echo "selected";}?>><? echo $categoria?></option>
                                    <? }?>	
                                </select>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Dimensões:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="dimensoes" value="<? echo $dimensoes?>">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Descrição:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="5" name="descricao_pt" maxlength="400"><? echo $descricao_pt?></textarea>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Quantidade (stock):</div>
							<div class="grupoDir">
								<input type="number" class="inP" name="quantidade" value="<? echo $quantidade?>">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Produzimos:</div>
							<div class="grupoDir margin-top20">
								<input type="checkbox" id="check_<?echo $id;?>" name="produzir" class="RD" value="1" onClick="onoff4('<?echo $id;?>')" <?if(!$existe || $produzir)echo "checked";?>>
	          					<label for="check_<?echo $id;?>">&nbsp;</label>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq margin-top10">Preço (€):</div>
							<div class="grupoDir margin-top10">
								<input type="number" class="inP" name="preco" value="<? echo $preco?>" step="0.01">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq margin-top10">Preço com Desconto (€):</div>
							<div class="grupoDir margin-top10">
								<input type="number" class="inP" name="desconto" value="<? echo $desconto?>" step="0.01">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Em desconto:</div>
							<div class="grupoDir margin-top20">
								<input type="checkbox" id="che<?echo $id;?>" name="saldo" class="RD" value="1" onClick="onoff5('<?echo $id;?>')" <?if(!$existe || $saldo)echo "checked";?>>
	          					<label for="che<?echo $id;?>">&nbsp;</label>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq margin-top10">Fotografias:</div>
							<div class="grupoDir margin-top10">
								<div class="upload_file btY"><span id="FICHEIRO">SELECIONAR FICHEIROS</span>
								<input type="file" name="imagem[]" accept="image/*" onchange="lerFicheiros(this);" multiple/>
								</div>
								<div class="linhaScroll">
									<table id="sortable" class="listagem">
										<thead>
										<tr>
											<th class="none"></th>
											<th class="compMin">Imagem</th>
			                                <th>Nome</th>
											<th>Ambiente</th>
											<th>Online</th>
											<th>Opção</th>
										</tr>
										</thead>
										<tbody>
			                            <? $risca=1;
			                            $query = mysqli_query($lnk,"SELECT * FROM produto_gal WHERE id_produto='$id' ORDER BY ordem ASC");
										while($linha = mysqli_fetch_array($query))
										{
											$id_foto = $linha["id"];
											$img = $linha["img"];
											$ambiente = $linha["ambiente"];
											$online = $linha["online"];
											if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
											$risca++; ?>
				                            <tr id="linha_<? echo $id_foto?>" class="tabelaMover <? echo $classe?>">
				                            	<td class="none"></td>
												<td><img src="<? echo $img?>" class="img" alt="<? echo $img?>"></td>
												<td>&nbsp;<? echo $img?></td>
												<td>
				                                	<input type="checkbox" id="checkI<?echo $id_foto;?>" class="RD" value="1" onClick="onoff('<?echo $id_foto;?>')" <?if($ambiente)echo "checked";?>>
				          							<label for="checkI<?echo $id_foto;?>">&nbsp;</label>
												</td>
												<td>
				                                	<input type="checkbox" id="checkI<?echo $id_foto;?>" class="RD" value="1" onClick="onoff2('<?echo $id_foto;?>')" <?if($online)echo "checked";?>>
				          							<label for="checkI<?echo $id_foto;?>">&nbsp;</label>
												</td>
												<td><span class="opcoes" onclick="mostrar('APAGAR',<?echo $id_foto;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span></td>
											</tr>
			                            <?}?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq"><b>Embalagem</b></div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Comprimento (cm):</div>
							<div class="grupoDir">
								<input type="number" class="inP" name="comprimento" value="<? echo $comprimento?>" step="0.01">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Largura (cm):</div>
							<div class="grupoDir">
								<input type="number" class="inP" name="largura" value="<? echo $largura?>" step="0.01">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Altura (cm):</div>
							<div class="grupoDir">
								<input type="number" class="inP" name="altura" value="<? echo $altura?>" step="0.01">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Peso (g):</div>
							<div class="grupoDir">
								<input type="number" class="inP" name="peso" value="<? echo $peso?>" step="0.01">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Só por encomenda:</div>
							<div class="grupoDir margin-top20">
								<input type="checkbox" id="check<?echo $id;?>" name="orcamento" class="RD" value="1" onClick="onoff3('<?echo $id;?>')" <?if($orcamento)echo "checked";?>>
	          					<label for="check<?echo $id;?>">&nbsp;</label>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div id="INF2" class="corpoCima none">
						<div class="grupo">
							<div class="grupoEsq">Titulo:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="produto_en" value="<? echo htmlentities($produto_en);?>">
							</div>
						</div>						
						<div class="grupo">
							<div class="grupoEsq">Descrição:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="5" name="descricao_en" maxlength="400"><? echo $descricao_en?></textarea>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/produtos';">CANCELAR</button>					
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
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/produtos';">VOLTAR</button>
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
function onoff(id){
	$.post("/admin/funcao/js_onoff.php",{ id:id, tabela:'produto_gal', campo:'ambiente' })
	$.notific8('Guardado com sucesso.', {heading: 'Guardado'});	 	
}
function onoff2(id){
	$.post("/admin/funcao/js_onoff.php",{ id:id, tabela:'produto_gal', campo:'online' })
	$.notific8('Guardado com sucesso.', {heading: 'Guardado'});	 	
}
function onoff3(id){
	$.post("/admin/funcao/js_onoff.php",{ id:id, tabela:'produto', campo:'orcamento' })
	$.notific8('Guardado com sucesso.', {heading: 'Guardado'});	 	
}
function onoff4(id){
	$.post("/admin/funcao/js_onoff.php",{ id:id, tabela:'produto', campo:'produzir' })
	$.notific8('Guardado com sucesso.', {heading: 'Guardado'});	 	
}
function onoff5(id){
	$.post("/admin/funcao/js_onoff.php",{ id:id, tabela:'produto', campo:'saldo' })
	$.notific8('Guardado com sucesso.', {heading: 'Guardado'});	 	
}
function apagarF(){
	$.post("/admin/funcao/js_delfoto.php",{ id:id_del, tabela:'produto_gal', campo:'img' }) 
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
			url: "/admin/_produto/novo.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				esconder('LOADING');
				if(data){
					mostrar('GUARDAR');
					window.history.pushState("object or string", "Title", "/admin/produto/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});
// ORDENAR
$("#sortable tbody").sortable({
    opacity: 0.6, cursor: 'move',
    update: function() {
		var order = $(this).sortable("serialize")+'&tabela=produto_gal&campo=ordem';
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