<?php
include('../_connect.php');
include('funcao.php');

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
$Fcontacto = $valores['Fcontacto'];
$Femail = $valores['Femail'];
$Mmorada = $valores['Mmorada']; //Mesma morada
$Enome = $valores['Enome'];
$Erua = $valores['Erua'];
$Ecodpostal = $valores['Ecodpostal'];
$Elocalidade = $valores['Elocalidade'];
$Ezona = $valores['Ezona'];
$Econtacto = $valores['Econtacto'];
$tipo = $valores['tipo']; //Metodo de pagamento
$portes = $valores['portes'];
$total = $valores['total'];
$COOKIE = $valores['COOKIE'];
*/
$Fnome = isset($_POST['Fnome']) ? $_POST['Fnome'] : '';
$Frua = isset($_POST['Frua']) ? $_POST['Frua'] : '';
$Fcodpostal = isset($_POST['Fcodpostal']) ? $_POST['Fcodpostal'] : '';
$Flocalidade = isset($_POST['Flocalidade']) ? $_POST['Flocalidade'] : '';
$Fzona = isset($_POST['Fzona']) ? $_POST['Fzona'] : '';
$Fnif = isset($_POST['Fnif']) ? $_POST['Fnif'] : '';
$Fcontacto = isset($_POST['Fcontacto']) ? $_POST['Fcontacto'] : '';
$Femail = isset($_POST['Femail']) ? $_POST['Femail'] : '';
$Mmorada = isset($_POST['Mmorada']) ? $_POST['Mmorada'] : '';
$Enome = isset($_POST['Enome']) ? $_POST['Enome'] : '';
$Erua = isset($_POST['Erua']) ? $_POST['Erua'] : '';
$Ecodpostal = isset($_POST['Ecodpostal']) ? $_POST['Ecodpostal'] : '';
$Elocalidade = isset($_POST['Elocalidade']) ? $_POST['Elocalidade'] : '';
$Ezona = isset($_POST['Ezona']) ? $_POST['Ezona'] : '';
$Econtacto = isset($_POST['Econtacto']) ? $_POST['Econtacto'] : '';
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : ''; //Metodo de pagamento
$portes = isset($_POST['portes']) ? $_POST['portes'] : '';
$total = isset($_POST['total']) ? $_POST['total'] : '';
$COOKIE = isset($_POST['COOKIE']) ? $_POST['COOKIE'] : '';
$id_user = isset($_POST['id_user']) ? $_POST['id_user'] : '';
$id_code_utilizado = isset($_POST['id_code_utilizado']) ? $_POST['id_code_utilizado'] : '';
$envio_loja = isset($_POST['envio_loja']) ? $_POST['envio_loja'] : 0;
$envio_casa = isset($_POST['envio_casa']) ? $_POST['envio_casa'] : 0;

$total = number_format($total, 2, '.', '');
//$retorna['alerta'] = "$Fnome = $Frua = $Fcodpostal = $Flocalidade = $Fnif = $Fcontacto = $Femail = $Mmorada = $Enome = $Erua = $Ecodpostal = $Elocalidade";
if($Mmorada == 'true')
{
	$Enome = $Fnome;
	$Erua = $Frua;
	$Ecodpostal = $Fcodpostal;
	$Elocalidade = $Flocalidade;
	$Ezona = $Fzona;
	$Econtacto = $Fcontacto;
}

$produtos = 0;
$carrinho = $COOKIE;
$lista = explode(",", $carrinho);
foreach ($lista as $i => $value)
{
	$idqt = explode("-", $value);
	$idC = $idqt[0];
	$qtC = $idqt[1];
	
	$linha = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM produto WHERE id = '$idC'"));
	$preco = number_format($linha['preco'], 2, '.', '');

	$desconto = number_format($linha['desconto'], 2, '.', '');
	$saldo = $linha["saldo"];

	$id_produto_cat = $linha['id_produto_cat'];

	//PROMOÇÃO
	$hoje=date('Y-m-d');
	$linhaPromo = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM promocao WHERE (categoria='$id_produto_cat' OR categoria=0) AND inicio<='$hoje' AND fim>='$hoje' ORDER BY valor DESC"));
	$valorPromo = $linhaPromo["valor"];

	if($valorPromo){
		$desconto = (100-$valorPromo)*$preco/100;
		$desconto = number_format($desconto, 2, '.', '');
		$preco = $desconto;
	}
	else{ if($saldo && $desconto!='0.00' && $desconto<$preco){ $preco = $desconto; } }
	//if($saldo && $desconto!='0.00' && $desconto<$preco){ $preco = $desconto; }

	$produtos = $produtos + ($preco * $qtC);
	//$total = $total + $produtos;
}

