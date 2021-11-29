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
</head>

<body>
	<? $sepConta='moradas'; $sepConta_morada='moradas_empty'; include '_header.php'; ?>

	<?
		if ($_COOKIE["USER"]) {
			$id_user = $_COOKIE["USER"];

			$morada = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user_morada WHERE id_user='$id_user'"));
		}

		if ($morada) {$sepConta_morada='moradas';}
	?>


	<div>
		<div class="modalFundo-fixed"></div>
		<div class="modalScroll"></div>
		<div class="div_conta">
			
			<div class="div_conta_close" onClick=""></div>
				
			<div style="padding:0px 30px 45px 30px;">
				<div class="container-fluid">

				  	<div class="row">
					    <div class="col-md-4 col-lg-3">
					    	<?include '_menu-conta.php';?>
					    </div>
					    <div class="col-md-8 col-lg-9">
					    	<p class="div_conta_desc"><? if($LANG=='pt'){echo "As minhas moradas";} if($LANG=='en'){echo "My addresses";} ?></p>

					    	<?
						    	if ($morada) {

						    		if($LANG=='pt'){$lang_html="Neste painel, adicione, apague e atualize as suas moradas. Mais tarde <br>no acto da encomenda escolha em que morada facturar e receber a entrega."; $lang_html_add = "<a class=\"verde_agua hover_cinza_12\" href=\"/nova-morada\"><i class=\"fas fa-plus\"></i> Adicionar morada</a>";} 
						    		if($LANG=='en'){$lang_html="In this panel, add, delete and update your addresses. Later <br>on when ordering choose which address to bill and receive delivery."; 
						    			$lang_html_add = "<a class=\"verde_agua hover_cinza_12\" href=\"/nova-morada\"><i class=\"fas fa-plus\"></i> Add address</a>";}

						    		echo "<div class=\"div_conta_bv\"><a href=\"javascript:history.go(-1)\" class=\"return_page\"><i class=\"fas fa-angle-left\"></i> Voltar </a>$lang_html</div> <p class=\"div_conta_bv_p\">$lang_html_add</p>";
						    	}
						    	else{
						    		if($LANG=='pt'){$lang_html="Não existem moradas disponíveis";} 
						    		if($LANG=='en'){$lang_html="No addresses available";}

						    		echo "<div class=\"div_conta_bv\">$lang_html</div>";
						    	}
							?>

							
							<? 
								if ($morada) {
									$query = mysqli_query($lnk,"SELECT * FROM user_morada WHERE id_user='$id_user'");
									while($linha = mysqli_fetch_array($query))
									{
										
										$id_linha = $linha["id"];
										$nome_html = $linha["nome"];
										$apelido_html = $linha["apelido"];
										$morada_html = $linha["endereco"];
										$code_html = $linha["codigo_postal"];
										$localidade_html = $linha["localidade"];
										$pais_html = $linha["pais"];
										$telemovel = $linha["telemovel"];

											
										echo "<div id=\"morada_$id_linha\" class=\"morada_div_conta_opc\"><div class=\"row\"><div class=\"col-md-12\"><div class=\"textl\"><span class=\"floatr fonte12\"> <a href=\"/nova-morada/$id_linha\" class=\"verde_agua margin-right20 hover_cinza_12\"><i class=\"fas fa-sync-alt\"></i> Atualizar</a> <a onClick=\"apagarMorada($id_linha)\" class=\"verde_agua hover_cinza_12\"><i class=\"fa fa-times\"></i> Apagar</a></span><b>$nome_html $apelido_html</b> <p>$morada_html<br>$code_html<br>$localidade_html - $pais_html <br>$telemovel</p></div></div></div></div>";
										
										
									}
									
								}else{
									if($LANG=='pt'){$add="+ Adicionar Morada";} 
									if($LANG=='en'){$add="+ Add Address";} 

									echo "<div class=\"div_conta_opc\"><div class=\"row\"><div class=\"col-md-4\">
											<a href=\"/nova-morada\">
												<div class=\"div_conta_opc_qd margin-bottom20\">
													<img height=\"30\" src=\"/img/perfil/Painel_icon_Pin.png\"><br>
													<span>$add</span>
												</div>
											</a>
										</div></div></div>";
								}
							?>
									
								
					    </div>
				  	</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>


<script>
	function apagarMorada(id){
		$.post("/_morada/js_apagar.php",{id:id}) 
		.done(function( data ){
		  	var jsonRetorna = $.parseJSON(data);
			var sucesso = jsonRetorna['sucesso'];
		
			
			if(sucesso){
				$('#sucesso_header').html(sucesso);
				$('#sucesso_header').show();
				$('html, body').animate({ scrollTop: 0 }, 50);

				$('#morada_'+id).remove();
			}
			$('#erroCode_header').hide();
		});
	}
</script>