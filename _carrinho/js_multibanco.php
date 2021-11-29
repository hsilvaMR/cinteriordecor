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

$id = $valores['id'];
$tracking = $valores['tracking'];
*/

$id = isset($_POST['id']) ? $_POST['id'] : '';
$tracking = isset($_POST['tracking']) ? $_POST['tracking'] : '';
//$retorna['alerta'] = "$seguranca";

extract(mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM venda WHERE id='$id' AND tracking='$tracking'")));

$ref_hora = str_replace(":", "", $hora);
$track = 'CI'.$id.'IN'.$ref_hora;
#HIPAY
//$username = "61435fa262a9b03181457dd7bf5bd4d1";
//$password = "f426f53ff0a8a64fc03075abd401e8be";
//$websiteId = "376087";
//$shopId = "881";
//$categoryId = "653";

// STEP 1 : soap flow options
$options = array(
'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
'cache_wsdl' => WSDL_CACHE_NONE,
'soap_version' => SOAP_1_1,
'encoding' => 'UTF-8'
);
// STEP 2 : Soap client initialization 
$client = new SoapClient('https://ws.hipay.com/soap/payment-v2?wsdl', $options);
//$client = new SoapClient('https://test-ws.hipay.com/soap/payment-v2?wsdl', $options);

// STEP 3 : Soap call on confirm method of manual-capture webservice
$result = $client->generate(array('parameters'=>array(
'wsLogin' => '61435fa262a9b03181457dd7bf5bd4d1',
'wsPassword' => 'f426f53ff0a8a64fc03075abd401e8be',
'websiteId' => '376087',
'categoryId' => '653',
#'urlLogo' => 'http://www.ci-interiordecor.com/img/logo_frase.svg',
'description' => $tracking,
#'merchantReference' => 'Ref (#'.$id.')',
#'merchantComment' => 'Com (#'.$id.')', //comentário dos comerciantes relativa à ordem.
'currency' => 'EUR',
'amount' => $total,
'rating' => 'ALL',
'locale' => 'pt_PT', //pt_PT, en_GB, fr_FR, es_ES, it_IT
'customerIpAddress' => '46.182.41.35', //O endereço IP do seu cliente para fazer a compra
'manualCapture' => '0',
'executionDate' => date('Y-m-dTH:i:s'), //'executionDate' => '2014-11-18T11:01:55', date('Y-m-dTH:i:s')
'customerEmail' => $email, //email cliente
#'emailCallback' => 'tiago_mendes@live.com.pt', //E-mail usado por HiPay Wallet para notificações pós-operatórias.
'urlCallback' => 'http://www.ci-interiordecor.com/processar/'.$id.'/'.$seguranca, //URL usado pela Hipay para enviar-lhe informações, a fim de atualizar o seu banco de dados.
'urlAccept' => 'http://www.ci-interiordecor.com/sucesso/'.$tracking, //A URL para retornar seu cliente uma vez que o processo de pagamento é concluído com êxito.
'urlCancel' => 'http://www.ci-interiordecor.com/carrinho',
)));

// STEP 4 : Response
//var_dump($result);
//echo $_POST['redirectUrl'];

//$retorna['url']= $result['redirectUrl'];
$genResult = $result->generateResult;
$retorna['url']= $genResult->redirectUrl;

$retorna['result']= $genResult;


$retorna['id']= $id;
$retorna['seguranca']= $seguranca;
$retorna['total']= $total;
//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;
echo json_encode($retorna);
?>