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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>

<body>
	<? $sepConta='nova_morada'; include '_header.php'; ?>

	<?
		$url = $_SERVER['REQUEST_URI'];
		$urlPartes = explode("/", $url);

		$id = urldecode($urlPartes[2]);
		$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user_morada WHERE id='$id'"));
	
		if($existe){
			extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user_morada WHERE id='$id'"))); 
			$id_url = urldecode($urlPartes[2]);

			$id_user = $_COOKIE["USER"];
			$user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id_user='$id_user'"));
		}


	?>

	<div>
		<div class="modalFundo-fixed"></div>
		<div class="modalScroll"></div>
		<div class="div_conta">
			
			<div class="div_conta_close" onClick=""></div>
				
			<div style="padding:0px 30px;">
				<div class="container-fluid">

				  	<div class="row">
					    <div class="col-md-3">
					    	<?include '_menu-conta.php';?>
					    </div>
					    <div class="col-md-9">
					    	<p class="div_conta_desc"><? if($LANG=='pt'){echo "+ Adicionar Morada";} if($LANG=='en'){echo "+ Add address";} ?></p>

							<div class="div_conta_bv"><? if($LANG=='pt'){echo "Preencha a sua morada nos campos que se seguem.";} if($LANG=='en'){echo "Fill in your address in the fields below.";} ?> <a href="javascript:history.go(-1)" class="return_page"><i class="fas fa-angle-left"></i> <?if($LANG=='pt') { echo "Voltar";} if($LANG=='en'){echo "Come back";}?></a></div>

							<div class="textl">
								<div class="row">
									<div class="col-md-12">
								
										<div class="margin-bottom10"></div>
										<input id="id_exist" type="hidden" name="id" value="<? if($existe){ echo $id_url; }?>">


										<label class="morada-label-form"><? if($LANG=='pt'){echo "Nome";} if($LANG=='en'){echo "Name";} ?></label>
										<input id="nome" class="ip-conta" type="text" name="nome" placeholder="<? if($LANG=='pt'){echo "Nome*";} if($LANG=='en'){echo "Name*";} ?>" value="<? if($existe){ echo $nome; }else{ echo $user['nome']; }?>">

										<? 
											if ($user['tipo_cliente'] == 'cliente') {
												if($LANG=='pt'){$txt="Apelido";} 
												if($LANG=='en'){$txt="Nickname";}
												if($existe){ $valor = $apelido; }else{ $valor = $user['apelido']; }

												echo "<label class=\"morada-label-form\">$txt</label>
												<input id=\"apelido\" class=\"ip-conta\" type=\"text\" name=\"apelido\" placeholder=\"$txt*\" value=\"$valor\">";
											} 
										?>
										
										<label class="morada-label-form"><? if($LANG=='pt'){echo "Endereço";} if($LANG=='en'){echo "Address";} ?></label>
										<input id="morada" class="ip-conta" type="text" name="morada" placeholder="<? if($LANG=='pt'){echo "Endereço*";} if($LANG=='en'){echo "Address*";} ?>" value="<? if($existe){ echo $endereco; }?>">

										<label class="morada-label-form"><? if($LANG=='pt'){echo "Localidade";} if($LANG=='en'){echo "Locality";} ?></label>
										<input id="localidade" class="ip-conta" type="text" name="localidade" placeholder="<? if($LANG=='pt'){echo "Localidade*";} if($LANG=='en'){echo "Locality*";} ?>" value="<? if($existe){ echo $localidade; }?>">

										<label class="morada-label-form"><? if($LANG=='pt'){echo "Código Postal";} if($LANG=='en'){echo "Postal Code";} ?></label>
										<input id="postal" class="ip-conta" type="text" name="postal" placeholder="<? if($LANG=='pt'){echo "Código Postal*";} if($LANG=='en'){echo "Postal Code*";} ?>" value="<? if($existe){ echo $codigo_postal; }?>">

										<label class="morada-label-form"><? if($LANG=='pt'){echo "País";} if($LANG=='en'){echo "Country";} ?></label>
										<!--<input id="pais" class="ip-conta" type="text" name="pais" placeholder="<? if($LANG=='pt'){echo "País*";} if($LANG=='en'){echo "Country*";} ?>" value="<? if($existe){ echo $pais; }?>">-->

										<select class="selectMorada" id="pais" name="zona">
								          	<option class='selectMorada-opc cinza' value='0' selected disabled><? if($LANG=='pt'){echo "Região";} if($LANG=='en'){echo "Region";} ?></option>
											<option class='selectMorada-opc' value='Portugal' <? if($pais=='Portugal') echo "selected";?>><? if($LANG=='pt'){echo "Portugal Continental";} if($LANG=='en'){echo "Continental Portugal";} ?></option>
											<option class='selectMorada-opc' value='Madeira' <? if($pais=='Madeira') echo "selected";?>><? if($LANG=='pt'){echo "Arquipélago da Madeira";} if($LANG=='en'){echo "Archipelago of Madeira";} ?></option>
											<option class='selectMorada-opc' value='Acores' <? if($pais=='Acores') echo "selected";?>><? if($LANG=='pt'){echo "Arquipélago dos Açores";} if($LANG=='en'){echo "Azores Archipelago";} ?></option>
										</select>


										<label class="morada-label-form"><? if($LANG=='pt'){echo "Telemóvel";} if($LANG=='en'){echo "Mobile Phone";} ?></label>
										<input id="telemovel" class="ip-conta" type="text" name="telemovel" placeholder="PT (+351) 000 000 000*" value="<? if($existe){ echo $telemovel; }else{ echo $user['contacto']; }?>">

										<label class="morada-label-form"><? if($LANG=='pt'){echo "Nome de identificação da morada, ex: envio, facturação, etc.";} if($LANG=='en'){echo "Name identifying the address, eg shipping, billing, etc.";} ?></label>
										<input id="nome_morada" class="ip-conta" type="text" name="nome_morada" placeholder="<? if($LANG=='pt'){echo "A minha morada*";} if($LANG=='en'){echo "My adress*";} ?>" value="<? if($existe){ echo $nome_morada; }?>">

										<div class="morada-bt-form">
											<label onclick="submitMorada();"  class="label_entrar-100"><? if($LANG=='pt'){echo "GUARDAR";} if($LANG=='en'){echo "SAVE";} ?></label>
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

	function submitMorada(){
		var id_exist = $('#id_exist').val();
		var nome = $('#nome').val();
		var apelido = $('#apelido').val();
		var morada = $('#morada').val();
		var localidade = $('#localidade').val();
		var postal = $('#postal').val();
		var pais = $('#pais').val();
		var telemovel = $('#telemovel').val();
		var nome_morada = $('#nome_morada').val();

		$.post("/_morada/js_novo.php",{id_exist:id_exist, nome:nome, apelido:apelido, morada:morada, localidade:localidade, postal:postal, pais:pais, telemovel:telemovel, nome_morada:nome_morada}) 
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
					location.replace("http://www.ci-interiordecor.com/morada/")
				}
				$('#erroCode_header').hide();
			}
		});
	}


</script>