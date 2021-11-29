
<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Ci | Interior Decor</title>
<? include '_head.php';?>
<!-- PayPal -->
<script src="paypal/simpleCart.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
<script type="text/javascript">
function apagarProdutoCat(id)
{
	$('#linhaP'+id).css("display","none");
	$.post("_carrinho/js_apagarProduto.php",{ id : id }) 
	.done(function( data ){
		var jsonRetorna = $.parseJSON(data);
		var cookie = jsonRetorna['cookie'];
		createCookie('CARRINHO',cookie,168);
		var qtCarrinho = jsonRetorna['qtCarrinho'];
		$('#TPH').html(qtCarrinho);
		var precoTotal = jsonRetorna['precoTotal'];
		$('#Total').html(precoTotal);
		if(qtCarrinho==0){
			$('#CART1').css("display","none");
			$('#CART2').css("display","none");
			$('#VAZIO').css("display","block");
		}
		location.href = "/carrinho";
	});
	//Resumo
	$('#RlinhaP'+id).css("display","none");
}
</script>
<? include '_header.php'; include '_login.php';
	include '_register.php';
	include '_new-password.php';
	include '_modal-boas-vindas.php';?>
<div class="barraH"></div>
<article>
	<div id="lojaHeader" class="lojaonline">
		<? if($LANG=='pt'){ ?>
		<span class="E1">CARRINHO &nbsp;&nbsp;></span>&nbsp;&nbsp; <span class="E2">DADOS DE FATURAÇÃO &nbsp;&nbsp;></span>&nbsp;&nbsp; <span class="E3">RESUMO &nbsp;&nbsp;></span>&nbsp;&nbsp; <span class="E4">PAGAMENTO &nbsp;&nbsp;></span>&nbsp;&nbsp; <span class="E5">CONFIRMAÇÃO</span>
		<?} if($LANG=='en'){ ?>
		<span class="E1">CART &nbsp;&nbsp;></span>&nbsp;&nbsp; <span class="E2">DATA BILLING &nbsp;&nbsp;></span>&nbsp;&nbsp; <span class="E3">SUMMARY &nbsp;&nbsp;></span>&nbsp;&nbsp; <span class="E4">PAYMENT &nbsp;&nbsp;></span>&nbsp;&nbsp; <span class="E5">CONFIRMATION</span>
		<? } ?>
	</div>
	<div class="lojaonline">
		<? if($LANG=='pt'){ ?>
		<span class="E1">CARRINHO &nbsp;&nbsp;></span>&nbsp;&nbsp; <span class="E2">DADOS DE FATURAÇÃO &nbsp;&nbsp;></span>&nbsp;&nbsp; <span class="E3">RESUMO &nbsp;&nbsp;></span>&nbsp;&nbsp; <span class="E4">PAGAMENTO &nbsp;&nbsp;></span>&nbsp;&nbsp; <span class="E5">CONFIRMAÇÃO</span>
		<?} if($LANG=='en'){ ?>
		<span class="E1">CART &nbsp;&nbsp;></span>&nbsp;&nbsp; <span class="E2">DATA BILLING &nbsp;&nbsp;></span>&nbsp;&nbsp; <span class="E3">SUMMARY &nbsp;&nbsp;></span>&nbsp;&nbsp; <span class="E4">PAYMENT &nbsp;&nbsp;></span>&nbsp;&nbsp; <span class="E5">CONFIRMATION</span>
		<? } ?>
	</div>
	<div class="clear height30"></div>
	<section style="min-height:600px;">
		<div class="barraAzul"><? if($LANG=='pt'){echo "O MEU CARRINHO";} if($LANG=='en'){echo "MY CART";} ?></div>
		<?
		if($carrinho){
			$precoTotal = 0;
			$lista = explode(",", $carrinho);
			foreach ($lista as $i => $value){
				$idqt = explode("-", $value);
				$idC = $idqt[0];
				$qtC = $idqt[1];
				$linhaC = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM produto WHERE id = '$idC' AND online = 1"));
				$produtoC = $linhaC['produto_'.$LANG];
				$referenciaC = $linhaC['referencia'];
				$id_produto_cat = $linhaC['id_produto_cat'];

				$existe_categoria = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM produto_cat WHERE id = '$id_produto_cat' AND online = 1"));
				if(!$existe_categoria){ echo "<script> apagarProdutoCat($idC); </script>"; }

				$precoC = number_format($linhaC["preco"], 2, '.', '');
				$descontoC = number_format($linhaC["desconto"], 2, '.', '');
				$saldo = $linhaC["saldo"];

				//PROMOÇÃO
				$hoje=date('Y-m-d');
				$linhaPromo = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM promocao WHERE (categoria='$id_produto_cat' OR categoria=0) AND inicio<='$hoje' AND fim>='$hoje' ORDER BY valor DESC"));
				$valorPromo = $linhaPromo["valor"];
				$quaisProdutos = $linhaPromo["produtos"];

				if($valorPromo){
					$descontoC = (100-$valorPromo)*$precoC/100;
					$descontoC = number_format($descontoC, 2, '.', '');
					$precoC = $descontoC;
					$percentagem=$valorPromo;
				}
				else{
					if($saldo && $descontoC!='0.00' && $descontoC<$precoC){
						$percentagem=round(100-($descontoC*100/$precoC));
						$precoC = $descontoC;
					}else{ $saldo = 0; }
				}


				/*if($saldo && $descontoC!='0.00' && $descontoC<$precoC){
					$percentagem=round(100-($descontoC*100/$precoC));
					$precoC = $descontoC;
				}else{ $saldo = 0; }*/

				$precoTP = $precoC * $qtC;
				$precoTotal = $precoTotal + ($precoC * $qtC);
				$quantidadeC = $linhaC['quantidade'];
				$produzir = $linhaC['produzir'];
				if($produzir && $quaisProdutos!='stock'){$quantidadeC = 30;}
				$url_produtoC = str_replace(" ", "-", $produtoC);
				$linhaI = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM produto_gal WHERE id_produto = '$idC' AND online = 1"));
				$imgI = $linhaI['img'];
				?>
				<div id="linhaP<? echo $idC;?>" class="cart">
					<div id="cob<? echo $idC;?>" class="cobertura"></div>
					<div class="cartImg" style="background:url('<? echo $imgI;?>')no-repeat 50% 50%;background-size:contain !important;">
						<? if($saldo){ echo '<div class="descontoPerP">-'.$percentagem.'%</div>'; } ?>
					</div>
					<div class="floatl">
						<a href="/produto/<? echo "$idC/$url_produtoC";?>"><div class="cartNome"><? echo $produtoC;?></div></a>
						<div class="cartRef">#<? echo $referenciaC;?></div>
						<div class="cartCaixote" onClick="apagarProduto(<? echo $idC;?>)"></div>
					</div>
					<div class="floatr textr">
						<select id="qtP<? echo $idC;?>" class="seL cartQt" name="quantidade" onChange="mudarQuantidade(<? echo $idC;?>);">
							<?php $qt = 1;
							while ($qt <= $quantidadeC)
							{
								if($qt == $qtC){echo"<option class='selS' value='$qt' selected>$qt</option>";}
								else{echo"<option class='selS' value='$qt'>$qt</option>";}
								$qt++;
							}
							?>
						</select>
						<div id="precoP<? echo $idC;?>" class="cartPreco"><? echo number_format($precoTP, 2, '.', '');?> €</div>
					</div>
					<div class="clear"></div>
	    		</div>
				<?
			}
			$precoTotal = number_format($precoTotal, 2, '.', '');?>
			<div id="CART1" class="cartConti">
				<? if($LANG=='pt'){echo "Métodos de pagamentos";} if($LANG=='en'){echo "Payment methods";} ?><br>
				<div class="hipay"></div>
				<div class="paypal none"></div>
				<div id="VOLTAR"><a href="/loja"><button id="BT_VOLTAR" type="button" class="btC conti"><? if($LANG=='pt'){echo "VOLTAR À LOJA";} if($LANG=='en'){echo "BACK TO SHOP";} ?></button></a></div>
			</div>
			<div id="CART2" class="cartFinal">
				<? if($LANG=='pt'){echo "Total";} if($LANG=='en'){echo "Total";} ?>
				<div class="total"><span id="Total"><? echo $precoTotal;?></span> €</div>
				<div class="clear"><? if($LANG=='pt'){echo "+ transporte";} if($LANG=='en'){echo "+ shipping";} ?></div>
				<div id="FINALIZAR"><button id="BT_FINALIZAR" type="button" class="btA finali" onClick="carrinho();"><? if($LANG=='pt'){echo "CONTINUAR";} if($LANG=='en'){echo "CHECKOUT";} ?></button></div>
			</div>
			<input type="hidden" id="COOKIE" name="cookie" value="<? echo $carrinho; ?>">
			<?
		} ?>
		<div id="VAZIO" class="<? if($carrinho){ echo "none";}?>"><b><? if($LANG=='pt'){echo "O SEU CARRINHO ESTÁ VAZIO";} if($LANG=='en'){echo "YOUR CART IS EMPTY";} ?></b></div>
		
		<div class="clear"></div>

		<!-- MORADA -->
      	<div id="DADOS" class="none">
		    <div class="barraAzul"><? if($LANG=='pt'){echo "OS MEUS DADOS DE FATURAÇÃO";} if($LANG=='en'){echo "MY BILLING DATA";} ?></div>
		    <?
		    	$select_morada_html = '';
		    	if(isset($_COOKIE["USER"]))
				{	


					$id_user = $_COOKIE["USER"];
					$query_user = mysqli_query($lnk,"SELECT * FROM user WHERE id='$id_user'");
					$query_morada = mysqli_query($lnk,"SELECT * FROM user_morada WHERE id_user='$id_user'");

					$opc = '';
					while($linha = mysqli_fetch_array($query_morada)){
						
						$id_linha = $linha["id"];
						$morada_html = $linha["endereco"];
						$nome_morada_html = $linha["nome_morada"];
						$nome_html = $linha["nome"];
						$apelido_html = $linha["apelido"];
						$codigo_html = $linha["codigo_postal"];
						$localidade_html = $linha["localidade"];
						$telemovel_html = $linha["telemovel"];



						$text_select = $nome_morada_html;
						if ($nome_morada_html == '') {
							$text_select = $morada_html;
						}

						$opc .= '<option class="selS-morada" value="'.$id_linha.'">'.$text_select.'</option>';
						$select_morada_faturacao_html ="<div>
								<p class=\"margin-bottom10 margin-top20 fonte14\">Se pretender poderá selecionar uma morada predefinida da sua área reservada. </p>
								<input id=\"$id_linha-nome\" type=\"hidden\" value=\"$nome_html $apelido_html\">
								<input id=\"$id_linha-morada\" type=\"hidden\" value=\"$morada_html\">
								<input id=\"$id_linha-codigo\" type=\"hidden\" value=\"$codigo_html\">
								<input id=\"$id_linha-localidade\" type=\"hidden\" value=\"$localidade_html\">
								<input id=\"$id_linha-telemovel\" type=\"hidden\" value=\"$telemovel_html\">
								<input id=\"$id_linha-email\" type=\"hidden\" value=\"$email\">
								<input id=\"$id_linha-nif\" type=\"hidden\" value=\"$nif\">

								<select class=\"seL-morada\" name=\"morada\" id=\"morada_faturacao\" onchange=\"functionMoradaFact($id_linha)\">
									<option class=\"selS-morada\" disabled selected>Selecione uma morada</option>
									$opc
								</select>
							</div>";

					
						$select_morada_envio_html ="<div>
								<p class=\"margin-bottom10 margin-top20 fonte14\">Se pretender poderá selecionar uma morada predefinida da sua área reservada. </p>
								<input id=\"$id_linha-nome\" type=\"hidden\" value=\"$nome_html $apelido_html\">
								<input id=\"$id_linha-morada\" type=\"hidden\" value=\"$morada_html\">
								<input id=\"$id_linha-codigo\" type=\"hidden\" value=\"$codigo_html\">
								<input id=\"$id_linha-localidade\" type=\"hidden\" value=\"$localidade_html\">
								<input id=\"$id_linha-telemovel\" type=\"hidden\" value=\"$telemovel_html\">
								<input id=\"$id_linha-email\" type=\"hidden\" value=\"$email\">
								<input id=\"$id_linha-nif\" type=\"hidden\" value=\"$nif\">

								<select class=\"seL-morada\" name=\"morada\" id=\"morada_entrega\" onchange=\"functionMoradaEnvio($id_linha)\">
									<option class=\"selS-morada\" disabled selected>Selecione uma morada</option>
									$opc
								</select>
							</div>";


					}
					
					if($select_morada_envio_html == ''){
					    echo "<input id=\"morada_entrega\" type=\"hidden\">";
					}
					
					if($select_morada_faturacao_html == ''){
					    echo "<input id=\"morada_faturacao\" type=\"hidden\">";
					}


					echo "<input id=\"id_user\" type=\"hidden\" value=\"$id_user\">";
				}else{
					echo"<input id=\"morada_faturacao\" type=\"hidden\">
					<input id=\"morada_entrega\" type=\"hidden\">";
				}
		    ?>
		    <? $dados = $_COOKIE['DADOS'];
		    if($dados){
		    	$array=array();
				$i = 0;
				$lista = explode("||", $dados);
				foreach ($lista as $i => $value){ $array[$i]=$value; $i++; }
			} ?>
			
	    	<div id="ADDRESS" class="maxSize">
	    		<? echo $select_morada_faturacao_html; ?>
	          <input type="text" class="inP" id="Fnome" value="<? echo $array[0]; ?>" placeholder="<? if($LANG=='pt'){echo "Nome Completo";} if($LANG=='en'){echo "Full Name";} ?>" onchange="guardarDados();">        
	          <input type="text" class="inP" id="Frua" value="<? echo $array[1]; ?>" placeholder="<? if($LANG=='pt'){echo "Morada";} if($LANG=='en'){echo "Address";} ?>" onchange="guardarDados();">
	          <input type="text" class="inP mcpostal" id="Fcodpostal" value="<? echo $array[2]; ?>" placeholder="<? if($LANG=='pt'){echo "Código Postal";} if($LANG=='en'){echo "Zip Code";} ?>" maxlength="8" onchange="guardarDados();">
	          <input type="text" class="inP" id="Flocalidade" value="<? echo $array[3]; ?>" placeholder="<? if($LANG=='pt'){echo "Cidade";} if($LANG=='en'){echo "City";} ?>" onchange="guardarDados();">
	          <select class="selectZona" id="Fzona" name="zona" onChange="mudarCor('Fzona');guardarDados();">
	          	<option class='selS' value='0' selected disabled><? if($LANG=='pt'){echo "Região";} if($LANG=='en'){echo "Region";} ?></option>
				<option class='selS seLZona' value='Portugal' <? if($array[4]=='Portugal') echo "selected";?>><? if($LANG=='pt'){echo "Portugal Continental";} if($LANG=='en'){echo "Continental Portugal";} ?></option>
				<option class='selS seLZona' value='Madeira' <? if($array[4]=='Madeira') echo "selected";?>><? if($LANG=='pt'){echo "Arquipélago da Madeira";} if($LANG=='en'){echo "Archipelago of Madeira";} ?></option>
				<option class='selS seLZona' value='Acores' <? if($array[4]=='Acores') echo "selected";?>><? if($LANG=='pt'){echo "Arquipélago dos Açores";} if($LANG=='en'){echo "Azores Archipelago";} ?></option>
			  </select>
	          <input type="text" class="inP mnif" id="Fnif" value="<? echo $array[5]; ?>" placeholder="<? if($LANG=='pt'){echo "NIF";} if($LANG=='en'){echo "VAT";} ?>" onchange="guardarDados();">
	          <input type="text" class="inP mtlm" id="Fcontacto" value="<? echo $array[6]; ?>" placeholder="<? if($LANG=='pt'){echo "Contacto";} if($LANG=='en'){echo "Contact";} ?>" onchange="guardarDados();">
	          <input type="email" class="inP" id="Femail" value="<? echo $array[7]; ?>" placeholder="<? if($LANG=='pt'){echo "Email";} if($LANG=='en'){echo "Email";} ?>" onchange="guardarDados();">
	          <div class="clear"></div>
	          <input type="checkbox" id="Mmorada" class="RD" value="1" onClick="$('#moradaE').slideToggle(200);" checked>
	          <label for="Mmorada" style="margin-right:5px">&nbsp;</label><? if($LANG=='pt'){echo "Mesma morada para envio";} if($LANG=='en'){echo "Same shipping address";} ?>
	          <!-- MORADA DE ENVIO -->
	          <div id="moradaE">
		    	<div class="barraAzul"><? if($LANG=='pt'){echo "OS MEUS DADOS DE ENVIO";} if($LANG=='en'){echo "MY DETAILS OF SHIPPING";} ?></div>
		    	<? echo $select_morada_envio_html; ?>
	            <input type="text" class="inP" id="Enome" value="<? echo $array[8]; ?>" placeholder="<? if($LANG=='pt'){echo "Nome Completo";} if($LANG=='en'){echo "Full Name";} ?>" onchange="guardarDados();">
	            <input type="text" class="inP" id="Erua" value="<? echo $array[9]; ?>" placeholder="<? if($LANG=='pt'){echo "Morada";} if($LANG=='en'){echo "Address";} ?>" onchange="guardarDados();">
	            <input type="text" class="inP mcpostal" id="Ecodpostal" value="<? echo $array[10]; ?>" placeholder="<? if($LANG=='pt'){echo "Código Postal";} if($LANG=='en'){echo "Zip Code";} ?>" maxlength="8" onchange="guardarDados();">
	            <input type="text" class="inP" id="Elocalidade" value="<? echo $array[11]; ?>" placeholder="<? if($LANG=='pt'){echo "Cidade";} if($LANG=='en'){echo "City";} ?>" onchange="guardarDados();">
	            <select class="selectZona" id="Ezona" name="zona" onChange="mudarCor('Ezona');guardarDados();">
	          	<option class='selS' value='0' selected disabled><? if($LANG=='pt'){echo "Região";} if($LANG=='en'){echo "Region";} ?></option>
				<option class='selS seLZona' value='Portugal' <? if($array[11]=='Portugal') echo "selected";?>><? if($LANG=='pt'){echo "Portugal Continental";} if($LANG=='en'){echo "Continental Portugal";} ?></option>
				<option class='selS seLZona' value='Madeira' <? if($array[11]=='Madeira') echo "selected";?>><? if($LANG=='pt'){echo "Arquipélago da Madeira";} if($LANG=='en'){echo "Archipelago of Madeira";} ?></option>
				<option class='selS seLZona' value='Acores' <? if($array[11]=='Acores') echo "selected";?>><? if($LANG=='pt'){echo "Arquipélago dos Açores";} if($LANG=='en'){echo "Azores Archipelago";} ?></option>
				<input type="text" class="inP mtlm" id="Econtacto" value="<? echo $array[13]; ?>" placeholder="<? if($LANG=='pt'){echo "Contacto";} if($LANG=='en'){echo "Contact";} ?>" maxlength="9" onchange="guardarDados();">
			  </select>
	            <div class="clear"></div>
	          </div>

	          	<!-- METODO DE ENVIO-->
		      	<div id="METODO_ENVIO" style="margin-top:40px;">
				    <div class="barraAzul"><? if($LANG=='pt'){echo "ESCOLHA O SEU MÉTODO DE ENVIO";} if($LANG=='en'){echo "CHOOSE YOUR SHIPPING METHOD";} ?></div>
			    	<div class="maxSize" style="padding: 10px 0 30px 0;font-size:12px;">
			    		<div>
			    			<input type="radio" id="check_loja" name="metodo_envio" class="RD-50-conta" value="" >
							<label for="check_loja"></label>
							<span class=""><? if($LANG=='pt'){echo "Levantamento na loja (GRATUITO)";} if($LANG=='en'){echo "In-store pickup (FREE)";} ?></span>
			    		</div>

			    		<div>
			    			<input type="radio" id="check_envio" name="metodo_envio" class="RD-50-conta" value="">
			    			<label for="check_envio"></label>
							<span><? if($LANG=='pt'){echo "Envio ao domicílio";} if($LANG=='en'){echo "Home delivery";} ?></span>
			    		</div>
			    	</div>
			    </div>

	          <div id="BT_S1"><input id="btS1" type="button" class="btA" value="<? if($LANG=='pt'){echo "SEGUINTE";} if($LANG=='en'){echo "NEXT";} ?>" onClick="dados();"/></div>
	          <div id="erroF" class="erro"></div>
	    	</div>
  	  	</div>
      	<!-- FIM MORADA -->
      	

      	<!-- RESUMO -->
      	<div id="RESUMO" class="none">
		    <div class="barraAzul"><? if($LANG=='pt'){echo "RESUMO FINAL";} if($LANG=='en'){echo "FINAL SUMMARY";} ?></div>
	    	<div id="SHIPPING" class="maxSize">
				<?
				if($carrinho){
					$precoTotal = 0;
					$lista = explode(",", $carrinho);
					foreach ($lista as $i => $value){
						$idqt = explode("-", $value);
						$idC = $idqt[0];
						$qtC = $idqt[1];
						$linhaC = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM produto WHERE id = '$idC' AND online = 1"));
						$produtoC = $linhaC['produto_'.$LANG];
						$referenciaC = $linhaC['referencia'];
						$id_produto_cat = $linhaC['id_produto_cat'];

						$precoC = number_format($linhaC["preco"], 2, '.', '');
						$descontoC = number_format($linhaC["desconto"], 2, '.', '');
						$saldo = $linhaC["saldo"];

						//PROMOÇÃO
						$hoje=date('Y-m-d');
						$linhaPromo = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM promocao WHERE (categoria='$id_produto_cat' OR categoria=0) AND inicio<='$hoje' AND fim>='$hoje' ORDER BY valor DESC"));
						$valorPromo = $linhaPromo["valor"];

						if($valorPromo){
							$descontoC = (100-$valorPromo)*$precoC/100;
							$descontoC = number_format($descontoC, 2, '.', '');
							$precoC = $descontoC;
							$percentagem=$valorPromo;
						}
						else{
							if($saldo && $descontoC!='0.00' && $descontoC<$precoC){
								$percentagem=round(100-($descontoC*100/$precoC));
								$precoC = $descontoC;
							}else{ $saldo = 0; }
						}

						/*if($saldo && $descontoC!='0.00' && $descontoC<$precoC){
							$percentagem=round(100-($descontoC*100/$precoC));
							$precoC = $descontoC;
						}else{ $saldo = 0; }*/

						$precoTP = $precoC * $qtC;
						$precoTotal = $precoTotal + ($precoC * $qtC);
						$quantidadeC = $linhaC['quantidade'];
						$url_produtoC = str_replace(" ", "-", $produtoC);
						$linhaI = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM produto_gal WHERE id_produto = '$idC' AND online = 1"));
						$imgI = $linhaI['img'];
						?>
						<div id="RlinhaP<? echo $idC;?>" class="cartResumo">
							<div class="imgResumo" style="background:url('<? echo $imgI;?>')no-repeat 50% 50%;background-size:contain !important;"></div>
							<div class="floatl">
								<div class="nomeResumo"><? echo $produtoC;?></div>
								<div id="RqtP<? echo $idC;?>" class="quantResumo">Qt. <? echo $qtC;?></div>
							</div>
							<div class="floatr textr">
								<div id="RprecoP<? echo $idC;?>" class="precoResumo"><? echo number_format($precoTP, 2, '.', '');?> €</div>
							</div>
							<div class="clear"></div>
			    		</div>
						<?
					} ?>
					<div id="cartResumoCode" class="cartResumo" style="padding:20px 0px;">
						<p class="lb">Usar Código Promocional</p>
						<input type="text" class="ip" id="name_code" placeholder="<? if($LANG=='pt'){echo "# número do voucher";} if($LANG=='en'){echo "# voucher number";} ?>">  
						<input type="button" class="btB" value="<? if($LANG=='pt'){echo "APLICAR";} if($LANG=='en'){echo "TO APPLY";} ?>" onClick="code();"/>
						<input id="use_code" type="hidden" name="use_code" value="0">
						<input id="id_user_code" type="hidden" name="id_user_code" value="<? echo $_COOKIE["USER"];?>">
						<input id="id_code_utilizado" type="hidden" name="id_code_utilizado" value="">
						<div id="erroCode" class="erro" style="float:right;"></div>
					</div>
					<div class="cartResumo">
						<div class="imgResumo" style="background:url('/img/camiao.svg')no-repeat 50% 50%;background-size:50% auto !important;"></div>
						<div class="floatl">
							<div class="nomeResumo"><? if($LANG=='pt'){echo "Transporte";} if($LANG=='en'){echo "Shipping";} ?></div>
						</div>
						<div class="floatr textr">
							<div class="precoResumo"><span id="RprecoP">50.00 €</span> </div>
						</div>
						<div class="clear"></div>
		    		</div>
			    	<?
					$precoTotal = number_format($precoTotal, 2, '.', '');?>
					<div id="RCART2" class="cartFinal">
						Total
						<div class="total"><span id="RTotal"><? echo $precoTotal;?></span> €</div><br>
					</div>
					<?
				} ?>
	          	<div class="clear"></div>
	          	<div id="BT_S2"><input id="btS2" type="button" class="btA" value="<? if($LANG=='pt'){echo "SEGUINTE";} if($LANG=='en'){echo "NEXT";} ?>" onClick="transporte();"/></div>
	    	</div>
  	  	</div>
      	<!-- FIM RESUMO -->
      	<!-- PAGAMENTO -->
      	<div id="PAGAMENTO" class="none">
		    <div class="barraAzul"><? if($LANG=='pt'){echo "MÉTODO DE PAGAMENTO";} if($LANG=='en'){echo "PAYMENT METHOD";} ?></div>
	    	<div id="PAYMENT" class="maxSize">
				<div class="paga100"><? if($LANG=='pt'){echo "PAGAMENTOS 100% SEGUROS";} if($LANG=='en'){echo "100% SAFE PAYMENTS";} ?></div>
				<div><? if($LANG=='pt'){echo "Confidencialidade e proteção dos dados garantidos.";} if($LANG=='en'){echo "We guarantee the security and confidentiality of your data.";} ?></div>

				<!--<div class="pay">
					<input type="radio" id="paypal" name="tipoP" class="RD" value="paypal" checked>
					<label for="paypal" style="margin-right:5px">&nbsp;</label>
				</div>
				<div class="hip">
					<input type="radio" id="hipay" name="tipoP" class="RD" value="hipay" checked>
					<label for="hipay" style="margin-right:5px">&nbsp;</label>
				</div>-->
				<div class="logo-hipay"></div>
				<div class="vermelho"><? if($LANG=='pt'){echo "OS PAGAMENTOS PENDENTES TEM VALIDADE DE 24H<br> APÓS A COMPRA PARA SEREM EFETUADOS.";} if($LANG=='en'){echo "PENDING PAYMENTS HAVE VALIDITY OF 24H<br> AFTER PURCHASE TO BE MADE";} ?></div>
				<!--<div class="mul">
					<input type="radio" id="multibanco" name="tipoP" class="RD" value="multibanco">
					<label for="multibanco" style="margin-right:5px">&nbsp;</label>
				</div>-->
	          	<div class="clear"></div>
				<div id="BT_C"><input id="btC" type="button" class="btA" value="<? if($LANG=='pt'){echo "FINALIZAR COMPRA";} if($LANG=='en'){echo "FINISH PURCHASE";} ?>" onClick="pagamento();"/></div>
	          	<div id="erroC" class="erro"></div>
	          	<!-- tmendes-facilitator@mredis.com	access_token$sandbox$2xrxsvsjwc43wybg$f7b0c2b4c447b0c7087c1ac29f113c3f -->
	    	</div>
  	  	</div>
      	<!-- FIM PAGAMENTO -->
	</section>
