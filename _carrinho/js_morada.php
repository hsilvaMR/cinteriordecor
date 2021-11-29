<?php
include('../_connect.php');

/*
$jsonReceiveData = json_encode($_POST);
$jsonIterator = new RecursiveIteratorIterator(new RecursiveArrayIterator(json_decode($jsonReceiveData, TRUE)),RecursiveIteratorIterator::SELF_FIRST);

$valores = array();
foreach ($jsonIterator as $key => $val)
{
   if(is_array($val)) { foreach($val as $key1 => $val1) { $valores[$key][$key1] = $val1; } }
   else { $valores[$key] = $val; }
}
$Fnome = $valores['Fnome'];
$Frua = $valores['Frua'];
$Fcodpostal = $valores['Fcodpostal'];
$Flocalidade = $valores['Flocalidade'];
$Fzona = $valores['Fzona'];
$Fnif = $valores['Fnif'];
$Fnif = filter_var($Fnif, FILTER_VALIDATE_INT);
$Fcontacto = $valores['Fcontacto'];
$Fcontacto = filter_var($Fcontacto, FILTER_VALIDATE_INT);
$Femail = $valores['Femail'];
$Femail = filter_var($Femail, FILTER_VALIDATE_EMAIL);
$Mmorada = $valores['Mmorada'];
$Enome = $valores['Enome'];
$Erua = $valores['Erua'];
$Ecodpostal = $valores['Ecodpostal'];
$Elocalidade = $valores['Elocalidade'];
$Ezona = $valores['Ezona'];
$Econtacto = $valores['Econtacto'];
$Econtacto = filter_var($Econtacto, FILTER_VALIDATE_INT);
*/

$Fnome = isset($_POST['Fnome']) ? $_POST['Fnome'] : '';
$Frua = isset($_POST['Frua']) ? $_POST['Frua'] : '';
$Fcodpostal = isset($_POST['Fcodpostal']) ? $_POST['Fcodpostal'] : '';
$Flocalidade = isset($_POST['Flocalidade']) ? $_POST['Flocalidade'] : '';
$Fzona = isset($_POST['Fzona']) ? $_POST['Fzona'] : '';
$Fnif = isset($_POST['Fnif']) ? $_POST['Fnif'] : '';
$Fnif = filter_var($Fnif, FILTER_VALIDATE_INT);
$Fcontacto = isset($_POST['Fcontacto']) ? $_POST['Fcontacto'] : '';
$Fcontacto = filter_var($Fcontacto, FILTER_VALIDATE_INT);
$Femail = isset($_POST['Femail']) ? $_POST['Femail'] : '';
$Femail = filter_var($Femail, FILTER_VALIDATE_EMAIL);
$Mmorada = isset($_POST['Mmorada']) ? $_POST['Mmorada'] : '';
$Enome = isset($_POST['Enome']) ? $_POST['Enome'] : '';
$Erua = isset($_POST['Erua']) ? $_POST['Erua'] : '';
$Ecodpostal = isset($_POST['Ecodpostal']) ? $_POST['Ecodpostal'] : '';
$Elocalidade = isset($_POST['Elocalidade']) ? $_POST['Elocalidade'] : '';
$Ezona = isset($_POST['Ezona']) ? $_POST['Ezona'] : '';
$Econtacto = isset($_POST['Econtacto']) ? $_POST['Econtacto'] : '';
$Econtacto = filter_var($Econtacto, FILTER_VALIDATE_INT);

$envio_loja = isset($_POST['envio_loja']) ? $_POST['envio_loja'] : 0;
$envio_casa = isset($_POST['envio_casa']) ? $_POST['envio_casa'] : 0;

//$retorna['alerta'] = "$Fnome = $Frua = $Fcodpostal = $Flocalidade = $Fnif = $Fcontacto = $Femail = $Mmorada = $Enome = $Erua = $Ecodpostal = $Elocalidade";

$retorna['aviso']=''; $aviso='';
$retorna['portes']=''; $portes=0;
$retorna['peso']=''; $peso=0;
$retorna['cookie']=''; $carrinho='';


