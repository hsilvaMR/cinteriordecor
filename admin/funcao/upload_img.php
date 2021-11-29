<?
//IMAGENS
function upload_full($arquivo_tmp, $destino, $extensao)
{
    if(strstr('.jpg;.jpeg', $extensao)){ $imgem = imagecreatefromjpeg($arquivo_tmp);}
    if(strstr('.png', $extensao)){ $imgem = imagecreatefrompng($arquivo_tmp);}
    if(strstr('.gif', $extensao)){ $imgem = imagecreatefromgif($arquivo_tmp);}

    $x = imagesx($imgem);//Largura atual
    $y = imagesy($imgem);//Altura atual
    if($x > 2000){$largura = 2000;}else{$largura = $x;}
    $altura = ($largura * $y) / $x;
    $nova = imagecreatetruecolor($largura, $altura);//Plano de fundo

    //Tirar fundo PNG
    imagesavealpha($nova, true);
    $cor_fundo = imagecolorallocatealpha($nova, 0, 0, 0, 127);
    imagefill($nova, 0, 0, $cor_fundo);

    imagecopyresampled($nova, $imgem, 0, 0, 0, 0, $largura, $altura, $x, $y);
    if(strstr('.jpg;.jpeg', $extensao)){ imagejpeg($nova, $destino); }
    if(strstr('.png', $extensao)){ imagepng($nova, $destino); }
    if(strstr('.gif', $extensao)){ imagegif($nova, $destino); }
    imagedestroy($imgem);
    imagedestroy($nova);
    return('TM');
}

function upload_big($arquivo_tmp, $destino, $extensao)
{
    if(strstr('.jpg;.jpeg', $extensao)){ $imgem = imagecreatefromjpeg($arquivo_tmp);}
    if(strstr('.png', $extensao)){ $imgem = imagecreatefrompng($arquivo_tmp);}
    if(strstr('.gif', $extensao)){ $imgem = imagecreatefromgif($arquivo_tmp);}

    $x = imagesx($imgem);//Largura atual
    $y = imagesy($imgem);//Altura atual
    if($x > $y){
        if($x > 1000){$largura = 1000;}else{$largura = $x;}
        $altura = ($largura * $y) / $x;
    }else{
        if($y > 1000){$altura = 1000;}else{$altura = $y;}
        $largura = ($altura * $x) / $y;
    }
    $nova = imagecreatetruecolor($largura, $altura);//Plano de fundo

    //Tirar fundo PNG
    imagesavealpha($nova, true);
    $cor_fundo = imagecolorallocatealpha($nova, 0, 0, 0, 127);
    imagefill($nova, 0, 0, $cor_fundo);

    imagecopyresampled($nova, $imgem, 0, 0, 0, 0, $largura, $altura, $x, $y);
    if(strstr('.jpg;.jpeg', $extensao)){ imagejpeg($nova, $destino); }
    if(strstr('.png', $extensao)){ imagepng($nova, $destino); }
    if(strstr('.gif', $extensao)){ imagegif($nova, $destino); }
    imagedestroy($imgem);
    imagedestroy($nova);
    return('TM');
}

function upload_small($arquivo_tmp, $destino, $extensao)
{
    if(strstr('.jpg;.jpeg', $extensao)){ $imgem = imagecreatefromjpeg($arquivo_tmp);}
    if(strstr('.png', $extensao)){ $imgem = imagecreatefrompng($arquivo_tmp);}
    if(strstr('.gif', $extensao)){ $imgem = imagecreatefromgif($arquivo_tmp);}

    $x = imagesx($imgem);//Largura atual
    $y = imagesy($imgem);//Altura atual
    if($x < $y){
        if($x > 300){$largura = 300;}else{$largura = $x;}
        $altura = ($largura * $y) / $x;
    }else{
        if($y > 300){$altura = 300;}else{$altura = $y;}
        $largura = ($altura * $x) / $y;
    }
    $nova = imagecreatetruecolor($largura, $altura);//Plano de fundo

    //Tirar fundo PNG
    imagesavealpha($nova, true);
    $cor_fundo = imagecolorallocatealpha($nova, 0, 0, 0, 127);
    imagefill($nova, 0, 0, $cor_fundo);

    imagecopyresampled($nova, $imgem, 0, 0, 0, 0, $largura, $altura, $x, $y);
    if(strstr('.jpg;.jpeg', $extensao)){ imagejpeg($nova, $destino); }
    if(strstr('.png', $extensao)){ imagepng($nova, $destino); }
    if(strstr('.gif', $extensao)){ imagegif($nova, $destino); }
    imagedestroy($imgem);
    imagedestroy($nova);
    return('TM');
}

