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
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id'"))); $id_url = urldecode($urlPartes[3]);}

	$sep=16;
	if(!$existe){ $sub=16.2; }
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? if($existe){echo "Editar";}else{echo "Nova";}?> Cliente<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/clientes">Clientes</a>
				<div class="ponto"></div>
				<a href="">Cliente</a>
			</div>
		</div>

		

		<div class="linha">
			<div class="coluna1">
				<div class="corpo">

					<div class="tab-opc">
					    <div id="TAB1" class="tab tab-active" onClick="mudarTab(1);">Dados Pessoais</div>
					    <? if($existe){ echo "<div id=\"TAB2\" class=\"tab\" onClick=\"mudarTab(2);\">Moradas</div>
					    <div id=\"TAB3\" class=\"tab\" onClick=\"mudarTab(3);\">Encomendas</div>
					    <div id=\"TAB4\" class=\"tab\" onClick=\"mudarTab(4);\">Vales de desconto</div>";}?>
					</div>

					<div id="INF1">

						<form id="FORMULARIO" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<? if($existe){ echo $id; }?>">

							<div class="corpoCima">
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
									<div class="grupoEsq">Email:</div>
									<div class="grupoDir">
										<input type="email" class="inP" name="email" value="<? echo $email?>">
									</div>
								</div>

								<div class="grupo">
									<div class="grupoEsq">Contacto:</div>
									<div class="grupoDir">
										<input type="text" class="inP" name="contacto" value="<? echo $contacto?>">
									</div>
								</div>

								<div class="grupo">
									<div class="grupoEsq">NIF:</div>
									<div class="grupoDir">
										<input type="text" class="inP" name="nif" value="<? echo $nif?>">
									</div>
								</div>

								<div class="grupo">
									<div class="grupoEsq">Tipo de Cliente:</div>
									<div class="grupoDir">
										<select class="seL" name="tipo_cliente">
											<option class="selS" value="cliente" <? if($tipo_cliente=='cliente'){echo "selected";}?>>Cliente</option>
		                                	<option class="selS" value="empresa" <? if($tipo_cliente=='empresa'){echo "selected";}?>>Empresa</option>
		                                </select>
									</div>
								</div>

								<div class="grupo">
									<div class="grupoEsq">Estado:</div>
									<div class="grupoDir">
										<select class="seL" name="estado">
											<option class="selS" value="ativo" <? if($estado=='ativo'){echo "selected";}?>>Ativo</option>
		                                	<option class="selS" value="pendente" <? if($estado=='pendente'){echo "selected";}?>>Pendente</option>
		                                </select>
									</div>
								</div>

								<div class="grupo">
									<div class="grupoEsq">Deseja ser informado das campanhas da Ci:</div>
									<div class="grupoDir">
										<input name="check_descontos" type="checkbox" id="check<?echo $id;?>" class="RD" value="1" <?if($check_descontos == 1)echo "checked";?>>
	          							<label class="margin-top20" for="check<?echo $id;?>">&nbsp;</label>
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

					<div id="INF2" class="none margin-top20">

						<button class="btV floatr margin-bottom20" onClick="window.location.href='/admin/morada/<? echo $id_url?>';">ADICIONAR NOVO</button>
						<div class="clear"></div>
						<div class="linhaScroll">
							<table id="sortable" class="listagem">
								<thead>
								<tr>
									<th class="none"></th>
									<th class="compMin">#&ensp;</th>
									<th>Morada</th>
									<th>Opção</th>
								</tr>
								</thead>
								<tbody>
	                            <? $risca=1;
	                            $hoje=date('Y-m-d');
	                            $query = mysqli_query($lnk,"SELECT * FROM user_morada where id_user = '$id'");
								while($linha = mysqli_fetch_array($query))
								{
									$id = $linha["id"];
									$nome_morada = $linha["nome_morada"];
									$endereco = $linha["endereco"];
									
									if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
									$risca++; ?>
		                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
		                            	<td class="none"></td>
										<td><? echo $id?></td>
										<td><? if($nome_morada!=''){echo $nome_morada;}else{echo $endereco;} ?></td>
										<td>
											<a href="/admin/morada/<? echo $id_url?>/<?echo $id;?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>&nbsp;&nbsp;
											<span class="opcoes" onclick="mostrar('APAGAR_MORADA',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
										</td>
									</tr>
	                            <?}?>
								</tbody>
							</table>
						</div>
  					</div>

  					<div id="INF3" class="none margin-top20">
   						<div class="linhaScroll">
							<table id="sortable-encomenda" class="listagem">
								<thead>
								<tr>
									<th class="none"></th>
									<th class="compMin">#&ensp;</th>
									<th>Nome</th>
									<th>Email</th>
									<th>Contacto</th>
									<th>Etapa</th>
									<th>Data da Venda</th>
									<th>Opção</th>
								</tr>
								</thead>
								<tbody>
	                            <? $risca=1;
	                            $query = mysqli_query($lnk,"SELECT * FROM venda where id_user='$id_url' ORDER BY id DESC");
								while($linha = mysqli_fetch_array($query))
								{
									$id_venda = $linha["id"];
									$id_produto = $linha["id_produto"];
									$nome = $linha["nome"];
									$email = $linha["email"];
									$contacto = $linha["contacto"];
									$data = $linha["data"];
									$hora = $linha["hora"];
									$hora = substr($hora, 0, 5);
									$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tracking where id_venda='$id_venda' ORDER BY id DESC"));
									$id_tracking = $linha2["id_tracking_est"];
									$data_tracking = $linha2["data"];
									$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tracking_est where id='$id_tracking'"));
									$etapa = $linha3["descricao_pt"];
									if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
									$risca++; ?>
		                            <tr id="linha_<? echo $id_venda?>" class="<? echo $classe?>">
		                            	<td class="none"></td>
		                            	<td><? echo $id_venda?></td>
										<td><a href="/admin/venda/<?echo $id_venda;?>" class="opcoes"><? echo $nome?></a></td>
										<td><a href="mailto:<? echo $email?>"><? echo $email?></a></td>
										<td><? echo $contacto?></td>
										<td>
											<a href="/admin/venda_tracking/<?echo $id_venda;?>" class="opcoes">
												<?if($id_tracking=='1'){?><span class="labelAzul"><? echo $etapa?></span><?}?>
												<?if($id_tracking=='2'){?><span class="labelVermelho"><? echo $etapa?></span><?}?>
												<?if($id_tracking=='3'){?><span class="labelRoxo"><? echo $etapa?></span><?}?>
			                                	<?if($id_tracking=='4'){?><span class="labelAmarelo"><? echo $etapa?></span><?}?>
			                                	<?if($id_tracking=='5'){?><span class="labelAzul"><? echo $etapa?></span><?}?>
			                                	<?if($id_tracking=='6'){?><span class="labelVerde"><? echo $etapa?></span><?}?>
			                                	<?if($id_tracking=='7'){?><span class="labelCinza"><? echo $etapa?></span><?}?>
		                                	</a>
										</td>
		                                <td><? echo $data." ".$hora?></td>
										<td>
											<a href="/admin/venda_produtos/<?echo $id_venda;?>" class="opcoes"><span class="lnr lnr-menu-circle"></span>&nbsp;Produtos</a>&nbsp;&nbsp;
											<a href="/admin/venda/<?echo $id_venda;?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>&nbsp;&nbsp;
											<a href="/admin/conversa/<?echo $id_venda;?>" class="opcoes"><span class="lnr lnr-envelope"></span>&nbsp;Conversa</a>&nbsp;&nbsp;
											<span class="opcoes" onclick="mostrar('APAGAR_ENCOMENDA',<?echo $id_venda;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
										</td>
									</tr>
	                            <?}?>
								</tbody>
							</table>
						</div>
  					</div>

  					<div id="INF4" class="none">
   						<button class="btV floatr margin-bottom20 margin-top20" onClick="window.location.href='/admin/vale_cliente/<? echo $id_url?>';">ATRIBUIR VALE</button>
   						<div class="clear"></div>
						<div class="linhaScroll">
							<table id="sortable_vale" class="listagem">
								<thead>
								<tr>
									<th class="none"></th>
									<th class="compMin">#&ensp;</th>
									<th>Vale</th>
									<th>Validade</th>
									<th>Data de Atribuição</th>
									<th>Utilizado na encomenda</th>
									<th>Data de Utilização</th>
									<th>Opção</th>
								</tr>
								</thead>
								<tbody>
	                            <? $risca=1;
	                            $hoje=date('Y-m-d');
	                            $query = mysqli_query($lnk,"SELECT * FROM user_vales where id_user = '$id_url'");

								while($linha = mysqli_fetch_array($query))
								{
									$id = $linha["id"];
									$id_vale = $linha["id_vale"];
									$id_venda = $linha["id_venda"];
									$data_atribuicao = $linha["data"];
									$data_utilizacao = $linha["data_utilizacao"];

									$query_vale = mysqli_query($lnk,"SELECT * FROM vales_desconto where id = '$id_vale'");
									$cupao = mysqli_fetch_assoc($query_vale);
									$hoje=date('Y-m-d');

									if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
									$risca++; ?>
		                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
		                            	<td class="none"></td>
										<td><? echo $id?></td>
										<td><? echo $cupao["nome"] ?></td>
										<td>
											<?if($cupao["data_inicio"]<=$hoje && $cupao["data_fim"]>=$hoje){?><span class="labelVerde"><? echo $cupao["data_inicio"].' a '.$cupao["data_fim"];?></span>
		                                	<?}elseif($cupao["data_inicio"]>$hoje){?><span class="labelAmarelo"><? echo $cupao["data_inicio"].' a '.$cupao["data_fim"];?>
		                                	<?}else{?><span class="labelCinza"><? echo $cupao["data_inicio"].' a '.$cupao["data_fim"];?><?}?>
										</td>
										<td><? echo $data_atribuicao ?></td>
										<td><? echo $id_venda ?></td>
										<td><? if ($data_utilizacao != '0000-00-00') {echo $data_utilizacao;} ?></td>
										<td><span class="opcoes" onclick="mostrar('APAGAR_CUPAO',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
										</td>
									</tr>
	                            <?}?>
								</tbody>
							</table>
						</div>
						<div class="clear"></div>
  					</div>
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
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/clientes';">VOLTAR</button>
		</div>
	</div>