if($LANG=='pt'){
	if(!$Fnome){$retorna['aviso'] = "Insira o seu nome!"; $aviso=1;}
	if(!$Frua and !$aviso){$retorna['aviso'] = "Insira a sua rua!"; $aviso=1;}
	if(!$Fcodpostal and !$aviso){$retorna['aviso'] = "Insira o seu código postal!"; $aviso=1;}
	if($Fcodpostal and !$aviso and strlen($Fcodpostal)<8){$retorna['aviso'] = "Insira o seu código postal completo!"; $aviso=1;}
	if(!$Flocalidade and !$aviso){$retorna['aviso'] = "Insira o sua localidade!"; $aviso=1;}
	if(!$Fzona and !$aviso){$retorna['aviso'] = "Selecione a região!"; $aviso=1;}
	

	//if(!$Bnif and !$aviso){$retorna['aviso'] = "Insira o seu nif!"; $aviso=1;}
	/*if($Fnif and !$aviso){
		//$urlNIF = "http://www.nif.pt/?json=1&q=509620825&key=434071be109769a29bd099926a7c8661";
		$urlNIF = "http://www.nif.pt/?json=1&q=".$Fnif."&key=434071be109769a29bd099926a7c8661";
		$jsNIF = json_decode(file_get_contents($urlNIF), true);
		$result = $jsNIF['result'];
		//$seo_url =$jsNIF['records']['509620825']['seo_url'];
		if($result != 'success')
		{
			$nif_validation = $jsNIF['nif_validation'];
			if(!$nif_validation){ $retorna['aviso'] = "Insira corretamente o nif!"; $aviso=1; }
		}
	}*/
	if(!$Fcontacto and !$aviso){$retorna['aviso'] = "Insira o seu contacto!"; $aviso=1;}
	if($Fcontacto and !$aviso and strlen($Fcontacto)<9){$retorna['aviso'] = "Insira o seu contacto completo!"; $aviso=1;}
	if(!$Femail and !$aviso){$retorna['aviso'] = "Insira o seu email!"; $aviso=1;}

	if($Mmorada == 'false')
	{
		if(!$Enome and !$aviso){$retorna['aviso'] = "Insira o nome do destinatário!"; $aviso=1;}
		if(!$Erua and !$aviso){$retorna['aviso'] = "Insira a rua de destino!"; $aviso=1;}
		if(!$Ecodpostal and !$aviso){$retorna['aviso'] = "Insira o código postal de destino!"; $aviso=1;}
		if($Ecodpostal and !$aviso and strlen($Ecodpostal)<8){$retorna['aviso'] = "Insira o seu código postal completo de destino!"; $aviso=1;}
		if(!$Elocalidade and !$aviso){$retorna['aviso'] = "Insira a localidade de destino!"; $aviso=1;}
		if(!$Ezona and !$aviso){$retorna['aviso'] = "Selecione a região de destino!"; $aviso=1;}
		if(!$Econtacto and !$aviso){$retorna['aviso'] = "Insira o contacto do destinatário!"; $aviso=1;}
		if($Econtacto and !$aviso and strlen($Econtacto)<9){$retorna['aviso'] = "Insira o contacto completo do destinatário!"; $aviso=1;}
	}
	if($envio_loja == 0 && $envio_casa == 0) {$retorna['aviso'] = "Selecione um método de envio!"; $aviso=1;}
}
if($LANG=='en'){
	if(!$Fnome){$retorna['aviso'] = "Enter your name!"; $aviso=1;}
	if(!$Frua and !$aviso){$retorna['aviso'] = "Enter your address!"; $aviso=1;}
	if(!$Fcodpostal and !$aviso){$retorna['aviso'] = "Enter your zip code!"; $aviso=1;}
	if($Fcodpostal and !$aviso and strlen($Fcodpostal)<8){$retorna['aviso'] = "Enter your full zip code!"; $aviso=1;}
	if(!$Flocalidade and !$aviso){$retorna['aviso'] = "Enter your location!"; $aviso=1;}
	if(!$Fzona and !$aviso){$retorna['aviso'] = "Select region!"; $aviso=1;}

	if(!$Fcontacto and !$aviso){$retorna['aviso'] = "Insert your contact!"; $aviso=1;}
	if($Fcontacto and !$aviso and strlen($Fcontacto)<9){$retorna['aviso'] = "Enter your full contact!"; $aviso=1;}
	if(!$Femail and !$aviso){$retorna['aviso'] = "Enter your email!"; $aviso=1;}

	
	if($Mmorada == 'false')
	{
		if(!$Enome and !$aviso){$retorna['aviso'] = "Enter the recipient's name!"; $aviso=1;}
		if(!$Erua and !$aviso){$retorna['aviso'] = "Enter the destination address!"; $aviso=1;}
		if(!$Ecodpostal and !$aviso){$retorna['aviso'] = "Enter the destination zip code!"; $aviso=1;}
		if($Ecodpostal and !$aviso and strlen($Ecodpostal)<8){$retorna['aviso'] = "Enter your full destination zip code!"; $aviso=1;}
		if(!$Elocalidade and !$aviso){$retorna['aviso'] = "Enter destination city!"; $aviso=1;}
		if(!$Ezona and !$aviso){$retorna['aviso'] = "Select destination region!"; $aviso=1;}
		if(!$Econtacto and !$aviso){$retorna['aviso'] = "Enter the recipient's contact!"; $aviso=1;}
		if($Econtacto and !$aviso and strlen($Econtacto)<9){$retorna['aviso'] = "Enter the recipient's full contact!"; $aviso=1;}
	}

	if($envio_loja == 0 && $envio_casa == 0) {$retorna['aviso'] = "Select a shipping method!"; $aviso=1;}
}