</article>
<? include '_footer.php';?>

<script>
$(window).on("scroll", function () {
	if ($(this).scrollTop() > 70){ $('#lojaHeader').css("display","block"); }
	else{ $('#lojaHeader').css("display","none"); }
});

function functionMoradaFact(id_linha) {
    var nome = $('#'+id_linha+'-nome').val();
    var morada = $('#'+id_linha+'-morada').val();
    var codigo = $('#'+id_linha+'-codigo').val();
    var localidade = $('#'+id_linha+'-localidade').val();
    var telemovel = $('#'+id_linha+'-telemovel').val();
    var email = $('#'+id_linha+'-email').val();
    var nif = $('#'+id_linha+'-nif').val();

    $('#Fnome').val(nome);
    $('#Frua').val(morada);
    $('#Fcodpostal').val(codigo);
    $('#Flocalidade').val(localidade);
    $('#Fnif').val(nif);
    $('#Fcontacto').val(telemovel);
    $('#Femail').val(email);
}

function functionMoradaEnvio(id_linha) {
    var nome = $('#'+id_linha+'-nome').val();
    var morada = $('#'+id_linha+'-morada').val();
    var codigo = $('#'+id_linha+'-codigo').val();
    var localidade = $('#'+id_linha+'-localidade').val();
    var telemovel = $('#'+id_linha+'-telemovel').val();

    $('#Enome').val(nome);
    $('#Erua').val(morada);
    $('#Ecodpostal').val(codigo);
    $('#Elocalidade').val(localidade);
    $('#Econtacto').val(telemovel);
}

