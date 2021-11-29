<?php

//error_reporting(E_ALL);
//error_reporting(0);
include('../_connect.php');

  function soap_v4(){
     
   
    try{
        
           global $lnk;
        
           $id = isset($_POST['id']) ? $_POST['id'] : '';
           $tracking = isset($_POST['tracking']) ? $_POST['tracking'] : '';
           
           extract(mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM venda WHERE id='$id' AND tracking='$tracking'")));
           
           $ref_hora = str_replace(":", "", $hora);
           $track = 'CI'.$id.'IN'.$ref_hora;
   
            $options = array(
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
                'cache_wsdl' => WSDL_CACHE_NONE,
                'soap_version' => SOAP_1_1,
                'encoding' => 'UTF-8',
                'exceptions'=>true
            );
            
           $url ='https://ws.hipay.com/soap/payment-v2?wsdl';
           $client = new SoapClient($url,$options);
           
          $locale = ($LANG=='pt') ? 'pt_PT' : 'en_GB' ;
          $result = $client->generate(array('parameters'=>array(
                'wsLogin' => 'a25073f3bb3c282b7b0d366eb52e09f6', //test -> 61435fa262a9b03181457dd7bf5bd4d1
                'wsPassword' => '363ec283622b27ef4aa8cbf092472d1e', //test -> f426f53ff0a8a64fc03075abd401e8be
                'websiteId' => '291034', //teste -> 376087
                'categoryId' => '570', //teste -> 653
                #'urlLogo' => 'http://www.ci-interiordecor.com/img/logo_frase.svg',
                'description' => $tracking,
                'merchantReference' => $seguranca,
                #'merchantComment' => 'Com (#'.$id.')', //comentário dos comerciantes relativa à ordem.
                'currency' => 'EUR',
                'amount' => $total,
                'rating' => 'ALL',
                'locale' => $locale, //pt_PT, en_GB, fr_FR, es_ES, it_IT
                'customerIpAddress' => '46.182.41.35', //O endereço IP do seu cliente para fazer a compra
                'manualCapture' => '0',
                'executionDate' => date('Y-m-dTH:i:s'), //'executionDate' => '2014-11-18T11:01:55', date('Y-m-dTH:i:s')
                'customerEmail' => $email, //email cliente
                #'emailCallback' => 'tiago_mendes@live.com.pt', //E-mail usado por HiPay Wallet para notificações pós-operatórias.
                'urlCallback' => 'http://www.ci-interiordecor.com/processar/'.$id, //URL usado pela Hipay para enviar-lhe informações, a fim de atualizar o seu banco de dados.
                'urlAccept' => 'http://www.ci-interiordecor.com/sucesso/'.$tracking, //A URL para retornar seu cliente uma vez que o processo de pagamento é concluído com êxito.
                'urlCancel' => 'http://www.ci-interiordecor.com/cancelar/'.$id.'/'.$seguranca, //'http://www.ci-interiordecor.com/carrinho',
            )));
           
          // $response = $client-> generateResponse();
           $genResult = $result->generateResult;
           $retorna['url']= $genResult->redirectUrl;
           $retorna['result']= $genResult;
           //$retorna['id']= $id;
          // $retorna['seguranca']= $seguranca;
         //  $retorna['total']= $total;
           
           echo json_encode($retorna);
          
          // var_dump( $response);
    }
      catch(Exception $e) {
          
         echo $e->getMessage();
         
          
     }
      
  }
  function soap_v3(){
      
    $id = $_POST['id'];
    $tracking =$_POST['tracking'];
    //$retorna['result']="-1";
    
    $url ='https://ws.hipay.com/soap/payment-v2?wsdl';
    $options = array(
                
        'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
        'cache_wsdl' => WSDL_CACHE_NONE,
        'soap_version' => SOAP_1_1,
        'encoding' => 'UTF-8',
        'exceptions'=>true
    );
    
    $client = new SoapClient($url,$options);
    
    /*$response = $client->generateResponse(
        
            array("generateResult")
    )*/
    
    echo  $client->generateResult;
    //var_dump($client->generateResult);    
    //var_dump($client->__getTypes());
 
  }

   function soap_v2(){
      
    //global $lnk;
    // ID:  291034
   
    $id = $_POST['id'];
    $tracking =$_POST['tracking'];
    $retorna['result']="-1";
    
     $locale = ($LANG=='pt') ? 'pt_PT' : 'en_GB' ;
    
    
    if($id!="" && $tracking!=""){
        
       // extract(mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM venda WHERE id='$id' AND tracking='$tracking'")));
       // $ref_hora = str_replace(":", "", $hora);
        //$track = 'CI'.$id.'IN'.$ref_hora;
        
        $options = array(
            'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'soap_version' => SOAP_1_1,
            'encoding' => 'UTF-8',
            'exceptions'=>true,
        );
        
         
        try {
            
            $url ='https://ws.hipay.com/soap/payment-v2?wsdl';
            $client = new SoapClient($url, $options);
    	    $data = $client->generate(array('parameters'=>array(
    	        
    	        'wsLogin' => 'a25073f3bb3c282b7b0d366eb52e09f6', 
                'wsPassword' => '363ec283622b27ef4aa8cbf092472d1e', 
                'websiteId' => '291034', 
                'categoryId' => '570', 
                'description' => $tracking,
                'locale' => $locale,
    	     )));  
    	     
    	   // $genResult = $data->generateResult;
    	    $retorna['result']=$data;
    	
        }
        catch(Exception $e) {
            
    	     die($e->getMessage());
    	    // $retorna['error']=$e->getMessage();
    	
        }
        
    }
    
    else{
        
         $retorna['result']="nao entrou";
    }
    
    
    echo json_encode($retorna);
   
       
   }


  function soap_v1(){
      
    global $lnk;
      
    $id = $_POST['id'];
    $tracking =$_POST['tracking'];
    
    extract(mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM venda WHERE id='$id' AND tracking='$tracking'")));

    $ref_hora = str_replace(":", "", $hora);
    $track = 'CI'.$id.'IN'.$ref_hora;
  
    $locale = ($LANG=='pt') ? 'pt_PT' : 'en_GB';
    
    $result = $client->generate(array('parameters'=>array(
    'wsLogin' => 'a25073f3bb3c282b7b0d366eb52e09f6', //test -> 61435fa262a9b03181457dd7bf5bd4d1
    'wsPassword' => '363ec283622b27ef4aa8cbf092472d1e', //test -> f426f53ff0a8a64fc03075abd401e8be
    'websiteId' => '291034', //teste -> 376087
    'categoryId' => '570', //teste -> 653
    #'urlLogo' => 'http://www.ci-interiordecor.com/img/logo_frase.svg',
    'description' => $tracking,
    'merchantReference' => $seguranca,
    #'merchantComment' => 'Com (#'.$id.')', //comentário dos comerciantes relativa à ordem.
    'currency' => 'EUR',
    'amount' => $total,
    'rating' => 'ALL',
    'locale' => $locale, //pt_PT, en_GB, fr_FR, es_ES, it_IT
    'customerIpAddress' => '46.182.41.35', //O endereço IP do seu cliente para fazer a compra
    'manualCapture' => '0',
    'executionDate' => date('Y-m-dTH:i:s'), //'executionDate' => '2014-11-18T11:01:55', date('Y-m-dTH:i:s')
    'customerEmail' => $email, //email cliente
     #'emailCallback' => 'tiago_mendes@live.com.pt', //E-mail usado por HiPay Wallet para notificações pós-operatórias.
    'urlCallback' => 'http://www.ci-interiordecor.com/processar/'.$id, //URL usado pela Hipay para enviar-lhe informações, a fim de atualizar o seu banco de dados.
    'urlAccept' => 'http://www.ci-interiordecor.com/sucesso/'.$tracking, //A URL para retornar seu cliente uma vez que o processo de pagamento é concluído com êxito.
    'urlCancel' => 'http://www.ci-interiordecor.com/cancelar/'.$id.'/'.$seguranca, //'http://www.ci-interiordecor.com/carrinho',
    ))); 
    
    $retorna['id']= $id;
    
    /*$genResult = $result->generateResult;
    //$genMessagem = $result->getMessage();*/
    
    $retorna['url']= $genResult->redirectUrl;
    $retorna['result']=$genResult;
    $retorna['message']= "test_mcode";
    $retorna['id']= $id;
    
    echo json_encode($retorna);
      
  }
  
  
function soap(){
  
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $tracking = isset($_POST['tracking']) ? $_POST['tracking'] : '';
    //$retorna['alerta'] = "$seguranca";
    extract(mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM venda WHERE id='$id' AND tracking='$tracking'")));
    $ref_hora = str_replace(":", "", $hora);
    $track = 'CI'.$id.'IN'.$ref_hora;

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
    $locale = ($LANG=='pt') ? 'pt_PT' : 'en_GB' ;
    // STEP 3 : Soap call on confirm method of manual-capture webservice
    $result = $client->generate(array('parameters'=>array(
        'wsLogin' => 'a25073f3bb3c282b7b0d366eb52e09f6', //test -> 61435fa262a9b03181457dd7bf5bd4d1
        'wsPassword' => '363ec283622b27ef4aa8cbf092472d1e', //test -> f426f53ff0a8a64fc03075abd401e8be
        'websiteId' => '291034', //teste -> 376087
        'categoryId' => '570', //teste -> 653
        #'urlLogo' => 'http://www.ci-interiordecor.com/img/logo_frase.svg',
        'description' => $tracking,
        'merchantReference' => $seguranca,
        #'merchantComment' => 'Com (#'.$id.')', //comentário dos comerciantes relativa à ordem.
        'currency' => 'EUR',
        'amount' => $total,
        'rating' => 'ALL',
        'locale' => $locale, //pt_PT, en_GB, fr_FR, es_ES, it_IT
        'customerIpAddress' => '46.182.41.35', //O endereço IP do seu cliente para fazer a compra
        'manualCapture' => '0',
        'executionDate' => date('Y-m-dTH:i:s'), //'executionDate' => '2014-11-18T11:01:55', date('Y-m-dTH:i:s')
        'customerEmail' => $email, //email cliente
        #'emailCallback' => 'tiago_mendes@live.com.pt', //E-mail usado por HiPay Wallet para notificações pós-operatórias.
        'urlCallback' => 'http://www.ci-interiordecor.com/processar/'.$id, //URL usado pela Hipay para enviar-lhe informações, a fim de atualizar o seu banco de dados.
        'urlAccept' => 'http://www.ci-interiordecor.com/sucesso/'.$tracking, //A URL para retornar seu cliente uma vez que o processo de pagamento é concluído com êxito.
        'urlCancel' => 'http://www.ci-interiordecor.com/cancelar/'.$id.'/'.$seguranca, //'http://www.ci-interiordecor.com/carrinho',
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

}

function testCall(){
  
    $retorna['status']= "-1";
    
    $id = $_POST['id'];
    $tracking =$_POST['tracking'];
     
    if($id!="" && $tracking!=""){
        
        $retorna['status']= "https://www.ci-interiordecor.com";
    } 
    
    else{
        
        $retorna['error']= "error";
    }
    
    echo json_encode($retorna); 
 
}
if(isset($_POST['call'])){
    
   //testCall();  
  //soap_v1();
   //soap_v2();
   //soap_v3();
   soap_v4();
}
 

?>