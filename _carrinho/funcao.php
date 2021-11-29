<?php
function geraSenha($tamanho)
{
	$simbolos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvxz';
	$retorno = '';
	$caracteres = '';
	$caracteres .= $simbolos;
	$len = strlen($caracteres);
	for ($n = 1; $n <= $tamanho; $n++)
	{
		$rand = mt_rand(1, $len);
		$retorno .= $caracteres[$rand - 1];
	}
	return $retorno;
}
/*$senha = geraSenha2(10, true, true, true);
function geraSenha2($tamanho, $maiusculas, $numeros, $simbolos)
{
	 $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	 $num = '1234567890';
	 $simb = '!*-|\#$/()=?»«}][{§€£';
	 $retorno = '';
	 $caracteres = '';
	 $caracteres .= $lmin;
	 if ($maiusculas)
		$caracteres .= $lmai;
	 if ($numeros)
		$caracteres .= $num;
	 if ($simbolos)
		 $caracteres .= $simb;
	 $len = strlen($caracteres);
	 for ($n = 1; $n <= $tamanho; $n++)
	 {
		$rand = mt_rand(1, $len);
		$retorno .= $caracteres[$rand - 1];
	 }
	 return $retorno;
}*/
?>