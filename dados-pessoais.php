<?php include('_seguranca_conta.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Ci | Interior Decor</title>
<? include '_head.php';?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
	<? $sepConta='dados_pessoais'; include '_header.php'; ?>

	<?
		if ($_COOKIE["USER"]) {
			$id_user = $_COOKIE["USER"];

			$user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id_user='$id_user'"));
		}
	?>


	<div>
		<div class="modalFundo-fixed"></div>
		<div class="modalScroll"></div>
		<div class="div_conta">
			
			<div class="div_conta_close" onClick=""></div>
				
			<div style="padding:0px 30px 0px 30px;">
				<div class="container-fluid">

				  	<div class="row">
					    <div class="col-md-3">
					    	<?include '_menu-conta.php';?>
					    </div>
					    <div class="col-md-9">
					    	<p class="div_conta_desc"><? if($LANG=='pt'){echo "Os meus dados Pessoais";} if($LANG=='en'){echo "My Personal Data";} ?></p>

					  
					    	<div class="div_conta_bv"><? if($LANG=='pt'){echo "Preencha com os seus dados os campos que se seguem.";} if($LANG=='en'){echo "Fill in the fields below with your details.";} ?> <a href="javascript:history.go(-1)" class="return_page"><i class="fas fa-angle-left"></i> <?if($LANG=='pt') { echo "Voltar";} if($LANG=='en'){echo "Come back";}?></a></div>
						
					    	<div class="textl">
								<div class="row">
									<div class="col-md-12">
										<input id="tipo_cliente" type="hidden" name="tipo_cliente" value="<? echo $user['tipo_cliente'];?>">
										<span class="verde_agua floatr fonte12">* Campo Obrigatório</span>

										<label class="morada-label-form">
											<? 
												if(($user['tipo_cliente'] == 'cliente') && ($LANG=='pt')){echo "Nome";} 
												if(($user['tipo_cliente'] == 'cliente') && ($LANG=='en')){echo "Name";} 
												if(($user['tipo_cliente'] == 'empresa') && ($LANG=='pt')){echo "Nome da empresa";} 
												if(($user['tipo_cliente'] == 'cliente') && ($LANG=='en')){echo "Company Name";} 
											?>
										</label>

										<input id="nome" class="ip-conta" type="text" name="nome" placeholder="<? if($LANG=='pt'){echo "Nome*";} if($LANG=='en'){echo "Name*";} ?>" value="<? echo $user['nome'];?>">

										<? 
											if ($user['tipo_cliente'] == 'cliente') {
												if($LANG=='pt'){$txt="Apelido";} 
												if($LANG=='en'){$txt="Nickname";}
												if($existe){ $valor = $apelido; }else{ $valor = $user['apelido']; }

												echo "<label class=\"morada-label-form\">$txt</label>
												<input id=\"apelido\" class=\"ip-conta\" type=\"text\" name=\"apelido\" placeholder=\"$txt*\" value=\"$valor\">";
											} 
										?>

										<label class="morada-label-form"><? if($LANG=='pt'){echo "Email";} if($LANG=='en'){echo "Email";} ?></label>
										<input id="email" class="ip-conta" type="text" name="email" placeholder="<? if($LANG=='pt'){echo "Email*";} if($LANG=='en'){echo "Email*";} ?>" value="<? echo $user['email'];?>">

										<label class="morada-label-form"><? if($LANG=='pt'){echo "Contacto";} if($LANG=='en'){echo "Contact";} ?></label>
										<input id="contacto" class="ip-conta" type="text" name="contacto" placeholder="<? if($LANG=='pt'){echo "Contacto*";} if($LANG=='en'){echo "Contact*";} ?>" value="<? echo $user['contacto'];?>">

										<label class="morada-label-form"><? if($user['tipo_cliente']=='cliente' && $LANG=='pt'){echo "Nº de Identificação Fiscal";} if($user['tipo_cliente']=='cliente' && $LANG=='en'){echo "Tax Identification Number";} if($user['tipo_cliente']=='empresa' && $LANG=='pt'){echo "Nº de Identificação de Pessoa Coletiva";} if($user['tipo_cliente']=='empresa' && $LANG=='en'){echo "Legal Person Identification Number";} ?></label>
										<input id="nif" class="ip-conta" type="text" name="nif" placeholder="<? if($user['tipo_cliente']=='cliente' && $LANG=='pt'){echo "Número de Identificação Fiscal*";} if($user['tipo_cliente']=='cliente' && $LANG=='en'){echo "Tax Identification Number*";} if($user['tipo_cliente']=='empresa' && $LANG=='pt'){echo "Número de Identificação de Pessoa Coletiva*";} if($user['tipo_cliente']=='empresa' && $LANG=='en'){echo "Legal Person Identification Number*";} ?>" value="<? echo $user['nif'];?>">

										<label class="morada-label-form"><? if($LANG=='pt'){echo "Password actual";} if($LANG=='en'){echo "Current password";} ?></label>
										<input id="password" class="ip-conta" type="password" name="password" placeholder="<? if($LANG=='pt'){echo "*********";} if($LANG=='en'){echo "*********";} ?>" value="<? echo $user['password'];?>" maxlength="8">

										<label class="morada-label-form"><? if($LANG=='pt'){echo "Nova password";} if($LANG=='en'){echo "New password";} ?></label>
										<input id="password_new" class="ip-conta" type="text" name="password_new" placeholder="<? if($LANG=='pt'){echo "Nova password*";} if($LANG=='en'){echo "New password*";} ?>" value="">

										<label class="morada-label-form"><? if($LANG=='pt'){echo "Confirmação";} if($LANG=='en'){echo "Confirmation";} ?></label>
										<input id="confirmacao" class="ip-conta" type="text" name="confirmacao" placeholder="<? if($LANG=='pt'){echo "Confirmação*";} if($LANG=='en'){echo "Confirmation*";} ?>" value="">

										<input id="id_user" type="hidden" name="id_user" value="<? echo $user['id'];?>">
										<div class="morada-bt-form">
											<label onclick="submitDados();"  class="label_entrar-100"><? if($LANG=='pt'){echo "GUARDAR";} if($LANG=='en'){echo "SAVE";} ?></label>
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
	function submitDados(){
		var id_user = $('#id_user').val();
		var nome = $('#nome').val();
		var apelido = $('#apelido').val();
		var email = $('#email').val();
		var contacto = $('#contacto').val();
		var nif = $('#nif').val();
		var password = $('#password').val();
		var password_new = $('#password_new').val();
		var confirmacao = $('#confirmacao').val();
		var tipo_cliente = $('#tipo_cliente').val();


		$.post("/_dados_pessoais/js_update.php",{id_user:id_user, nome:nome, apelido:apelido, email:email, contacto:contacto, nif:nif, password:password, password_new:password_new, confirmacao:confirmacao,tipo_cliente:tipo_cliente}) 
		.done(function( data ){
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
	}
</script>



