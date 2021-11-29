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
		if ($_COOKIE["USER"]) {
			$id_user = $_COOKIE["USER"];

			$encomenda = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda WHERE id_user='$id_user'"));
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
				    <div class="col-md-4 col-lg-3">
				    	<?include '_menu-conta.php';?>
				    </div>
				    <div class="col-md-8 col-lg-9">
				    	<p class="div_conta_desc"><? if($LANG=='pt'){echo "As minhas encomendas";} if($LANG=='en'){echo "My orders";} ?></p>


						<div class="div_conta_bv"><? if($LANG=='pt'){echo "Aqui encontrará uma lista com as suas encomendas.";} if($LANG=='en'){echo "Here you will find a list of your orders.";} ?><a href="javascript:history.go(-1)" class="return_page"><i class="fas fa-angle-left"></i> <?if($LANG=='pt') { echo "Voltar";} if($LANG=='en'){echo "Come back";}?></a></div>

						<div class="div_conta_opc">
							<div class="row">
								
								<?
									if ($encomenda) {
										if($LANG=='pt'){$enc = "Encomenda nº";$morada="Morada de entrega";$data="Data";$estado="Estado";} 
										if($LANG=='en'){$enc = "Order nº";$morada="Delivery adress";$data="Date";$estado="Status";}
									echo"<div class=\"col-md-12\">
											<div class=\"textr\" style=\"font-size: 12px;text-align: right;color: #4497A6;\">
												<label><i class=\"fas fa-search\"></i> <span style=\"text-decoration:underline;\">Pesquisa</span></label>
											</div>
										
											<input id=\"myInput\" type=\"text\">

											<div style=\"overflow-x:auto;width:100%;\">
											<table id=\"myTable2\">
											    <thead>
													<tr>
													
														<th>$enc</th>
														<th>$morada</th>
														<th>$data</th>
														<th>$estado</th>
													</tr>
											    </thead>
											    <tbody id=\"myTable\">";
											    			$query = mysqli_query($lnk,"SELECT * FROM venda WHERE id_user='$id_user'");
															while($linha = mysqli_fetch_array($query))
															{	
																$id_linha = $linha["id"];
																$query2 = mysqli_query($lnk,"SELECT * FROM tracking where id_venda='$id_linha'");

																while($linha2 = mysqli_fetch_array($query2)){
																	$id_tracking_est = $linha2['id_tracking_est'];

																	$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tracking_est where id='$id_tracking_est'"));

																	if($LANG=='pt'){
																		$descricao = $linha3['descricao_pt'];

																	}else{$descricao = $linha3['descricao_en'];}

																	if(($descricao == 'Compra concluída') || ($descricao == 'Purchase Completed')){
																		$cor ='#9CC83E;';
																	}elseif (($descricao == 'Encomenda cancelada') || ($descricao == 'Order canceled')) {
																		$cor ='#EE4040;';
																	}
																	else{
																		$cor = 'rgba(0, 0, 0, 0.48);';
																	}

									
																}

																if ($descricao == 'Encomenda online registada') {
																	$delete_enc = '<a class="vermelho fonte12 margin-right10" onClick="cancelOrder('.$id_linha.');"> <i class="fas fa-times"></i>  cancelar encomenda</a>';

																}elseif($descricao == 'Registered online order') {
																	$delete_enc = '<a class="vermelho fonte12 margin-right10" onClick="cancelOrder('.$id_linha.');"> <i class="fas fa-times"></i>  cancel order</a>';
																}

																
																$rua = $linha["rua"];
																$data = $linha["data"];

												    			echo "<tr id=\"tabela_linha_$id_linha\">
												    				<td>$delete_enc <a class=\"cinza hover_cinza\" href=\"encomenda/$id_linha\">#$id_linha</a></td>
												    				<td>$rua</td>
												    				<td>$data</td>
												    				<td style=\"color:$cor\">$descricao</td>
												    			</tr>";
												    		}
											    		
											    echo"</tbody>
											</table>
											</div>
										</div>";
									}
									else{
										if($LANG=='pt'){$info = "Não tem vales de desconto de momento.";} 
										if($LANG=='en'){$info = "You do not have discount vouchers at the moment.";}
										echo "<div class=\"col-md-12 none\">
												<div style=\"margin-top:50px;\">
													<img height=\"50\" src=\"/img/perfil/Painel_icon_Descontos.png\"><br>
													<label class=\"margin-top10\" style=\"color: rgba(68, 151, 166, 0.5);\">$info</label>
												</div>
											</div>";

									}
								?>
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
	$(document).ready(function(){
	  $("#myInput").on("keyup", function() {
	    var value = $(this).val().toLowerCase();
	    $("#myTable tr").filter(function() {
	      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	    });
	  });
	});

	function cancelOrder($id_enc){
		var id_enc = $id_enc;

		$.post("/_encomenda/cancelar.php",{ id_enc:id_enc})
		.done(function( data ) {
			var jsonRetorna = $.parseJSON(data);
			var aviso = jsonRetorna['aviso'];
	
			if(aviso) {
				$('#erroCode_header').hide();
				$('#sucesso_header').show();
				$('#sucesso_header').html(aviso);

				$('#tabela_linha_'+id_enc).remove();
				$('html, body').animate({ scrollTop: 0 }, 50);
			}
		});	
	}
</script>