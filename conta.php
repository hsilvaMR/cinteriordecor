<?php include('_seguranca_conta.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Ci | Interior Decor</title>
<? include '_head.php';?>

<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<?
	if ($_COOKIE["USER"]) {
		$id = $_COOKIE["USER"];

		$user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id'"));
	}
	
?>
<body>
	<? $sepConta='conta'; include '_header.php'; ?>

	<div class="modalFundo-fixed"></div>
		<div class="modalScroll"></div>
		<div class="div_conta">
		
			
			<div class="div_conta_close" onClick=""></div>
				
			<div style="padding:0px 30px 45px 30px;">
				<div class="container-fluid">

				  <div class="row">
				    <div class="col-md-3">
				    	<?include '_menu-conta.php';?>
				    </div>
				    <div class="col-md-9">
				    	<p class="div_conta_desc"><? if($LANG=='pt'){echo "A minha conta";} if($LANG=='en'){echo "My account";} ?></p>

						<div class="div_conta_bv"><? if($LANG=='pt'){echo "Bem-vindo à sua conta, aqui pode administrar a sua informação pessoal e  as suas encomendas.";} if($LANG=='en'){echo "Welcome to your account, here you can manage your personal information and orders.";} ?></div>

						<div class="div_conta_opc">
							<div class="row">
								<div class="col-md-4">
									<div class="switch_1">
										<a <? if($user['estado'] == 'ativo'){ echo "href=\"/nova-morada\""; }?>>
											<div id="pin" class="div_conta_opc_qd margin-bottom20">
												<img class="margin-bottom5" height="30" src="/img/perfil/Painel_icon_Pin.png"><br>
												<span><? if($LANG=='pt'){echo "Adicionar Morada";} if($LANG=='en'){echo "Add Address";} ?></span>
											</div>
										</a>

										<a <? if($user['estado'] == 'ativo'){ echo "href=\"/nova-morada\""; }?>>
											<div id="pin_invertido" class="div_conta_opc_qd_invert margin-bottom20 none">
												<img class="margin-bottom5" height="30" src="/img/perfil/Painel_icon_Pin_invertido.png"><br>
												<span><? if($LANG=='pt'){echo "Adicionar Morada";} if($LANG=='en'){echo "Add Address";} ?></span>
											</div>
										</a>
									</div>
									
									<div class="switch_2">
										<a <? if($user['estado'] == 'ativo'){ echo "href=\"/morada\""; }?>>
											<div id="moradas" class="div_conta_opc_qd">
												<img class="margin-bottom5" height="30" src="/img/perfil/Painel_icon_Moradas.png"><br>
												<span><? if($LANG=='pt'){echo "As minhas moradas";} if($LANG=='en'){echo "My addresses";} ?></span>
											</div>
										</a>

										<a <? if($user['estado'] == 'ativo'){ echo "href=\"/morada\""; }?>>
											<div id="moradas_invertido" class="div_conta_opc_qd_invert none">
												<img class="margin-bottom5" height="30" src="/img/perfil/Painel_icon_Moradas_invertido.png"><br>
												<span><? if($LANG=='pt'){echo "As minhas moradas";} if($LANG=='en'){echo "My addresses";} ?></span>
											</div>
										</a>
									</div>
									
								</div>
								<div class="col-md-4">
									<div class="switch_3">
										<div id="encomendas" class="div_conta_opc_qd margin-bottom20">
											<img class="margin-bottom5" height="30" src="/img/perfil/Painel_icon_Encomendas.png"><br>
											<span><? if($LANG=='pt'){echo "As minhas encomendas";} if($LANG=='en'){echo "My orders";} ?></span>
										</div>

										<div id="encomendas_invertido" class="div_conta_opc_qd_invert margin-bottom20 none">
											<img class="margin-bottom5" height="30" src="/img/perfil/Painel_icon_Encomendas_invertido.png"><br>
											<span><? if($LANG=='pt'){echo "As minhas encomendas";} if($LANG=='en'){echo "My orders";} ?></span>
										</div>
									</div>
									
									<div class="switch_4">
										<a <? if($user['estado'] == 'ativo'){ echo "href=\"/dados-pessoais\""; }?>>
											<div id="pessoais" class="div_conta_opc_qd">
												<img class="margin-bottom5" height="30" src="/img/perfil/Painel_icon_Pessoais.png"><br>
												<span><? if($LANG=='pt'){echo "Os meus dados pessoais";} if($LANG=='en'){echo "My personal details";} ?></span>
											</div>
										</a>

										<a <? if($user['estado'] == 'ativo'){ echo "href=\"/dados-pessoais\""; }?>>
											<div id="pessoais_invertido" class="div_conta_opc_qd_invert none">
												<img class="margin-bottom5" height="30" src="/img/perfil/Painel_icon_Pessoais_invertido.png"><br>
												<span><? if($LANG=='pt'){echo "Os meus dados pessoais";} if($LANG=='en'){echo "My personal details";} ?></span>
											</div>
										</a>
									</div>
								</div>
								<div class="col-md-4">
									<div class="switch_5">
										<a <? if($user['estado'] == 'ativo'){ echo "href=\"/vales-de-desconto\""; }?>>
											<div id="descontos" class="div_conta_opc_qd margin-bottom20">
												<img class="margin-bottom5" height="30" src="/img/perfil/Painel_icon_Descontos.png"><br>
												<span><? if($LANG=='pt'){echo "Os meus vales de desconto";} if($LANG=='en'){echo "My discount vouchers";} ?></span>
											</div>
										</a>

										<a <? if($user['estado'] == 'ativo'){ echo "href=\"/vales-de-desconto\""; }?>>
											<div id="descontos_invertido" class="div_conta_opc_qd_invert margin-bottom20 none">
												<img class="margin-bottom5" height="30" src="/img/perfil/Painel_icon_Descontos_invertido.png"><br>
												<span><? if($LANG=='pt'){echo "Os meus vales de desconto";} if($LANG=='en'){echo "My discount vouchers";} ?></span>
											</div>
										</a>
									</div>
									
									<div class="switch_6">
										<a href="/_logout">
											<div id="encerrar" class="div_conta_opc_qd">
												<img class="margin-bottom5" height="30" src="/img/perfil/Painel_icon_Encerrar.png"><br>
												<span><? if($LANG=='pt'){echo "Encerrar sessão";} if($LANG=='en'){echo "Log out";} ?></span>
											</div>
										</a>

										<a href="/_logout">
											<div id="encerrar_invertido" class="div_conta_opc_qd_invert none">
												<img class="margin-bottom5" height="30" src="/img/perfil/Painel_icon_Encerrar_invertido.png"><br>
												<span><? if($LANG=='pt'){echo "Encerrar sessão";} if($LANG=='en'){echo "Log out";} ?></span>
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>
				    </div>
				  </div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<script>
	$('.switch_1').hover(function() {
	        $(this).find('#pin').hide();
	        $(this).find('#pin_invertido').show();
	    }, function() {
	        $(this).find('#pin_invertido').hide();
	        $(this).find('#pin').show();
	});

	$('.switch_2').hover(function() {
	        $(this).find('#moradas').hide();
	        $(this).find('#moradas_invertido').show();
	    }, function() {
	        $(this).find('#moradas_invertido').hide();
	        $(this).find('#moradas').show();
	});

	$('.switch_3').hover(function() {
	        $(this).find('#encomendas').hide();
	        $(this).find('#encomendas_invertido').show();
	    }, function() {
	        $(this).find('#encomendas_invertido').hide();
	        $(this).find('#encomendas').show();
	});

	$('.switch_4').hover(function() {
	        $(this).find('#pessoais').hide();
	        $(this).find('#pessoais_invertido').show();
	    }, function() {
	        $(this).find('#pessoais_invertido').hide();
	        $(this).find('#pessoais').show();
	});

	$('.switch_5').hover(function() {
	        $(this).find('#descontos').hide();
	        $(this).find('#descontos_invertido').show();
	    }, function() {
	        $(this).find('#descontos_invertido').hide();
	        $(this).find('#descontos').show();
	});

	$('.switch_6').hover(function() {
	        $(this).find('#encerrar').hide();
	        $(this).find('#encerrar_invertido').show();
	    }, function() {
	        $(this).find('#encerrar_invertido').hide();
	        $(this).find('#encerrar').show();
	});
</script>