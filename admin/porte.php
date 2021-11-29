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
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM portes WHERE id='$id'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM portes WHERE id='$id'"))); $id_url = urldecode($urlPartes[3]);}

	$sep=12;
	if(!$existe){ $sub=12.2; }
	include '_menu.php';
	?>

	<?
		if($existe){
			/*CATEGORIA*/
			$jsonIterator = json_decode($id_categoria, TRUE);
			$query = mysqli_query($lnk,"SELECT * FROM produto_cat");
			$array_categoria = [];

			foreach ($jsonIterator as $value) {
				$array_categoria[]=[
					'id' => $value
				];
			}
				
			$array_prod_cat = [];
			while($linha = mysqli_fetch_array($query))
			{
				$id = $linha["id"];
				

				$valor = (in_array($id, array_column($array_categoria, 'id'))) ? 1 : 0;   

				$existe_n = 0;
				if ($valor == 1) {
					$existe_n = 1;
				}

				$array_prod_cat[]=[
					'id' => $id,
					'categoria_pt' => $linha["categoria_pt"],
					'existe_n' => $existe_n
				];
			}

			/*PRODUTO*/
			$jsonIterator_produto = json_decode($id_produto, TRUE);
			$query_produto = mysqli_query($lnk,"SELECT * FROM produto");
			$array_produto = [];

			foreach ($jsonIterator_produto as $value) {
				$array_produto[]=[
					'id' => $value
				];
			}


			$array_prod = [];
			while($linha = mysqli_fetch_array($query_produto))
			{
				$id = $linha["id"];
				

				$valor = (in_array($id, array_column($array_produto, 'id'))) ? 1 : 0;   

				$existe_n = 0;
				if ($valor == 1) {
					$existe_n = 1;
				}


				$array_prod[]=[
					'id' => $id,
					'id_cat' => $linha["id_produto_cat"],
					'produto' => $linha["produto_pt"],
					'preco' => $linha["preco"],
					'online' => $linha["online"],
					'existe_n' => $existe_n
				];
			}

		}
		

	
		

	?>

	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? if($existe){echo "Editar";}else{echo "Novo";}?> Porte<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/portes">Portes</a>
				<div class="ponto"></div>
				<a href="">Porte</a>
			</div>
		</div>
		<div class="linha">
			<div class="coluna1">
				<div class="corpo">
					<form id="FORMULARIO" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<? if($existe){ echo $id_url; }?>">
					<div class="corpoCima">
						<div class="grupo">
							<div class="grupoEsq">Nome:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="nome" value="<? echo $nome?>" autofocus placeholder='PORTES CI'>
							</div>
						</div>

						<div class="grupo">
							<div class="grupoEsq">Código:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="codigo" value="<? echo $codigo?>" placeholder='CODECI'>
							</div>
						</div>

						<div class="grupo">
							<div class="grupoEsq">Oferta:</div>
							<div class="grupoDir">
								<select id="history" class="seL" name="oferta" onchange="historyChanged(this);">
									<option class="selS" disabled selected>Regras de ofertas</option>
									<option class="selS" value="acima_de" <? if($tipo=='acima_de'){echo "selected";}?>>valor acima de</option>
									<option class="selS" value="desconto_perc" <? if($tipo=='desconto_perc'){echo "selected";}?>>desconto em %</option>
									<option class="selS" value="gratis" <? if($tipo=='gratis'){echo "selected";}?>>grátis</option>
		                        </select>

		                        <div id="select_acima" style="margin:20px 0 10px 0;width:100%;display:none;<? if($tipo=='acima_de'){echo "display:block";}?>">
		                        	<div style="float:left;">
		                        		<label>acima de (€)</label>
		                        		<input type="text" class="inP" name="codigo_acima" value="<? if($valor_condicao != 0){ echo $valor_condicao; }?>" placeholder='20'>
		                        	</div>

		                        	<div style="float:left;margin-left:20px;">
		                        		<label>Selecione uma opção</label>
		                        		<select id="option" class="seL" style="float:left;" name="oferta_opcao" onchange="optionChanged(this);">
		                        			<option class="selS" value="gratis_acima" <? if($gratis==1){echo "selected";}?>>grátis</option>
											<option class="selS" value="desconto_perc_acima" <? if($valor_desconto!=0){echo "selected";}?>>desconto em %</option>
				                        </select>


			                        	<div id="select_desc_acima" style="display:none;<? if($valor_desconto!=0){echo "display:block";}?>">
			                        		<input id="desc_select" type="text" class="inP" name="desc_Acima" value="<? if($valor_desconto != 0){ echo $valor_desconto; } ?>" placeholder='25'>
			                        	</div>
		                        	</div>
		                        </div>

		                        <div id="select_desconto" style="margin:20px 0 10px 0;display:none; <? if($tipo=='desconto_perc'){echo "display:block";}?>" >
		                        	
		                        	<div style="float:left;">
		                        		<label>desconto de (%)</label>
		                        		<input type="text" class="inP" name="desconto_desc" value="<? if($valor_desconto != 0){ echo $valor_desconto; } ?>" placeholder='20'>
		                        	</div>

		                        	<div style="float:left;margin-left:20px;">
		                        		<label>acima de (€) - opcional</label>
		                        		<input type="text" class="inP" name="desconto_acima" value="<? if($valor_condicao != 0){ echo $valor_condicao; }?>" placeholder='60'>
		                        	</div>
		                        </div>

							</div>
						</div>

						<div class="grupo">
							<div class="grupoEsq">Início:</div>
							<div class="grupoDir">
								<?if($data_inicio=='0000-00-00'){$data_inicio="";}?>
								<input type="text" class="inP" name="inicio" id="CALENDARIO" maxlength="10" value="<? echo $data_inicio?>" onchange="mudaCal1(this);">
							</div>
						</div>

						<div class="grupo">
							<div class="grupoEsq">Fim:</div>
							<div class="grupoDir">
								<?if($data_fim=='0000-00-00'){$data_fim="";}?>
								<input type="text" class="inP" name="fim" id="CALENDARIO2" maxlength="10" value="<? echo $data_fim?>" onchange="mudaCal2(this);">
							</div>
						</div>

						<div class="grupo">
							<div class="grupoEsq">Descrição:</div>
							<div class="grupoDir">
								<textarea class="teX" name="descricao" placeholder="Descrição do funcionamento do código"><? echo $descricao?></textarea>
							</div>
						</div>

						<div class="grupo">
							<div class="grupoEsq">Categorias:</div>
							<div class="grupoDir" style="margin:10px 0px;">
								
								<div class="linhaScroll">
									<div class="corpo tabelaBorda">
										<div class="tabelaHead">CATEGORIAS</div>
										<div class="linhaScroll">
											<table id="sortable" class="listagem">
												<thead>
												<tr>
													<th class="compMin">#&ensp;</th>
													<th>Categoria</th>
													<th></th>
												</tr>
												</thead>
												<tbody>
													<?if($existe){
														$risca=1;
														foreach ($array_prod_cat as $value) {
														
															$id = $value["id"];
															$categoria = $value["categoria_pt"];
															$existe_n = $value["existe_n"];
															if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
															$risca++; ?>
								                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
								                            	<td><? echo $id?></td>
																<td><a href="/admin/produtos/<?echo $id;?>" class="opcoes"><? echo $categoria?></a></td>
								                                <td>
								          							<input type="checkbox" name="id_categoria[]" id="check<?echo $id;?>" class="RD" value="<? echo $id?>" <? if($existe_n==1){echo "checked";}?>>
								          							<label for="check<?echo $id;?>"></label>
																</td>
															</tr>
							                            <?}

							                        }else{
							                        	$risca=1;
							                            $query = mysqli_query($lnk,"SELECT * FROM produto_cat ORDER BY ordem ASC");
														while($linha = mysqli_fetch_array($query))
														{
															$id = $linha["id"];
															$categoria = $linha["categoria_pt"];
															if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
															$risca++; ?>
								                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
								                            	<td><? echo $id?></td>
																<td><a href="/admin/produtos/<?echo $id;?>" class="opcoes"><? echo $categoria?></a></td>
								                                <td>
								          							<input type="checkbox" name="id_categoria[]" id="check<?echo $id;?>" class="RD" value="<? echo $id?>">
								          							<label for="check<?echo $id;?>"></label>
																</td>
															</tr>
							                            <?}
							                    	}
							                    	?>
												</tbody>
											</table>
										</div>
									</div>
									
								</div>
								
                                
							</div>
						</div>		

						

						<div class="grupo">
							<div class="grupoEsq">Produtos:</div>
							<div class="grupoDir" style="margin:10px 0px;">
								
                            

	                            <div class="linhaScroll">
										<div class="corpo tabelaBorda">
											<div class="tabelaHead">PRODUTOS</div>
											<div class="linhaScroll">
												<table id="sortable_1" class="listagem">
													<thead>
													<tr>
														<th class="compMin">#&ensp;</th>
														<th class="compMin">Fotografia</th>
						                                <th>Titulo</th>
														<th>Categoria</th>
														<th>Preço</th>
														<th></th>
													</tr>
													</thead>
													<tbody>
														<? if($existe){
															$risca=1;
						                            		$urlPartes = explode("/", $_SERVER['REQUEST_URI']);

						                            		foreach ($array_prod as $value)
															{
															
																$id = $value["id"];
																$id_cat = $value["id_cat"];
																$produto = $value["produto"];
																$preco = $value["preco"];
																$preco = number_format($preco,2,'.',' ').' €';
																$online = $value["online"];
																$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto_gal WHERE id_produto='$id' AND online=1"));
																$img = $linha2["img"];
																if(!$img){ $img="/admin/icon/default.jpg"; }
																$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto_cat WHERE id='$id_cat'"));
																$categoria = $linha3["categoria_pt"];
																if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
																$risca++; ?>
									                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
									                            	<td><? echo $id?></td>
																	<td><img src="<? echo $img?>" class="img"></td>
																	<td><? echo $produto?></td>
																	<td><? echo $categoria?></td>
																	<td><? echo $preco?></td>
									                                <td>
									          							<input type="checkbox" name="id_produtos[]" id="check_prod<?echo $id;?>" class="RD" value="<? echo $id?>" <? if($value['existe_n']==1){echo "checked";}?>>
			      														<label for="check_prod<?echo $id;?>"></label>
																	</td>
																</tr>
																
								                            <?}

														}else{
															$risca=1;
						                            		$urlPartes = explode("/", $_SERVER['REQUEST_URI']);
													

						                            		$query = mysqli_query($lnk,"SELECT * FROM produto ORDER BY id_produto_cat,ordem ASC");
															while($linha = mysqli_fetch_array($query))
															{
															
																$id = $linha["id"];
																$id_cat = $linha["id_produto_cat"];
																$produto = $linha["produto_pt"];
																$preco = $linha["preco"];
																$preco = number_format($preco,2,'.',' ').' €';
																$online = $linha["online"];
																$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto_gal WHERE id_produto='$id' AND online=1"));
																$img = $linha2["img"];
																if(!$img){ $img="/admin/icon/default.jpg"; }
																$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto_cat WHERE id='$id_cat'"));
																$categoria = $linha3["categoria_pt"];
																if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
																$risca++; ?>
									                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
									                            	<td><? echo $id?></td>
																	<td><img src="<? echo $img?>" class="img"></td>
																	<td><? echo $produto?></td>
																	<td><? echo $categoria?></td>
																	<td><? echo $preco?></td>
									                                <td>
									          							<input type="checkbox" name="id_produtos[]" id="check_prod<?echo $id;?>" class="RD" value="<? echo $id?>" <? if($id==$categoria){echo "checked";}?>>
			      														<label for="check_prod<?echo $id;?>"></label>
																	</td>
																</tr>
																
								                            <?}
														}?>
						                            
													</tbody>
												</table>
											</div>
										
										</div>
									
								</div>
							</div>
						</div>
						
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/portes';">CANCELAR</button>					
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
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/portes';">VOLTAR</button>
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

