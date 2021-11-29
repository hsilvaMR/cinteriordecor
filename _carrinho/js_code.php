<?php
include('../_connect.php');



$codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
$portes = isset($_POST['portes']) ? $_POST['portes'] : '';
$total = isset($_POST['total']) ? $_POST['total'] : '';
$use_code = isset($_POST['use_code']) ? $_POST['use_code'] : 0;
$id_user = $_POST['id_user_code'];



$retorna['aviso']=''; $aviso='';


if($LANG=='pt'){
	if(!$codigo){$retorna['aviso'] = "Insira um código!"; $aviso=1;}
}

if($LANG=='en'){
	if(!$codigo){$retorna['aviso'] = "Enter code!"; $aviso=1;}
}

if((!$aviso) && ($use_code == 0)){
	
	$hoje=date('Y-m-d');
	$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM portes WHERE codigo='$codigo' AND data_inicio<='$hoje' AND data_fim>='$hoje'"));
	$linha_cupao = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM vales_desconto WHERE codigo='$codigo' AND data_inicio<='$hoje' AND data_fim>='$hoje'"));
	

	if ($linha_cupao) {
		
		if ($id_user) {
			$linha_cupao = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM vales_desconto WHERE codigo='$codigo' AND data_inicio<='$hoje' AND data_fim>='$hoje'"));
			$id_vale = $linha_cupao['id'];
			$linha_cupao_user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user_vales WHERE id_user='$id_user' AND id_vale='$id_vale' AND utilizado='0'"));
		}	
	}

	if (!$linha && !$linha_cupao_user) {
		if($LANG=='pt'){$retorna['aviso'] = "Código inválido!";}
		if($LANG=='en'){$retorna['aviso'] = "Invalid code!";}
	}
	else{
		
		if($linha["id"]){
			
			if ($linha["id_produto"] == ''){ $existe_prod = 1;}
			if ($linha["id_categoria"] == ''){ $existe_cat = 1;}

			if (($linha["id_produto"] != '') || ($linha["id_categoria"] != '')) {
				
				$carrinho = isset($_COOKIE['CARRINHO']) ? $_COOKIE['CARRINHO'] : '';
				$lista = explode(",", $carrinho);

				$jsonIterator_produto = json_decode($linha["id_produto"], TRUE);
				$array_produto = [];

				foreach ($jsonIterator_produto as $value) {
					$array_produto[]=[
						'id' => $value
					];
				}

				$jsonIterator_categoria = json_decode($linha["id_categoria"], TRUE);
				$array_categoria = [];

				foreach ($jsonIterator_categoria as $value) {
					$array_categoria[]=[
						'id' => $value
					];
				}

				$existe_prod = 0;
				$existe_cat = 0;
				foreach ($lista as $i => $value)
				{

					$idqt = explode("-", $value);
					$idC = $idqt[0];

					$valor_prod = (in_array($idC, array_column($array_produto, 'id'))) ? 1 : 0;  

					if ($valor_prod == 1) {

						$existe_prod = $existe_prod + 1;
					}
					
					$linha_produto = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM produto WHERE id = '$idC'"));
					$id_produto_cat = $linha_produto['id_produto_cat'];

					$valor_cat = (in_array($id_produto_cat, array_column($array_categoria, 'id'))) ? 1 : 0;  				

					if ($valor_cat == 1) {
						$existe_cat = $existe_cat + 1;
					}
				}
			}


			if(($existe_prod > 0) || ($existe_cat > 0)){
		
				if ($linha["tipo"] == 'gratis') {
					if($LANG=='pt'){
						$porte = "grátis";
					}

					if($LANG=='en'){
						$porte = "free";
					}

					$retorna['tracking_code']= $porte;

					$total_code = $total - $portes;
					
					$retorna['total_code'] = number_format($total_code, 2, '.', '');

					$use_code = 1;
					$retorna['use_code'] = $use_code;
				}
				elseif ($linha["tipo"] == 'acima_de') {
					$total_l = $total - $portes;
					$total_linhas = number_format($total_l, 2, '.', '');

					if ($linha["valor_condicao"] <= $total_linhas) {
						if ($linha["valor_desconto"] > 0) {
							$total_desconto = ($total_linhas * $linha["valor_desconto"])/100;
							$valor_pagar = ($total_linhas - $total_desconto)+$portes;
							$retorna['total_code'] = number_format($valor_pagar, 2, '.', '');

						}elseif($linha["gratis"] == 1){
							if($LANG=='pt'){ $porte = "grátis"; }
							if($LANG=='en'){ $porte = "free"; }

							$total_code = $total - $portes;

							$retorna['total_code'] = number_format($total_code, 2, '.', '');
							$retorna['tracking_code']= $porte;
						}

						$use_code = 1;
						$retorna['use_code'] = $use_code;
					}else{
						$use_code = 0;
						$retorna['use_code'] = $use_code;

						if($LANG=='pt'){$retorna['aviso'] = "Código não aplicável!";}
						if($LANG=='en'){$retorna['aviso'] = "Code not applicable!";}
					}

					
				}elseif ($linha["tipo"] == 'desconto_perc') {
					$total_l = $total - $portes;
					$total_linhas = number_format($total_l, 2, '.', '');

					if($linha["valor_condicao"] > 0){
						if ($linha["valor_condicao"] < $total_linhas) {
							$total_desconto = ($total_linhas * $linha["valor_desconto"])/100;
							$valor_pagar = ($total_linhas - $total_desconto)+$portes;

							$retorna['total_code'] = number_format($valor_pagar, 2, '.', '');
							$use_code = 1;
							$retorna['use_code'] = $use_code;
						}else{
							$use_code = 0;
							$retorna['use_code'] = $use_code;

							if($LANG=='pt'){$retorna['aviso'] = "Código não aplicável!";}
							if($LANG=='en'){$retorna['aviso'] = "Code not applicable!";}
						}
					}elseif(($linha["valor_condicao"] == 0) && ($linha["valor_desconto"]>0)){
						$total_desconto = ($total_linhas * $linha["valor_desconto"])/100;
						$valor_pagar = ($total_linhas - $total_desconto)+$portes;

						$retorna['total_code'] = number_format($valor_pagar, 2, '.', '');

						$use_code = 1;
						$retorna['use_code'] = $use_code;
					}
				}
				
			}else{
				if($LANG=='pt'){$retorna['aviso'] = "Código não aplicável!";}
				if($LANG=='en'){$retorna['aviso'] = "Code not applicable!";}

				$use_code = 0;
				$retorna['use_code'] = $use_code;
			}
		}
		elseif($linha_cupao_user["id"]){

			$linha_cupao = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM vales_desconto WHERE id='$id_vale'"));

			if ($linha_cupao["tipo"] == 'gratis') {
				if($LANG=='pt'){
					$porte = "grátis";
				}

				if($LANG=='en'){
					$porte = "free";
				}

				$retorna['tracking_code']= $porte;

				$total_code = $total - $portes;
				
				$retorna['total_code'] = number_format($total_code, 2, '.', '');

				$use_code = 1;
				$retorna['use_code'] = $use_code;
				$retorna['id_code_utilizado'] = $linha_cupao_user["id"];
			}
			elseif ($linha_cupao["tipo"] == 'acima_de') {
				$total_l = $total - $portes;
				$total_linhas = number_format($total_l, 2, '.', '');

				if ($linha_cupao["valor_condicao"] <= $total_linhas) {
					if ($linha_cupao["valor_desconto"] > 0) {
						$total_desconto = ($total_linhas * $linha_cupao["valor_desconto"])/100;
						$valor_pagar = ($total_linhas - $total_desconto)+$portes;
						$retorna['total_code'] = number_format($valor_pagar, 2, '.', '');

					}elseif($linha_cupao["gratis"] == 1){
						if($LANG=='pt'){ $porte = "grátis"; }
						if($LANG=='en'){ $porte = "free"; }

						$total_code = $total - $portes;

						$retorna['total_code'] = number_format($total_code, 2, '.', '');
						$retorna['tracking_code']= $porte;
					}

					$use_code = 1;
					$retorna['use_code'] = $use_code;
					$retorna['id_code_utilizado'] = $linha_cupao_user["id"];
				}
				else{
					$use_code = 0;
					$retorna['use_code'] = $use_code;

					if($LANG=='pt'){$retorna['aviso'] = "Código não aplicável!";}
					if($LANG=='en'){$retorna['aviso'] = "Code not applicable!";}
				}

				

			}
			elseif ($linha_cupao["tipo"] == 'desconto_perc') {
				$total_l = $total - $portes;
				$total_linhas = number_format($total_l, 2, '.', '');

				if($linha_cupao["valor_condicao"] > 0){
					if ($linha_cupao["valor_condicao"] < $total_linhas) {
						$total_desconto = ($total_linhas * $linha_cupao["valor_desconto"])/100;
						$valor_pagar = ($total_linhas - $total_desconto)+$portes;

						$retorna['total_code'] = number_format($valor_pagar, 2, '.', '');
						$use_code = 1;
						$retorna['use_code'] = $use_code;
					}else{
						$use_code = 0;
						$retorna['use_code'] = $use_code;

						if($LANG=='pt'){$retorna['aviso'] = "Código não aplicável!";}
						if($LANG=='en'){$retorna['aviso'] = "Code not applicable!";}
					}
				}elseif(($linha_cupao["valor_condicao"] == 0) && ($linha_cupao["valor_desconto"]>0)){
					$total_desconto = ($total_linhas * $linha_cupao["valor_desconto"])/100;
					$valor_pagar = ($total_linhas - $total_desconto)+$portes;

					$retorna['total_code'] = number_format($valor_pagar, 2, '.', '');

					$use_code = 1;
					$retorna['use_code'] = $use_code;
				}

				$retorna['id_code_utilizado'] = $linha_cupao_user["id"];

			}elseif($linha_cupao["tipo"] == 'cupao'){
				$total_l = $total - $portes;
				$total_linhas = number_format($total_l, 2, '.', '');

				if($linha_cupao["valor_condicao"] > 0){
					if ($linha_cupao["valor_condicao"] < $total_linhas) {
						$total_desconto = $total_linhas - $linha_cupao["valor_desconto"];
						$valor_pagar = $total_desconto + $portes;

						$retorna['total_code'] = number_format($valor_pagar, 2, '.', '');
						$use_code = 1;
						$retorna['use_code'] = $use_code;
					}else{
						$use_code = 0;
						$retorna['use_code'] = $use_code;

						if($LANG=='pt'){$retorna['aviso'] = "Código não aplicável!";}
						if($LANG=='en'){$retorna['aviso'] = "Code not applicable!";}
					}
				}elseif(($linha_cupao["valor_condicao"] == 0) && ($linha_cupao["valor_desconto"]>0)){
					$total_desconto = $total_linhas - $linha_cupao["valor_desconto"];
					$valor_pagar = $total_desconto + $portes;

					$retorna['total_code'] = number_format($valor_pagar, 2, '.', '');

					$use_code = 1;
					$retorna['use_code'] = $use_code;
				}

				$retorna['id_code_utilizado'] = $linha_cupao_user["id"];
			}	
		}
	}
	
}elseif($use_code == 1){

	$retorna['aviso'] = "Só é válida a utilização de um código por compra!"; $aviso=1;
}

//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>