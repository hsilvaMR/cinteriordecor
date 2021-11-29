<?php include('_seguranca_conta.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Ci | Interior Decor</title>
<? include '_head.php';?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../admin/funcao/sortable/jquery-ui.js"></script>
</head>

<body>
	<? $sepConta='fale_connosco'; include '_header.php'; ?>

	<?
		$url = $_SERVER['REQUEST_URI'];
		$urlPartes = explode("/", $url);

		$id_url = urldecode($urlPartes[2]);
		
		$exist_conversa = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda_conversa WHERE id_venda='$id_url'"));
		if($exist_conversa){
			
		}
	?>

	<div>
		<div class="modalFundo-fixed"></div>
		<div class="modalScroll"></div>
		<div class="div_conta" style="margin-bottom:100px;">
			
			<div class="div_conta_close" onClick=""></div>
				
			<div style="padding:0px 30px 45px 30px;">
				<div class="container-fluid">

				  <div class="row">
				    <div class="col-md-3">
				    	<?include '_menu-conta.php';?>
				    </div>
				    <div class="col-md-9">
				    	
				    	<p class="div_conta_desc"><? if($LANG=='pt'){echo "Fale connosco!";} if($LANG=='en'){echo "Talk to us!";} ?></p>

				    	
						<div class="div_conta_bv">
							<a href="javascript:history.go(-1)" class="return_page"><i class="fas fa-angle-left"></i> <?if($LANG=='pt') { echo "Voltar";} if($LANG=='en'){echo "Come back";}?></a>
							<? if($LANG=='pt'){echo "Aqui pode comunicar connosco, tirar as suas dúvidas,<br> ou resolver qualquer questão relativa à sua encomenda.";} if($LANG=='en'){echo "Here you can communicate with us, answer your questions,<br> or resolve any question regarding your order.";} ?>
						</div>

						<form id="FORMULARIO" method="post" enctype="multipart/form-data">
							<input id="id_encomenda" type="hidden" name="id_encomenda" value="<? echo $id_url?>">
							<div class="div_conta_opc">
								<div class="row">
									<div class="col-md-12">
										
										<div class="margin-bottom40">
											<p class="textl"><? if($LANG=='pt'){echo "Encomenda #";} if($LANG=='en'){echo "Order #";}  echo $id_url?></p>

											<div class="chat_div">
												<input id="assuno" type="text" name="assunto" placeholder="Assunto">
											</div>
											<div class="chat_div">
												<textarea id="mensagem" name="mensagem" class="teX-encomenda" placeholder="Mensagem"></textarea>
											</div>
											
											<div class="height35">
											
												<div class="chat_div_bt floatl margin-right10">
													<span class="chat_div_span verde_agua">Anexos</span>
												</div>
												

												<div class="chat_div_bt floatl" style="min-width:130px;">
													
													<label class="fonte12 margin-bottom0" id="ficheiro_upload">Printscreen.jpg</label>
												</div>
												<label class="floatl cursor-pointer" for="selecao-ficheiro"><img height="14" style="margin:9px;" src="/img/upload.png"></label>

	              								<input class="none" id="selecao-ficheiro" accept="image/*" type="file" name="imagem[]" multiple onchange="lerFicheiros(this,'ficheiro_upload');">
	              								
											

												<div class="chat_div_bt floatr">
													<input type="submit" value="GUARDAR" class="chat_div_span verde_agua cursor-pointer">
												</div>
												
											</div>

											<? if($exist_conversa){

												
												$query = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM venda_conversa WHERE id_venda='$id_url'"));

												$id_linha = $query['id'];
												$query2 = mysqli_query($lnk,"SELECT * FROM venda_conversa_msg WHERE id_venda_conversa='$id_linha'");

												echo "<div class=\"chat_conv\">		

														<div class=\"chat_conv_msg\">";

															while($linha = mysqli_fetch_array($query2)){
														
																$id_linha_msg = $linha["id"];
																$respondido = $linha["respondido"];
																$mensagem = $linha["mensagem"];

																$query3 = mysqli_query($lnk,"SELECT * FROM venda_conversa_ficheiro WHERE id_msg='$id_linha_msg'");

																$nome_file = '';
																while($linha3 = mysqli_fetch_array($query3)){
																	$nome = $linha3["nome"];
																	$file = $linha3["ficheiro"];
																	$nome_file = $nome_file.'<a style="color:rgba(0, 0, 0, 0.48);" href="'.$file.'" download>'.$nome.' <img src="/img/download.png"></a><br>';


																}
																
																
																if ($respondido == 'cliente') {
																	echo "<div class=\"chat_conv_client\">
																				<div>
																					<label class=\"chat_div_span\">Cliente / </label> 
																					<span class=\"fonte12\"> $mensagem</span>
																				</div>"; 
																				if ($nome_file != '') {
																					echo "<div class=\"textr fonte12\">
																							$nome_file
																						</div>";
																				}
																				
																			echo "</div>";
																}
																else{
																	echo "<div class=\"chat_conv_bo\">
																				<div>
																					<label class=\"chat_div_span\">Ci / </label> 
																					<span class=\"fonte12\"> $mensagem</span>
																				</div>"; 
																				if ($nome_file != '') {
																					echo "<div class=\"textr fonte12\">
																							$nome_file
																						</div>";
																				}
																				
																			echo "</div>";
																}
																

															}

												echo "	</div>
													</div>";
												}
													
											?>
										</div>
									</div>
								</div>
							</div>
						</form>
				    </div>
				  </div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<script>
	function lerFicheiros(input,id) {
      var quantidade = input.files.length;
      var nome = input.value;
      if(quantidade==1){$('#'+id).html(nome);}
      else{$('#'+id).html(quantidade+' ficheiros');}
    }

	/*function sendChatEnc() {
		var id_encomenda = $('#id_encomenda').val();
		var assunto = $('#assuno').val();
		var mensagem = $('#mensagem').val();
		var ficheiros = $('#selecao-ficheiro').val();
		console.log(ficheiros);

		$.post("/_encomenda/chat.php",{ id_encomenda:id_encomenda, assunto:assunto, mensagem:mensagem })
		.done(function( data ) {
			var jsonRetorna = $.parseJSON(data);
			var aviso = jsonRetorna['aviso'];
			var sucesso = jsonRetorna['sucesso'];
	
			if(aviso){

				$('#erroCode_header').html(aviso);
				$('#erroCode_header').show();
				$('html, body').animate({ scrollTop: 0 }, 50);
				//setTimeout(function(){ $('#erroCode_header').html(''); },3000);
			}
			else{
				if(sucesso){
					$('#sucesso_header').html(sucesso);
					$('#sucesso_header').show();
					$('html, body').animate({ scrollTop: 0 }, 50);
				}
				$('#erroCode_header').hide();
			}
		});	

	}*/


	$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {

		e.preventDefault();
		$.ajax({
			url: "/_encomenda/chat.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				var jsonRetorna = $.parseJSON(data);
				var aviso = jsonRetorna['aviso'];
				var sucesso = jsonRetorna['sucesso'];
			
				if(aviso){

					$('#erroCode_header').html(aviso);
					$('#erroCode_header').show();
					$('html, body').animate({ scrollTop: 0 }, 50);
					//setTimeout(function(){ $('#erroCode_header').html(''); },3000);
				}
				else{
					if(sucesso){
						$('#sucesso_header').html(sucesso);
						$('#sucesso_header').show();
						$('html, body').animate({ scrollTop: 0 }, 50);
					}
					$('#erroCode_header').hide();
				}
			}         
		});
	}));
});
</script>