//predefinido
$estado = 'pendente';
$data = date('Y-m-d');
$hora = date('H:i:s');
$seguranca = geraSenha(10);
$tracking = geraSenha(6);

$metodo_envio = 'envio';
if ($envio_loja == 1) {
	$metodo_envio = 'levantamento';
}

mysqli_query($lnk, "INSERT INTO venda(id_user,nome,rua,postal,localidade,regiao,contacto,nif,email,nome2,rua2,postal2,localidade2,regiao2,contacto2,produtos,portes,total,metodo,estado,seguranca,tracking,data,hora,metodo_envio) VALUES 
	('$id_user','$Fnome','$Frua','$Fcodpostal','$Flocalidade','$Fzona','$Fcontacto','$Fnif','$Femail','$Enome','$Erua','$Ecodpostal','$Elocalidade','$Ezona','$Econtacto','$produtos','$portes','$total','$tipo','$estado','$seguranca','$tracking','$data','$hora','$metodo_envio')");
$id_venda = mysqli_insert_id($lnk);

//lista produtos
foreach ($lista as $i => $value)
{
	$idqt = explode("-", $value);
	$idC = $idqt[0];
	$qtC = $idqt[1];
	
	$linha2 = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM produto WHERE id = '$idC'"));
	$produ2 = $linha2['produzir'];
	$quant2 = $linha2['quantidade'];
	$preco2 = number_format($linha2['preco'], 2, '.', '');

	$desconto2 = number_format($linha2['desconto'], 2, '.', '');
	$saldo2 = $linha2["saldo"];

	$id_produto_cat2 = $linha2['id_produto_cat'];

	//PROMOÇÃO
	$hoje=date('Y-m-d');
	$linhaPromo = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM promocao WHERE (categoria='$id_produto_cat2' OR categoria=0) AND inicio<='$hoje' AND fim>='$hoje' ORDER BY valor DESC"));
	$valorPromo = $linhaPromo["valor"];

	if($valorPromo){
		$desconto2 = (100-$valorPromo)*$preco2/100;
		$desconto2 = number_format($desconto2, 2, '.', '');
		$preco2 = $desconto2;
	}
	else{ if($saldo2 && $desconto2!='0.00' && $desconto2<$preco2){ $preco2 = $desconto2; } }
	//if($saldo2 && $desconto2!='0.00' && $desconto2<$preco2){ $preco2 = $desconto2; }

	$total2 = $preco2 * $qtC;

	//Tirar do stock
	if($qtC <= $quant2){
		$nova_quant = $quant2 - $qtC;
		mysqli_query($lnk,"UPDATE produto SET quantidade='$nova_quant' WHERE id='$idC'");
	}

	mysqli_query($lnk, "INSERT INTO venda_prod (id_venda,id_produto,preco,quantidade,total) VALUES ('$id_venda','$idC','$preco2','$qtC','$total2')");
}
mysqli_query($lnk, "INSERT INTO tracking (id_venda,id_tracking_est,data) VALUES ('$id_venda',1,'$data')");

if ($id_code_utilizado && $id_user) {
	$hoje=date('Y-m-d');
	mysqli_query($lnk,"UPDATE user_vales SET id_venda='$id_venda',data_utilizacao='$hoje',utilizado='1' WHERE id='$id_code_utilizado'");
}
$retorna['id']= $id_venda;
$retorna['total']= $total;
$retorna['tracking']= $tracking;
$retorna['id_user']= $id_user;

//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>