//if(!$aviso){ mysqli_query($link, "INSERT INTO moradas (id_utilizador, nome, telefone, rua, codpostal, localidade, pais, tipo, comentario) VALUES ('$id_user', '$Snome', '$Stelefone', '$Smorada', '$Scodpostal', '$Slocalidade', '$Spais', 'envio', '$Scomentario')"); }

//TRANSPORTE
if(!$aviso){
	if(($Ezona=='Portugal' && $Mmorada == 'false') || ($Fzona=='Portugal' && $Mmorada == 'true')){
		//Caixa
		$linha_volumetria_caixa = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=1 AND legenda='volumetria'"));
		$volumetria_caixa = $linha_volumetria_caixa['valor'];
		$linha_adicional_caixa = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=1 AND legenda='adicional'"));
		$adicional_caixa = $linha_adicional_caixa['valor'];
		$linha_combustivel_caixa = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=1 AND legenda='combustivel'"));
		$combustivel_caixa = $linha_combustivel_caixa['valor'];
		$combustivel_caixa = ($combustivel_caixa/100) + 1;
		$linha_iva_caixa = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=1 AND legenda='iva'"));
		$iva_caixa = $linha_iva_caixa['valor'];
		$iva_caixa = ($iva_caixa/100) + 1;
		//Palete
		$linha_volumetria_palete = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=2 AND legenda='volumetria'"));
		$volumetria_palete = $linha_volumetria_palete['valor'];
		$linha_adicional_palete = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=2 AND legenda='adicional'"));
		$adicional_palete = $linha_adicional_palete['valor'];
		$linha_medida_palete = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=2 AND legenda='medida'"));
		$medida_palete = $linha_medida_palete['medida'];
		$combustivel_palete = $combustivel_caixa;
		$iva_palete = $iva_caixa;

		//Verificar volumetria
		$carrinho = $_COOKIE['CARRINHO'];
		$volume_caixa = '';
		$peso_caixa = 0;
		$peso_palete = 0;
		$max_comprimento = 0;
		$max_largura = 0;
		$max_altura = 0;
		$caixas_individuais = 0;
		$lista = explode(",", $carrinho);
		foreach ($lista as $i => $value) {
			$idqt = explode("-", $value);
			$id = $idqt[0];
			$qt = $idqt[1];
			
			$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto WHERE id='$id'"));
			$pesoP = $linha['peso'] ? $linha['peso'] : 1;
			$pesoP = $pesoP/1000;
			$comprimentoP = $linha['comprimento'] ? $linha['comprimento'] : 1;
			$comprimentoP = $comprimentoP/100;
			$larguraP = $linha['largura'] ? $linha['largura'] : 1;
			$larguraP = $larguraP/100;
			$alturaP = $linha['altura'] ? $linha['altura'] : 1;
			$alturaP = $alturaP/100;

			#Caixa
			if($volume_caixa != 'invalido'){ 
				$volume_caixa = $comprimentoP + (2 * $larguraP) + (2 * $alturaP);
				if($volume_caixa >= 3){ $volume_caixa = 'invalido'; }
				else{
					$volumetriaC = ($comprimentoP * $larguraP * $alturaP) * $volumetria_caixa;
					if($pesoP > $volumetriaC){ $peso_caixa = $peso_caixa + ($pesoP * $qt); }else{ $peso_caixa = $peso_caixa + ($volumetriaC * $qt); }
					//volume total caixa
					$n1=$comprimentoP;
					$n2=$larguraP;
					$n3=$alturaP;
					$maior=0;
					$menor=0;
					$meio=0;
					if($n1>=$n2 && $n1>=$n3){ $maior=$n1; if($n2<=$n3){ $menor=$n2; $meio=$n3; }else{ $menor=$n3; $meio=$n2; } }
					if($n2>=$n1 && $n2>=$n3){ $maior=$n2; if($n1<=$n3){ $menor=$n1; $meio=$n3; }else{ $menor=$n3; $meio=$n1; } }
					if($n3>=$n1 && $n3>=$n2){ $maior=$n3; if($n2<=$n1){ $menor=$n2; $meio=$n1; }else{ $menor=$n1; $meio=$n2; } }
					if($maior>$max_comprimento){$max_comprimento=$maior;}
					if($meio>$max_largura){$max_largura=$meio;}
					$max_altura = $max_altura + ($menor * $qt);
					//portes individuais
					$existeCI=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=1 AND de<'$peso_caixa' AND ate>='$peso_caixa' AND legenda='peso'"));
					if($existeCI){
						$linhaCaixaI=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=1 AND de<'$peso_caixa' AND ate>='$peso_caixa' AND legenda='peso'"));
						$caixas_individuais = $caixas_individuais + $linhaCaixaI['valor'];
					}else{
						$linhaCaixaI=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=1 AND legenda='peso' ORDER BY ate DESC"));
						$kg_caixaI = $linhaCaixaI['ate'];
						$valor_caixaI = $linhaCaixaI['valor'];
						$resto_caixaI = ceil($peso_caixa-$kg_caixaI);
						$caixas_individuais = $caixas_individuais + $valor_caixaI + ($resto_caixaI*$adicional_caixa);
					}
				}
			}
			if($peso_caixa>30){ $volume_caixa = 'invalido'; }
			#Palete
			$volumetriaP = ($comprimentoP * $larguraP * $alturaP) * $volumetria_palete;
			if($pesoP > $volumetriaP){ $peso_palete = $peso_palete + ($pesoP * $qt); }else{ $peso_palete = $peso_palete + ($volumetriaP * $qt); }
		}
		#Caixa
		if($volume_caixa != 'invalido'){
			$max_volume_caixa = $max_comprimento + (2 * $max_largura) + (2 * $max_altura);
			if($max_volume_caixa>3){
				$portes_caixa = $caixas_individuais;
			}else{	
				$existeC=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=1 AND de<'$peso_caixa' AND ate>='$peso_caixa' AND legenda='peso'"));
				if($existeC){
					$linhaCaixa=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=1 AND de<'$peso_caixa' AND ate>='$peso_caixa' AND legenda='peso'"));
					$portes_caixa = $linhaCaixa['valor'];
				}else{
					$linhaCaixa=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=1 AND legenda='peso' ORDER BY ate DESC"));
					$kg_caixa = $linhaCaixa['ate'];
					$valor_caixa = $linhaCaixa['valor'];
					$resto_caixa = ceil($peso_caixa-$kg_caixa);
					$portes_caixa = $valor_caixa + ($resto_caixa*$adicional_caixa);
				}
			}
		}
		#Palete
		$existeP=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=2 AND de<'$peso_palete' AND ate>='$peso_palete' AND legenda='peso'"));
		if($existeP){
			$linhaPalete=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=2 AND de<'$peso_palete' AND ate>='$peso_palete' AND legenda='peso'"));
			$portes_palete = $linhaPalete['valor'];
		}else{
			$linhaPalete=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=2 AND legenda='peso' ORDER BY ate DESC"));
			$kg_palete = $linhaPalete['ate'];
			$valor_palete = $linhaPalete['valor'];
			$resto_palete = ceil($peso_palete-$kg_palete);
			$portes_palete = $valor_palete + ($resto_palete*$adicional_palete);
		}
		#Caixa vs Palete
		if($volume_caixa!='invalido' && $portes_caixa<=$portes_palete){ $portes=$portes_caixa * $combustivel_caixa * $iva_caixa;  $peso=$peso_caixa; }
		else{ $portes=$portes_palete * $combustivel_palete * $iva_caixa; $peso=$peso_palete; }
	}
	else{
		//Maritimo
		$linha_volumetria_maritimo = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=3 AND legenda='volumetria'"));
		$volumetria_maritimo = $linha_volumetria_maritimo['valor'];
		$linha_adicional_maritimo = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=3 AND legenda='adicional'"));
		$adicional_maritimo = $linha_adicional_maritimo['valor'];
		$linha_combustivel_maritimo = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=3 AND legenda='combustivel'"));
		$combustivel_maritimo = $linha_combustivel_maritimo['valor'];
		$combustivel_maritimo = ($combustivel_maritimo/100) + 1;

		//Verificar volumetria
		$carrinho = $_COOKIE['CARRINHO'];
		$volume_maritimo = '';
		$peso_maritimo = 0;
		$lista = explode(",", $carrinho);
		foreach ($lista as $i => $value) {
			$idqt = explode("-", $value);
			$id = $idqt[0];
			$qt = $idqt[1];
			
			$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM produto WHERE id='$id'"));
			$pesoP = $linha['peso'];
			$pesoP = $pesoP/1000;
			$comprimentoP = $linha['comprimento'];
			$comprimentoP = $comprimentoP/100;
			$larguraP = $linha['largura'];
			$larguraP = $larguraP/100;
			$alturaP = $linha['altura'];
			$alturaP = $alturaP/100;

			#Maritimo
			$volumetriaM = ($comprimentoP * $larguraP * $alturaP) * $volumetria_maritimo;
			if($pesoP > $volumetriaM){ $peso_maritimo = $peso_maritimo + ($pesoP * $qt); }else{ $peso_maritimo = $peso_maritimo + ($volumetriaM * $qt); }
		}
		#Maritimo
		$existeM=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=3 AND de<'$peso_maritimo' AND ate>='$peso_maritimo' AND legenda='peso'"));
		if($existeM){
			$linhaMaritimo=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=3 AND de<'$peso_maritimo' AND ate>='$peso_maritimo' AND legenda='peso'"));
			$portes_maritimo = $linhaMaritimo['valor'];
		}else{
			$linhaMaritimo=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fema WHERE id_tipo=3 AND legenda='peso' ORDER BY ate DESC"));
			$kg_maritimo = $linhaMaritimo['ate'];
			$valor_maritimo = $linhaMaritimo['valor'];
			$resto_maritimo = ceil($peso_maritimo-$kg_maritimo);
			$portes_maritimo = $valor_maritimo + ($resto_maritimo*$adicional_maritimo);
		}
		#Maritimo
		$portes=$portes_maritimo * $combustivel_maritimo;
		$peso=$peso_maritimo;
	}
}

$retorna['envio_loja'] =$envio_loja;
if ($envio_loja == 1) {
	$retorna['portes'] = 0;
}else{
	$retorna['portes'] = number_format($portes, 2, '.', '');
}

$retorna['peso'] = number_format($peso, 2, '.', '');
$retorna['cookie'] = $carrinho;
//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>