function mudarCor(id){ $('#'+id).css("color","#222"); }
function mudarQuantidade(id)
{
	var qtP = $('#qtP'+id).val();
	$.post("_carrinho/js_mudarQuantidade.php",{ id : id, qtP : qtP }) 
	.done(function( data ){
		var jsonRetorna = $.parseJSON(data);
		var cookie = jsonRetorna['cookie'];
		createCookie('CARRINHO',cookie,168);
		var qtCarrinho = jsonRetorna['qtCarrinho'];
		$('#TPH').html(qtCarrinho);
		var precoProdu = jsonRetorna['precoProdu'];
		$('#precoP'+id).html(precoProdu+' €');
		var precoTotal = jsonRetorna['precoTotal'];
		$('#Total').html(precoTotal);
		//Resumo
		$('#RqtP'+id).html('Qt. '+qtP);
		$('#RprecoP'+id).html(precoProdu+' €');
	});
}


function apagarProduto(id)
{
	$('#linhaP'+id).css("display","none");
	$.post("_carrinho/js_apagarProduto.php",{ id : id }) 
	.done(function( data ){
		var jsonRetorna = $.parseJSON(data);
		var cookie = jsonRetorna['cookie'];
		createCookie('CARRINHO',cookie,168);
		var qtCarrinho = jsonRetorna['qtCarrinho'];
		$('#TPH').html(qtCarrinho);
		var precoTotal = jsonRetorna['precoTotal'];
		$('#Total').html(precoTotal);
		if(qtCarrinho==0){
			$('#CART1').css("display","none");
			$('#CART2').css("display","none");
			$('#VAZIO').css("display","block");
		}
	});
	//Resumo
	$('#RlinhaP'+id).css("display","none");
}
function carrinho()
{
	$('.E1').css("color","#004f57");
	$('#VOLTAR').html('<button id="BT_VOLTAR" type="button" class="btP conti"><? if($LANG=='pt'){echo "VOLTAR À LOJA";} if($LANG=='en'){echo "BACK TO SHOP";} ?></button>');
	$('#FINALIZAR').html('<button id="BT_FINALIZAR" type="button" class="btP finali" onClick="editCarrinho();"><? if($LANG=='pt'){echo "EDITAR CARRINHO";} if($LANG=='en'){echo "EDIT CART";} ?></button>');
	
	<? $carrinho = $_COOKIE['CARRINHO'];
	$lista = explode(",", $carrinho);
	foreach ($lista as $i => $value)
	{
		$idqt = explode("-", $value);
		$idC = $idqt[0];
		$qtC = $idqt[1]; ?>
		$('#cob'+<? echo $idC;?>).css("display","block");
		<?
	} ?>
	$('#DADOS').css("display","block");
}
function editCarrinho()
{
	$('.E1').css("color","#fff");
	$('#VOLTAR').html('<a href="/loja"><button id="BT_VOLTAR" type="button" class="btC conti"><? if($LANG=='pt'){echo "VOLTAR À LOJA";} if($LANG=='en'){echo "BACK TO SHOP";} ?></button></a>');
	$('#FINALIZAR').html('<button id="BT_FINALIZAR" type="button" class="btA finali" onClick="carrinho();"><? if($LANG=='pt'){echo "CONTINUAR";} if($LANG=='en'){echo "CHECKOUT";} ?></button>');

	<? $carrinho = $_COOKIE['CARRINHO'];
	$lista = explode(",", $carrinho);
	foreach ($lista as $i => $value)
	{
		$idqt = explode("-", $value);
		$idC = $idqt[0];
		$qtC = $idqt[1]; ?>
		$('#cob'+<? echo $idC;?>).css("display","none");
		<?
	} ?>
	editDados();
	$('#DADOS').css("display","none");
}
function guardarDados()
{
	var Fnome = $('#Fnome').val();
	var Frua = $('#Frua').val();
	var Fcodpostal = $('#Fcodpostal').val();
	var Flocalidade = $('#Flocalidade').val();
	var Fzona = $('#Fzona').val();
	var Fnif = $('#Fnif').val();
	var Fcontacto = $('#Fcontacto').val();
	var Femail = $('#Femail').val();

	var Enome = $('#Enome').val();
	var Erua = $('#Erua').val();
	var Ecodpostal = $('#Ecodpostal').val();
	var Elocalidade = $('#Elocalidade').val();
	var Ezona = $('#Ezona').val();	
	var Econtacto = $('#Econtacto').val();
	$.post("_dados/js_dados_faturacao.php",{ Fnome:Fnome, Frua:Frua, Fcodpostal:Fcodpostal, Flocalidade:Flocalidade, Fzona:Fzona, Fnif:Fnif, Fcontacto:Fcontacto, Femail:Femail, Enome:Enome, Erua:Erua, Ecodpostal:Ecodpostal, Elocalidade:Elocalidade, Econtacto:Econtacto, Ezona:Ezona }) 
	.done(function( data ){
		var jsonRetorna = $.parseJSON(data);
		createCookie('DADOS',jsonRetorna,168);
	});
}