function upload_cover($arquivo_tmp, $destino, $extensao, $pixels)
{
    if(strstr('.jpg;.jpeg', $extensao)){ $imgem = imagecreatefromjpeg($arquivo_tmp);}
    if(strstr('.png', $extensao)){ $imgem = imagecreatefrompng($arquivo_tmp);}
    if(strstr('.gif', $extensao)){ $imgem = imagecreatefromgif($arquivo_tmp);}

    $x = imagesx($imgem);//Largura atual
    $y = imagesy($imgem);//Altura atual
    if($x < $y){
        if($x > $pixels){$largura = $pixels;}else{$largura = $x;}
        $altura = ($largura * $y) / $x;
    }else{
        if($y > $pixels){$altura = $pixels;}else{$altura = $y;}
        $largura = ($altura * $x) / $y;
    }
    $nova = imagecreatetruecolor($largura, $altura);//Plano de fundo

    //Tirar fundo PNG
    imagesavealpha($nova, true);
    $cor_fundo = imagecolorallocatealpha($nova, 0, 0, 0, 127);
    imagefill($nova, 0, 0, $cor_fundo);

    imagecopyresampled($nova, $imgem, 0, 0, 0, 0, $largura, $altura, $x, $y);
    if(strstr('.jpg;.jpeg', $extensao)){ imagejpeg($nova, $destino); }
    if(strstr('.png', $extensao)){ imagepng($nova, $destino); }
    if(strstr('.gif', $extensao)){ imagegif($nova, $destino); }
    imagedestroy($imgem);
    imagedestroy($nova);
    return('TM');
}

function upload_contain($arquivo_tmp, $destino, $extensao, $pixels)
{
    if(strstr('.jpg;.jpeg', $extensao)){ $imgem = imagecreatefromjpeg($arquivo_tmp);}
    if(strstr('.png', $extensao)){ $imgem = imagecreatefrompng($arquivo_tmp);}
    if(strstr('.gif', $extensao)){ $imgem = imagecreatefromgif($arquivo_tmp);}

    $x = imagesx($imgem);//Largura atual
    $y = imagesy($imgem);//Altura atual
    if($x > $y){
        if($x > $pixels){$largura = $pixels;}else{$largura = $x;}
        $altura = ($largura * $y) / $x;
    }else{
        if($y > $pixels){$altura = $pixels;}else{$altura = $y;}
        $largura = ($altura * $x) / $y;
    }
    $nova = imagecreatetruecolor($largura, $altura);//Plano de fundo

    //Tirar fundo PNG
    imagesavealpha($nova, true);
    $cor_fundo = imagecolorallocatealpha($nova, 0, 0, 0, 127);
    imagefill($nova, 0, 0, $cor_fundo);

    imagecopyresampled($nova, $imgem, 0, 0, 0, 0, $largura, $altura, $x, $y);
    if(strstr('.jpg;.jpeg', $extensao)){ imagejpeg($nova, $destino); }
    if(strstr('.png', $extensao)){ imagepng($nova, $destino); }
    if(strstr('.gif', $extensao)){ imagegif($nova, $destino); }
    imagedestroy($imgem);
    imagedestroy($nova);
    return('TM');
}
//list($width, $height) = getimagesize($file);
//Criar marca d'água
/*$marca = imagecreatefrompng('imagens/marca.png');
$marcax = imagesx($marca);
$marcay = imagesy($marca);
$localx = $largura-110;
$localy = $altura-60;
//centro
//$localx = ($largura-100)/2;
//$localy = ($altura-50)/2;
imagecopyresampled($nova, $marca, $localx, $localy, 0, 0, 100, 50, $marcax, $marcay);*/
?>