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
	<? $sepConta='vale_desconto'; include '_header.php'; ?>

	<?
		$portes = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM portes"));
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
				    	<p class="div_conta_desc"><? if($LANG=='pt'){echo "Os meus vales de desconto";} if($LANG=='en'){echo "My discount vouchers";} ?></p>


						<div class="div_conta_bv"><? if($LANG=='pt'){echo "Aqui encontrará uma lista com as suas notas de crédito e vales de desconto.";} if($LANG=='en'){echo "Here you will find a list of your credit notes and discount vouchers.";} ?> <a href="javascript:history.go(-1)" class="return_page"><i class="fas fa-angle-left"></i> <?if($LANG=='pt') { echo "Voltar";} if($LANG=='en'){echo "Come back";}?></a></div>

						<div class="div_conta_opc">
							<div class="row">
								
								<?
									if ($portes) {
										if($LANG=='pt'){$campanha = "Campanha";$validade="Validade";$codigo="Código";$utilizado="Utilizado";} 
										if($LANG=='en'){$campanha = "Campaign";$validade="Validity";$codigo="Code";$utilizado="Used";}
									echo"<div class=\"col-md-12\">
											<div class=\"textr\" style=\"font-size: 12px;text-align: right;color: #4497A6;\">
												<label><i class=\"fas fa-search\"></i> <span style=\"text-decoration:underline;\">Pesquisa</span></label>
											</div>
										
											<input id=\"myInput\" type=\"text\">
											
											<div style=\"overflow-x:auto;width:100%;\">
											<table id=\"myTable2\">
											    <thead>
													<tr>
														<th>$campanha</th>
														<th>$validade</th>
														<th>$codigo</th>
														<th>$utilizado</th>
													</tr>
											    </thead>
											    <tbody id=\"myTable\">";
											    	
											    			$query = mysqli_query($lnk,"SELECT * FROM portes");
															while($linha = mysqli_fetch_array($query))
															{	
																$id_linha = $linha["id"];
																$inicio = $linha["data_inicio"];
																$fim = $linha["data_fim"];
																$codigo = $linha["codigo"];
																$nome = $linha["nome"];

												    			echo "<tr>
												    				<td><a class=\"cinza hover_cinza\" href=\"campanha/portes/$id_linha\">$nome</a></td>
												    				<td><b>de</b> $inicio <b>até</b> $fim</td>
												    				<td>$codigo</td>
												    				<td></td>
												    			</tr>";
												    		}

												    		
															$id_user = $_COOKIE["USER"];

	                            							$hoje=date('Y-m-d');
	                            							$query = mysqli_query($lnk,"SELECT * FROM user_vales where id_user = '$id_user'");

															while($linha = mysqli_fetch_array($query)){

															
																$id_vale = $linha["id_vale"];
																$data_utilizacao = $linha["data_utilizacao"];

																$query_vale = mysqli_query($lnk,"SELECT * FROM vales_desconto where id = '$id_vale'");
																$cupao = mysqli_fetch_assoc($query_vale);
										
																$id_cupao = $cupao["id"];
																$nome_cupao = $cupao["nome"];
																$data_inicio = $cupao["data_inicio"];
																$data_fim = $cupao["data_fim"];
																$codigo = $cupao["codigo"];
																if ($data_utilizacao != '') {
																	$data_uti = '<b>em</b>'.' '.$data_utilizacao;
																}
									                            echo"<tr>
									                            	<td><a class=\"cinza hover_cinza\" href=\"campanha/vale/$id_cupao\">$nome_cupao</a></td>
																	<td><b>de</b> $data_inicio <b>até</b> $data_fim</td>
																	<td>$codigo</td>
																	<td>$data_uti</td>
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
</script>