function code(){
	var codigo = $('#name_code').val();
	var portes = $('#RprecoP').html();
	var total = $('#RTotal').html();
	var use_code = $('#use_code').val();
	var id_user_code = $('#id_user_code').val();
	
	

	$.post("_carrinho/js_code.php",{ codigo:codigo,portes:portes,total:total,use_code:use_code,id_user_code:id_user_code }) 
	.done(function( data ){
	  	var jsonRetorna = $.parseJSON(data);
		var aviso = jsonRetorna['aviso'];
		var total = jsonRetorna['total_code'];
		var portes = jsonRetorna['tracking_code'];
		var use_code = jsonRetorna['use_code'];
		var id_code_utilizado = jsonRetorna['id_code_utilizado'];
	
		if(aviso){
			$('#erroCode').html(aviso);
			setTimeout(function(){ $('#erroCode').html(''); },3000);
		}
		else{
			$('#RprecoP').html(portes);
			$('#RTotal').html(total);
			$('#id_code_utilizado').val(id_code_utilizado);
			if (use_code == 1) {
				$('#use_code').val(use_code);
			}
			
		}
	});
}

$('#check_loja').click(function() {
	if ($(this).is(':checked') == true) {
	    $('#check_loja').prop('value', 1);
	    $('#check_envio').prop('value', 0);
	}
});

