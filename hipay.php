<?php
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
//$client = new SoapClient('https://ws.hipay.com/soap/payment-v2?wsdl', $options);
$client = new SoapClient('https://test-ws.hipay.com/soap/payment-v2?wsdl', $options);

// STEP 3 : Soap call on confirm method of manual-capture webservice
$result = $client->generate(array('parameters'=>array(
'wsLogin' => '61435fa262a9b03181457dd7bf5bd4d1',
'wsPassword' => 'f426f53ff0a8a64fc03075abd401e8be',
'websiteId' => '376087',
'categoryId' => '653',
'description' => 'test',
'currency' => 'EUR',
'amount' => '2',
'rating' => 'ALL',
'locale' => 'pt_PT',
'customerIpAddress' => '46.182.41.35',
'manualCapture' => '0',
'executionDate' => '2014-11-18T11:01:55', 
'customerEmail' => 'tmendes@mredis.com',
'urlCallback' => 'http://example.com/wallet/notification.php',
'urlAccept' => 'http://example.com/wallet/return.php'
)));
// STEP 4 : Response
var_dump($result);
echo $_POST['redirectUrl'];

?>