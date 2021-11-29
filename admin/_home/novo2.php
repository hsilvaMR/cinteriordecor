<?php
include('../../_connect.php');
session_start();

$id = $_POST["id"];
$titulo = $_POST["titulo"];

//echo "$id \n $titulo \n $img";

if($id || $titulo || $_FILES['imagem']['name']){
	if($id){
		mysqli_query($lnk,"UPDATE home SET titulo='$titulo' WHERE id='$id'");
	}
	else{
		mysqli_query($lnk, "INSERT INTO home(titulo) VALUES ('$titulo')");
		$id = mysqli_insert_id($lnk);
	}

	if($_FILES['imagem']['name']){
		$arquivo_tmp = $_FILES['imagem']['tmp_name'];
		$arquivo_name = $_FILES['imagem']['name'];
		$extensao = strrchr($arquivo_name, '.');
		$extensao = strtolower($extensao);
		if(strstr('.jpg;.jpeg;.png', $extensao)){
			# apagar antiga
			$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM home WHERE id = '$id'"));
			$img = $linha['img'];
			if($img && file_exists('../..'.$img)){ unlink('../..'.$img); }

			$novoNome = $id;
			if(strlen($novoNome)<2){$novoNome = "0".$novoNome;}
			$novoNome = $novoNome.".jpg";

			//$novoNome = md5(microtime()).$extensao;
			//$novoNome = 'TM'.substr($novoNome, 24);
			$destino = '../../img/home/'.$novoNome;
			$nome_imagem = '/img/home/'.$novoNome;
			if(@move_uploaded_file($arquivo_tmp, $destino)){mysqli_query($lnk,"UPDATE home SET img='$nome_imagem' WHERE id='$id'");}
		}
	}
}
echo $id;
?>