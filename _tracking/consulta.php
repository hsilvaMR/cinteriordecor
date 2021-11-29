<?php
include('../_connect.php');
if (isset($_POST['tracking'])) {
	$tracking = trim($_POST['tracking']);

	$linha = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM venda WHERE tracking='$tracking'"));	
	$id_venda = $linha['id'];

	if($id_venda){
		$query2 = mysqli_query($lnk, "SELECT * FROM tracking WHERE id_venda='$id_venda'");	
		while($linha2 = mysqli_fetch_array($query2)){
			$id_tracking_est = $linha2['id_tracking_est'];
			$data = $linha2['data'];
			$linha3 = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM tracking_est WHERE id='$id_tracking_est'"));	
			$descricao = $linha3['descricao_'.$LANG];
			?>
			<div class="tracking-estado"><?echo $data.' | '.$descricao?></div>
			<?
		}
	}else{
		?>
		<div class="tracking-vazio"><? if($LANG=='pt'){echo "Sem encomenda associada a essa referência!";} if($LANG=='en'){echo "No order associated with this reference!";} ?></div>
		<?
	}
}
?>