</div>

<!-- MODALS -->
<div id="APAGAR_MORADA" class="modal">
	<div class="modalFundo" onClick="esconder('APAGAR');"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="esconder('APAGAR');"></span>
	<div class="modalSize">
		<div class="modalHead">Apagar</div>
		<div class="modalBody">Tem a certeza que deseja apagar?</div>
		<div class="modalFoot">
			<button class="btV modalBt" name="sim" onclick="apagar()">SIM</button>
			<button class="btA modalBt" name="nao" onclick="esconder('APAGAR');">NÃO</button>
		</div>
	</div>
</div>

<div id="APAGAR_ENCOMENDA" class="modal">
	<div class="modalFundo" onClick="esconder('APAGAR');"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="esconder('APAGAR');"></span>
	<div class="modalSize">
		<div class="modalHead">Apagar</div>
		<div class="modalBody">Tem a certeza que deseja apagar?</div>
		<div class="modalFoot">
			<button class="btV modalBt" name="sim" onclick="apagarEnc()">SIM</button>
			<button class="btA modalBt" name="nao" onclick="esconder('APAGAR');">NÃO</button>
		</div>
	</div>
</div>

<div id="APAGAR_CUPAO" class="modal">
	<div class="modalFundo" onClick="esconder('APAGAR');"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="esconder('APAGAR');"></span>
	<div class="modalSize">
		<div class="modalHead">Apagar</div>
		<div class="modalBody">Tem a certeza que deseja apagar?</div>
		<div class="modalFoot">
			<button class="btV modalBt" name="sim" onclick="apagarCupao()">SIM</button>
			<button class="btA modalBt" name="nao" onclick="esconder('APAGAR');">NÃO</button>
		</div>
	</div>