$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		mostrar('LOADING');
		e.preventDefault();
		$.ajax({
			url: "/admin/_portes/novo.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				console.log(data);
				esconder('LOADING');
				if(data){
					mostrar('GUARDAR');
					window.history.pushState("object or string", "Title", "/admin/porte/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});


// GERIR TABELA
$(document).ready(function(){
     $('#sortable_1').dataTable({
     	aoColumnDefs: [{ "sortable_1": false, "aTargets": [ 0 ] }],
     	lengthMenu: [[20, 100, 200, -1], [20, 100, 200, "Todos"]],
     });
});

$(document).ready(function(){
     $('#sortable').dataTable({
     	aoColumnDefs: [{ "sortable": false, "aTargets": [ 0 ] }],
     	lengthMenu: [[15, 30, 50, -1], [15, 30, 50, "Todos"]],
     });
});


function historyChanged() {
    var historySelectList = $('select#history');
    var selectedValue = $('option:selected', historySelectList).val();

   
    if(selectedValue == 'acima_de'){
    	$('#select_desconto').hide();
    	$('#select_acima').show();
    }else if (selectedValue =='desconto_perc') {
    	$('#select_acima').hide();
    	$('#select_desconto').show();
    }else{
    	$('#select_acima').hide();
    	$('#select_desconto').hide();
    }
    
   
}

function optionChanged() {
    var optionSelectList = $('select#option');
    var selectedValue = $('option:selected', optionSelectList).val();

    if(selectedValue == 'gratis_acima'){
    	$('#select_desc_acima').hide();
    	$('#desc_select').val('');
    }else if (selectedValue =='desconto_perc_acima') {
    	$('#select_desc_acima').show();
    }
}



</script>
</body>
</html>