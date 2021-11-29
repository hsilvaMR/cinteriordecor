<?php


// variables to pass to webservice

$origin = "http://www.ci-interiordecor.com/carrinho";
$username = "a25073f3bb3c282b7b0d366eb52e09f6";
$password = "363ec283622b27ef4aa8cbf092472d1e";
$amount = 25;
$additionalInfo = "Informação adicional";
$name = "Tiago Mendes";
$address = "Rua Travessa do Bico";
$postCode = "4720-538";
$city = "Braga";
$NIC = "";
$externalReference = "54684631687";
$contactPhone = "+351253323335";
$email = "tmendes@mredis.com";
$IDUserBackoffice = -1; //-1 in most cases
$timeLimitDays = 30; //3, 30 or 90 days; only used for entity 11249 and ignored for entity 10241 (must be 0)
$sendEmailBuyer = false;


//variables do store the results to show to the user
$reference="";
$entity="";
$value="";
$error="";


// call webservice
$res = getReferenceFromWebService(
		$origin, $username, $password, $amount, $additionalInfo, $name, $address, 
		$postCode, $city, $NIC, $externalReference, $contactPhone, $email, $IDUserBackoffice, 
		$timeLimitDays, $sendEmailBuyer,
		$reference, $entity, $value, $error);
		
// show details for payment or error
if($res){
	echo ("Detalhes de pagamento:<br/><br/>");
		echo (" entidade: ".$entity."<br/> referência: ".$reference."<br/> montante: ".$value." euros ");
	}
	else{
		echo ( "erro: ".$error);
}
		


// function to call the CompraFacil webservice

function getReferenceFromWebService(
		$origin, $username, $password, $amount, $additionalInfo, $name, $address, 
		$postCode, $city, $NIC, $externalReference, $contactPhone, $email, $IDUserBackoffice, 
		$timeLimitDays, $sendEmailBuyer,
		&$reference, &$entity, &$value, &$error){
		

		
		try 
		{

			// URL from where the webservice is located. This example uses a test webservice; when using in a real environment, 
			// you must replace this URL for the real CompraFacil webservice URL
			$wsURL = "https://hm.comprafacil.pt/SIBSClick2Teste/webservice/CompraFacilWS.asmx?WSDL";
			
		
			$parameters = array(
				"origin" => $origin,
				"username" => $username,
				"password" => $password,
				"amount" => $amount,
				"additionalInfo" => $additionalInfo,
				"name" => $name,
				"address" => $address,
				"postCode" => $postCode,
				"city" => $city,
				"NIC" => $NIC,
				"externalReference" => $externalReference,
				"contactPhone" => $contactPhone,
				"email" => $email,
				"IDUserBackoffice" => $IDUserBackoffice,
				"timeLimitDays" => $timeLimitDays,
				"sendEmailBuyer" => $sendEmailBuyer		
				);
			
			$client = new SoapClient($wsURL);
					
			$res = $client->getReferenceMB($parameters);
		
			if ($res->getReferenceMBResult)
			{
				$entity = $res->entity;
				$value = number_format($res->amountOut, 2);
				$reference = $res->reference;
				$error = "";
				return true;
			}
			else
			{
				$error = $res->error;
				return false;
			}
		
		}
		catch (Exception $e){
			$error = $e->getMessage();
			return false;
		}
		
   }
   
 

?>