$('#check_envio').click(function() {
	if ($(this).is(':checked') == true) {
	    $('#check_envio').prop('value', 1);
	    $('#check_loja').prop('value', 0);
	}
});

function dados()
{
	var Fnome = $('#Fnome').val();
	var Frua = $('#Frua').val();
	var Fcodpostal = $('#Fcodpostal').val();
	var Flocalidade = $('#Flocalidade').val();
	var Fzona = $('#Fzona').val();
	var Fnif = $('#Fnif').val();
	var Fcontacto = $('#Fcontacto').val();
	var Femail = $('#Femail').val();
	var Mmorada = document.getElementById('Mmorada').checked;
	var Enome = $('#Enome').val();
	var Erua = $('#Erua').val();
	var Ecodpostal = $('#Ecodpostal').val();
	var Elocalidade = $('#Elocalidade').val();
	var Ezona = $('#Ezona').val();	
	var Econtacto = $('#Econtacto').val();
	var envio_loja = $('#check_loja').val();
	var envio_casa = $('#check_envio').val();
	
	$.post("_carrinho/js_morada.php",{ Fnome:Fnome, Frua:Frua, Fcodpostal:Fcodpostal, Flocalidade:Flocalidade, Fzona:Fzona, Fnif:Fnif, Fcontacto:Fcontacto,
		Femail:Femail, Mmorada:Mmorada, Enome:Enome, Erua:Erua, Ecodpostal:Ecodpostal, Elocalidade:Elocalidade, Econtacto:Econtacto, Ezona:Ezona,envio_loja:envio_loja, envio_casa:envio_casa }) 
	.done(function( data ){
	  	var jsonRetorna = $.parseJSON(data);
		var aviso = jsonRetorna['aviso'];
		var portes = jsonRetorna['portes'];
		var peso = jsonRetorna['peso'];
		var cookie = jsonRetorna['cookie'];

		var envio_loja = jsonRetorna['envio_loja'];
		console.log(portes);
		console.log(envio_loja);
		if(aviso){
			$('#erroF').html(aviso);
			setTimeout(function(){ $('#erroF').html(''); },3000);
		}
		else{
			$('.E2').css("color","#004f57");
			$('#COOKIE').val(cookie);
			document.getElementById('Fnome').disabled=true;
			document.getElementById('Frua').disabled=true;
			document.getElementById('Fcodpostal').disabled=true;
			document.getElementById('Flocalidade').disabled=true;
			document.getElementById('Fzona').disabled=true;
			$('#Fzona').css("color","#6D6D6D");
			$('#Fzona').css("background-color","#e3e3e3");
			document.getElementById('Fnif').disabled=true;
			document.getElementById('Fcontacto').disabled=true;
			document.getElementById('Femail').disabled=true;
			document.getElementById('Mmorada').disabled=true;
			document.getElementById('Enome').disabled=true;
			document.getElementById('Erua').disabled=true;
			document.getElementById('Ecodpostal').disabled=true;
			document.getElementById('Elocalidade').disabled=true;
			document.getElementById('Ezona').disabled=true;
			document.getElementById('Econtacto').disabled=true;
			document.getElementById('morada_faturacao').disabled=true;
			document.getElementById('morada_entrega').disabled=true;
			document.getElementById('check_loja').disabled=true;
			document.getElementById('check_envio').disabled=true;
			
			
			
			$('#Ezona').css("color","#6D6D6D");
			$('#Ezona').css("background-color","#e3e3e3");
			$('#BT_S1').html('<input type="button" class="btP" value="<? if($LANG=='pt'){echo "EDITAR";} if($LANG=='en'){echo "EDIT";} ?>" onClick="editDados();"/>');
			if (portes == 0) {
				$('#RprecoP').html('GRATUITO');
			}else{
				$('#RprecoP').html(portes+' €');
			}
			
			var subtotal = $('#Total').html();
			var TOTAL = parseFloat(subtotal) + parseFloat(portes);
			TOTAL = parseFloat(TOTAL.toFixed(2));
			$('#RTotal').html(TOTAL);
			$('#RESUMO').css("display","block");
		}
	});
}
function editDados()
{
	$('.E2').css("color","#fff");
	document.getElementById('Fnome').disabled=false;
	document.getElementById('Frua').disabled=false;
	document.getElementById('Fcodpostal').disabled=false;
	document.getElementById('Flocalidade').disabled=false;
	document.getElementById('Fzona').disabled=false;
	$('#Fzona').css("color","#222");
	$('#Fzona').css("background-color","#fff");
	document.getElementById('Fnif').disabled=false;
	document.getElementById('Fcontacto').disabled=false;
	document.getElementById('Femail').disabled=false;
	document.getElementById('Mmorada').disabled=false;
	document.getElementById('Enome').disabled=false;
	document.getElementById('Erua').disabled=false;
	document.getElementById('Ecodpostal').disabled=false;
	document.getElementById('Elocalidade').disabled=false;
	document.getElementById('Ezona').disabled=false;
	document.getElementById('Econtacto').disabled=false;

	document.getElementById('morada_faturacao').disabled=false;
	document.getElementById('morada_entrega').disabled=false;

	document.getElementById('check_loja').disabled=false;
	document.getElementById('check_envio').disabled=false;
	$('#use_code').val(0);
	$('#name_code').val('');
	
	$('#Ezona').css("color","#222");
	$('#Ezona').css("background-color","#fff");
	$('#BT_S1').html('<input id="btS1" type="button" class="btA" value="<? if($LANG=='pt'){echo "SEGUINTE";} if($LANG=='en'){echo "NEXT";} ?>" onClick="dados();"/>');
	$('#RESUMO').css("display","none");
	editTransporte();
}
function transporte()
{
	$('.E3').css("color","#004f57");
	$('#BT_S2').html('');
	$('#PAGAMENTO').css("display","block");
}
function editTransporte()
{
	$('.E3').css("color","#fff");
	$('#BT_S2').html('<input id="btS2" type="button" class="btA" value="<? if($LANG=='pt'){echo "SEGUINTE";} if($LANG=='en'){echo "NEXT";} ?>" onClick="transporte();"/>');
	$('#PAGAMENTO').css("display","none");
}
function pagamento()
{
	$('.E4').css("color","#004f57");
	//var paypal = document.getElementById("paypal").checked;
	//var multib = document.getElementById("multibanco").checked;
	//var hipay = document.getElementById("hipay").checked;
	//if(paypal){ var tipo = 'paypal'; }
	//if(multib){ var tipo = 'multibanco'; }
	//if(hipay){ var tipo = 'hipay'; }
	var tipo = 'hipay';
	var portes = $('#RprecoP').html();
	var total = $('#RTotal').html();

	var Fnome = $('#Fnome').val();
	var Frua = $('#Frua').val();
	var Fcodpostal = $('#Fcodpostal').val();
	var Flocalidade = $('#Flocalidade').val();
	var Fzona = $('#Fzona').val();
	var Fnif = $('#Fnif').val();
	var Fcontacto = $('#Fcontacto').val();
	var Femail = $('#Femail').val();
	var Mmorada = document.getElementById('Mmorada').checked;
	var Enome = $('#Enome').val();
	var Erua = $('#Erua').val();
	var Ecodpostal = $('#Ecodpostal').val();
	var Elocalidade = $('#Elocalidade').val();
	var Ezona = $('#Ezona').val();	
	var Econtacto = $('#Econtacto').val();
	var COOKIE = $('#COOKIE').val();
	var id_user = $('#id_user').val();
	var id_code_utilizado = $('#id_code_utilizado').val();
	var envio_loja = $('#check_loja').val();
	var envio_casa = $('#check_envio').val();


	$.post("_carrinho/js_concluir.php",{COOKIE:COOKIE, Fnome:Fnome, Frua:Frua, Fcodpostal:Fcodpostal, Flocalidade:Flocalidade, Fzona:Fzona, Fnif:Fnif, Fcontacto:Fcontacto, Femail:Femail, Mmorada:Mmorada, Enome:Enome, Erua:Erua, Ecodpostal:Ecodpostal, Elocalidade:Elocalidade, Econtacto:Econtacto, Ezona:Ezona, tipo:tipo, portes:portes, total:total,id_user:id_user,id_code_utilizado:id_code_utilizado,envio_loja:envio_loja,envio_casa:envio_casa}) 
	.done(function( data ){
	  	var jsonRetorna = $.parseJSON(data);
	  	var id = jsonRetorna['id'];
	  	var total = jsonRetorna['total'];
	  	var tracking = jsonRetorna['tracking'];
	 
	  	incializarHipay(id,tracking);
	  	//incializarMultibanco(id,tracking);
		//if(paypal){ incializarPayPal(id,total,tracking);}
		//if(multib){ incializarMultibanco(id,tracking);}
		//if(hipay){ incializarHipay(id,tracking);}
	});
}
function incializarMultibanco(id,tracking)
{
	$.post("_carrinho/js_multibanco.php",{ id:id, tracking:tracking }) 
	.done(function( data ){
	  	var jsonRetorna = $.parseJSON(data);
	  	var id = jsonRetorna['id'];
	  	var url = jsonRetorna['url'];
	  	window.location=url;
	});
}
function incializarHipay(id,tracking)
{
	loadHipay();
	var call = "call";
	$.ajax({
	    type: "POST",
        url:"/_carrinho/js_hipay.php",
        cache: false,
        data:{ 
            call:call,
            id:id,
            tracking:tracking
        },
        success: function(data) {
          
          var jsonRetorna = $.parseJSON(data);
          var url = jsonRetorna['url'];
          var result = jsonRetorna['result'];
          var message = jsonRetorna['message'];
          var id = jsonRetorna['id'];
          //var status = jsonRetorna['status'];
          
            //if(status!=""){
            if(url!=""){
               console.log(url)
               window.location.href=url;
            }
            else{
                
                if(result!=""){
                    console.log(result)
                }
                if(message!=""){
                 
                   console.log(message)
                }
                if(id!=""){
                 
                   console.log(id)
                }
                
                console.log(data)
                
            }
       },
       error: function (xhr,status, error) {
            //alert(ajaxContext.responseText)
            
          window.location.href="https://www.ci-interiordecor.com";
            
          console.log( xhr.status)
          console.log( xhr.statusText )
          console.log( xhr.readyState )
          console.log( xhr.responseText )
           
      }
   });

	
}
function loadHipay()
{
 	jQuery(document).ready(function(){ jQuery('<div class="sa_payPal_overlay" style="visibility:visible;position:fixed; width:100%; height:100%; filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr=\'#88ffffff\', EndColorStr=\'#88ffffff\'); background: rgba(0,0,0,0.7); top:0; left:0; z-index: 999999;"><div style="background:#FFF; background-image:linear-gradient(top, #FFFFFF 45%, #E9ECEF 80%);background-image: -o-linear-gradient(top, #FFFFFF 45%, #E9ECEF 80%);background-image: -moz-linear-gradient(top, #FFFFFF 45%, #E9ECEF 80%);background-image: -webkit-linear-gradient(top, #FFFFFF 45%, #E9ECEF 80%);background-image: -ms-linear-gradient(top, #FFFFFF 45%, #E9ECEF 80%);background-image: -webkit-gradient(linear, left top,left bottom,color-stop(0.45, #FFFFFF),color-stop(0.8, #E9ECEF));display: block;margin: auto;position: fixed; margin-left:-150px;left:50%;top:30%;text-align:center;color:#2F6395;font-family:Arial;padding:15px;font-size:13px;font-weight:bold;width: 300px;-webkit-box-shadow:3px 2px 13px rgba(50, 50, 49, 0.25);box-shadow:rgba(0, 0, 0, 0.2) 0px 0px 0px 5px;border:1px solid #CFCFCF;border-radius:6px;"><img style="display:block;margin:0 auto 10px" src="https://www.paypalobjects.com/en_US/i/icon/icon_animated_prog_dkgy_42wx42h.gif"><h2 style="font-size:30px; margin-bottom:10px;"><? if($LANG=='pt'){echo "Espere alguns segundos.";} if($LANG=='en'){echo "Wait a few seconds.";} ?></h2><p style="font-size:12px;color:#003171;font-weight:400"><? if($LANG=='pt'){echo "Você será redirecionado para um ambiente seguro do Hipay para finalizar o seu pagamento.";} if($LANG=='en'){echo "You will be redirected to a secure Hipay environment to finalize your payment.";} ?></p><div style="margin:20px auto 0;"><img src="/img/hipay-logo.svg" width="100px"/></div></div></div>').appendTo('body');});
}
function incializarPayPal(id,total,tracking)
{
	setTimeout(function(){ 
	simpleCart({
	  checkout: {
		type: "PayPal",
		email: "geral@smr.pt",
		//email: "vitor_pereira_16@sapo.pt",
		//use paypal sandbox, default is false
		sandbox: true, 

		//http method for form, "POST" or "GET", default is "POST"
		method: "GET", 

		success: "http://www.ci-interiordecor.com/sucesso/"+tracking, 
		//success: "https://drink.boutique/mobile/success.php?pagamento=paypal&transportadora="+ transportadora +"&portes="+ total_portes +"&codigo="+codpromocional + "&ivap="+ivaportes +"&ertgbhj="+ codigoseg +"&final="+ total_compra,
		cancel: "http://www.ci-interiordecor.com/carrinho", }
	});

	simpleCart.currency({
		/*code:"USD", symbol:"$", name:"US Dollar", */
		code: "EUR" , 
		symbol: "&euro;" ,
		name: "Euro" ,
		
		//language: "english-us",

		delimiter: " " , 
		decimal: "," , 
		after: false ,
		accuracy: 4
	});
	simpleCart.empty();
	simpleCart.add({ name:"Ci-interiordecor" ,price:total, quantity:"1"});
	simpleCart.checkout();	

	loadPaypal();
	},800);
}
function loadPaypal()
{
 	jQuery(document).ready(function(){ jQuery('<div class="sa_payPal_overlay" style="visibility:visible;position:fixed; width:100%; height:100%; filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr=\'#88ffffff\', EndColorStr=\'#88ffffff\'); background: rgba(0,0,0,0.7); top:0; left:0; z-index: 999999;"><div style="background:#FFF; background-image:linear-gradient(top, #FFFFFF 45%, #E9ECEF 80%);background-image: -o-linear-gradient(top, #FFFFFF 45%, #E9ECEF 80%);background-image: -moz-linear-gradient(top, #FFFFFF 45%, #E9ECEF 80%);background-image: -webkit-linear-gradient(top, #FFFFFF 45%, #E9ECEF 80%);background-image: -ms-linear-gradient(top, #FFFFFF 45%, #E9ECEF 80%);background-image: -webkit-gradient(linear, left top,left bottom,color-stop(0.45, #FFFFFF),color-stop(0.8, #E9ECEF));display: block;margin: auto;position: fixed; margin-left:-150px;left:50%;top:30%;text-align:center;color:#2F6395;font-family:Arial;padding:15px;font-size:13px;font-weight:bold;width: 300px;-webkit-box-shadow:3px 2px 13px rgba(50, 50, 49, 0.25);box-shadow:rgba(0, 0, 0, 0.2) 0px 0px 0px 5px;border:1px solid #CFCFCF;border-radius:6px;"><img style="display:block;margin:0 auto 10px" src="https://www.paypalobjects.com/en_US/i/icon/icon_animated_prog_dkgy_42wx42h.gif"><h2 style="font-size:30px; margin-bottom:10px;">Espere alguns segundos.</h2><p style="font-size:12px;color:#003171;font-weight:400">Você será redirecionado para um ambiente seguro do Paypal para finalizar o seu pagamento.</p><div style="margin:20px auto 0;"><img src="https://www.paypal-brasil.com.br/logocenter/util/img/logo_paypal.png"/></div></div></div>').appendTo('body');});
}
</script>    
</body>
</html>