</div>



<!-- -->
<script>
function mudarTab(numero) {
    var tabs = $('.tab-opc').find('.tab').length;
    for (var i=tabs; i>0; i--) {
      if(i==numero){
        $("#TAB"+i).addClass("tab-active");
        $("#INF"+i).css("display","block");
      }
      else{
        $("#TAB"+i).removeClass("tab-active");
        $("#INF"+i).css("display","none");
      }
    }
}

$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		mostrar('LOADING');
		e.preventDefault();
		$.ajax({
			url: "/admin/_cliente/novo.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				esconder('LOADING');
		
				if(data){
					mostrar('GUARDAR');
					window.history.pushState("object or string", "Title", "/admin/clientes");
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});

$(document).keyup(function(e) {
     if (e.keyCode == 27) { esconder('APAGAR'); }
});
function apagar(){
	$.post("/admin/funcao/js_del.php",{ id:id_del, tabela:'user_morada' }) 
    .done(function( data ){
		$('#linha_'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });
}

function apagarEnc(){
	$.post("/admin/funcao/js_del.php",{ id:id_del, tabela:'venda' }) 
    .done(function( data ){
		$('#linha_'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });
}

function apagarCupao(){
	$.post("/admin/funcao/js_del.php",{ id:id_del, tabela:'user_vales' }) 
    .done(function( data ){
		$('#linha_'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });
}



// GERIR TABELA
$(document).ready(function(){
     $('#sortable').dataTable({
     	aoColumnDefs: [{ "bSortable": false, "aTargets": [ 3 ] }],
     	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
     });
});

$(document).ready(function(){
     $('#sortable-encomenda').dataTable({
     	aoColumnDefs: [{ "bSortable": false, "aTargets": [ 3 ] }],
     	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
     });
});

$(document).ready(function(){
     $('#sortable_vale').dataTable({
     	aoColumnDefs: [{ "bSortable": false, "aTargets": [ 7 ] }],
     	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
     });
});


</script>
</body>
</html>