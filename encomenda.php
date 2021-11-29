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
	<? $sepConta='user_encomendas'; include '_header.php'; ?>

	<?
		$url = $_SERVER['REQUEST_URI'];
		$urlPartes = explode("/", $url);

		$id = urldecode($urlPartes[2]);
		
		$existe_enc = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda WHERE id='$id'"));
		if($existe_enc){
			extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM venda WHERE id='$id'"))); 
			$id_url = urldecode($urlPartes[2]);

			$query2 = mysqli_query($lnk,"SELECT * FROM tracking where id_venda='$id'");
			$style = '';
			while($linha2 = mysqli_fetch_array($query2)){
				$id_tracking_est = $linha2['id_tracking_est'];

				$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tracking_est where id='$id_tracking_est'"));

				if($LANG=='pt'){$descricao = $linha3['descricao_pt'];}else{$descricao = $linha3['descricao_en'];}

				if (($id_tracking_est == 1) || ($id_tracking_est == 2) || ($id_tracking_est == 3)) {
					$img = '/img/encomendas/Tracking_1.svg';
					if($LANG=='pt'){$txt_img = 'A sua encomenda está em processamento.';}else{$txt_img = 'Your order is in process.';}
				}else if (($id_tracking_est == 4) || ($id_tracking_est == 5)) {
					$img = '/img/encomendas/Tracking_2.svg';
					if($LANG=='pt'){$txt_img = 'A sua encomenda foi entregue á transportadora.';}else{$txt_img = 'Your order has been delivered to the carrier.';}
				}
				else if (($id_tracking_est == 6)) {
					$img = '/img/encomendas/Tracking_3.svg';
					if($LANG=='pt'){
						$txt_img = 'A sua encomenda já se encontra a com a equipa de distribuição.';
					}else{
						$txt_img = 'Your order is already with the distribution team.';
					}
				}
				elseif (($id_tracking_est == 7)) {
					$img = '/img/encomendas/cancelada.svg';
					$style = 'height:100px;';
					if($LANG=='pt'){$txt_img = 'A sua encomenda foi cancelada.';}else{$txt_img = 'Your order has been canceled.';}
				}
				else if (($id_tracking_est == 8)) {
					$img = '/img/encomendas/Tracking_4.svg';
					if($LANG=='pt'){$txt_img = 'A sua encomenda já foi entregue no destinatário.';}else{$txt_img = 'Your order has already been delivered to the recipient.';}
				}


				if (($id_tracking_est == 6) || ($id_tracking_est == 8)) {
					
					if($LANG=='pt'){
						$bad = "Mau";
						$Good = "Bom";
						$Very = "Muito bom";
						$avaliacao_txt = "Avalie a sua satisfação!";
					}else{
						$bad = "Bad";
						$Good = "Good";
						$Very = "Very good";
						$avaliacao_txt = "Rate your satisfaction!";
					}

					$query_av = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM venda_avaliacao where id_venda='$id'"));

					$avaliacao_bd = $query_av['avaliacao'];

					if ($avaliacao_bd == 'mau') {
						$class_1 = "avaliacao_no";
					}
					if($avaliacao_bd == 'bom'){
						$class2 = "avaliacao_no";
					}
					if($avaliacao_bd == 'muito_bom'){
						$class3 = "avaliacao_no";
					}

					$avaliacao = "<div class=\"margin-top30 textc fonte12 cinza\">
											<div>
												<img style=\"height:60px;\" id=\"mau\" onClick=\"validateTrack('mau');\" class=\"margin-right20 cursor-pointer $class2 $class3\" src=\"/img/encomendas/avaliacao_01.svg\" title=\"$bad\">
												<img style=\"height:60px;\" id=\"bom\" onClick=\"validateTrack('bom');\" class=\"margin-right20 cursor-pointer $class_1 $class3\" src=\"/img/encomendas/avaliacao_02.svg\" title=\"$Good\"}>
												<img style=\"height:60px;\" id=\"muito_bom\" onClick=\"validateTrack('muito_bom');\" class=\"cursor-pointer $class_1 $class2\" src=\"/img/encomendas/avaliacao_03.svg\" title=\"$Very\">
											</div>
											<label class=\"margin-top10\">$avaliacao_txt</label>
										</div>";



				}
			}
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
				    	<input id="id_encomenda" type="hidden" name="id_encomenda" value="<? echo $id_url?>">
				    	<p class="div_conta_desc"><? if($LANG=='pt'){echo "Estado da encomenda";} if($LANG=='en'){echo "Order status";} ?></p>

				    	
						<div class="div_conta_bv"><? if($LANG=='pt'){echo "Aqui pode acompanhar o ponto de situação da sua encomenda.";} if($LANG=='en'){echo "Here you can follow the status of your order.";} ?><a href="javascript:history.go(-1)" class="return_page"><i class="fas fa-angle-left"></i> <?if($LANG=='pt') { echo "Voltar";} if($LANG=='en'){echo "Come back";}?></a></div>

						<div class="div_conta_opc">
							<div class="row">
								<div class="col-md-12">
									<div class="textc">

										<?
											if ($existe_enc) {
												echo "<div class=\"margin-bottom40\"><p class=\"textl\">Encomenda #$id_url</p>";
												echo "<img style=\"$style\" id=\"img_tracking\" class=\"margin-top20 margin-bottom20\" src=\"$img\"><br>";
												echo "<label class=\"fonte14 cinza\">$txt_img</label></div>";
											}

										?>
										<br>
										<span class="switch_1">
											<a href="/visualizar/<?echo $id_url?>">
												<label id="visualizar" class="div_conta_opc_qd div_conta_opc_qd_right" style="width:200px;">
													<img class="margin-bottom5" height="30" src="/img/encomendas/icon-visualizar.svg"><br>
													<span><? if($LANG=='pt'){echo "Visualizar encomenda";} if($LANG=='en'){echo "View order";} ?></span>
												</label>
											</a>

											<a href="/visualizar/<?echo $id_url?>">
												<label id="visualizar_invertido" class="div_conta_opc_qd_invert none div_conta_opc_qd_right" style="width:200px;">
													<img class="margin-bottom5" height="30" src="/img/encomendas/visualizar_hover.svg"><br>
													<span><? if($LANG=='pt'){echo "Visualizar encomenda";} if($LANG=='en'){echo "View order";} ?></span>
												</label>
											</a>
										</span>

										<span class="switch_2">
											<a href="<? echo $fatura;?>">
												<label id="fatura" class="div_conta_opc_qd" style="width:200px;">
													<img class="margin-bottom5" height="30" src="/img/encomendas/icon-factura.svg"><br>
													<span><? if($LANG=='pt'){echo "Ver factura";} if($LANG=='en'){echo "View invoice";} ?></span>
												</label>
											</a>

											<a href="<? echo $fatura;?>">
												<label id="fatura_invertido" class="div_conta_opc_qd_invert none" style="width:200px;">
													<img class="margin-bottom5" height="30" src="/img/encomendas/factura_hover.svg"><br>
													<span><? if($LANG=='pt'){echo "Ver factura";} if($LANG=='en'){echo "View invoice";} ?></span>
												</label>
											</a>
										</span>
										<br>
										<a href="/fale-connosco/<? echo $id_url ?>">
											<label id="pin_invertido" class="div_conta_opc_qd" style="max-width:424px;min-width:200px;width: 100%;">
												<span><? if($LANG=='pt'){echo "Fale connosco!";} if($LANG=='en'){echo "Talk to us!";} ?></span>
											</label>
										</a>

										<?echo $avaliacao?>
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
	        $(this).find('#visualizar').hide();
	        $(this).find('#visualizar_invertido').show();
	    }, function() {
	        $(this).find('#visualizar_invertido').hide();
	        $(this).find('#visualizar').show();
	});

	$('.switch_2').hover(function() {
	        $(this).find('#fatura').hide();
	        $(this).find('#fatura_invertido').show();
	    }, function() {
	        $(this).find('#fatura_invertido').hide();
	        $(this).find('#fatura').show();
	});

	function validateTrack($tipo){
	
		var tipo = $tipo;
		var id_encomenda = $('#id_encomenda').val();

		$.post("/_encomenda/js_avaliacao.php",{ tipo:tipo, id_encomenda:id_encomenda })
		.done(function( data ) {
			var jsonRetorna = $.parseJSON(data);
			var aviso = jsonRetorna['aviso'];
	
			if(aviso) {
				$('#erroCode_header').hide();
				$('#sucesso_header').show();
				$('#sucesso_header').html(aviso);

				$('#img_tracking').attr("src","/img/encomendas/Tracking_4.png");

				if (tipo == 'mau') {
					$('#bom').addClass("avaliacao_no");
					$('#muito_bom').addClass("avaliacao_no");
					$('#mau').removeClass("avaliacao_no");
				}else if(tipo == 'bom'){
					$('#mau').addClass("avaliacao_no");
					$('#muito_bom').addClass("avaliacao_no");
					$('#bom').removeClass("avaliacao_no");
				}else{
					$('#mau').addClass("avaliacao_no");
					$('#bom').addClass("avaliacao_no");
					$('#muito_bom').removeClass("avaliacao_no");
				}

				$('html, body').animate({ scrollTop: 0 }, 50);
			}
		});	
	}
</script>