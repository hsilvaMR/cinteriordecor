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
	<? $sepConta='encomenda_estado'; include '_header.php'; ?>

	<?
		$url = $_SERVER['REQUEST_URI'];
		$urlPartes = explode("/", $url);
	
		$id = urldecode($urlPartes[3]);
		
		$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda WHERE id_user='$id'"));
	
		if($existe){
			extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM venda WHERE id='$id'")));
			$id_url = urldecode($urlPartes[3]);
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
				    	<p class="div_conta_desc"><? if($LANG=='pt'){echo "Estado da encomenda";} if($LANG=='en'){echo "Order status";} ?></p>

						<div class="div_conta_bv"><? if($LANG=='pt'){echo "Aqui pode acompanhar o ponto de situação da sua encomenda.";} if($LANG=='en'){echo "Here you can follow the status of your order.";} ?><a href="javascript:history.go(-1)" class="return_page"><i class="fas fa-angle-left"></i> <?if($LANG=='pt') { echo "Voltar";} if($LANG=='en'){echo "Come back";}?></a></div>

						<div class="div_conta_opc">
							<div class="row">
								<div class="col-md-12">
									<div class="textl">

										<?
											if ($existe) {

												echo"<p style=\"font-family:'Open Sans',sans-serif;font-weight:normal;font-size: 12px;line-height: 16px;color: #222222;\">Encomenda $nome</p>";
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
		</div>
	</div>
</body>
</html>
