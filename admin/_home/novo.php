<?php
include('../../_connect.php');
include('../funcao/upload_img.php');
session_start();

$id = $_POST["id"];
$titulo_pt = mysqli_real_escape_string($lnk,trim($_POST["titulo_pt"]));
$titulo_en = mysqli_real_escape_string($lnk,trim($_POST["titulo_en"]));
//$titulo = str_replace("'", "′", $titulo);
//$titulo = str_replace("\"", "“", $titulo);


//echo "$id \n $titulo \n $img";

if($id || $titulo_pt || $titulo_en || $_FILES['imagem']['name']){
	if($id){
		mysqli_query($lnk,"UPDATE home SET titulo_pt='$titulo_pt', titulo_en='$titulo_en' WHERE id='$id'");
	}
	else{
		mysqli_query($lnk, "INSERT INTO home(titulo_pt,titulo_en) VALUES ('$titulo_pt','$titulo_en')");
		$id = mysqli_insert_id($lnk);
	}

	if($_FILES['imagem']['name']){
		$arquivo_tmp = $_FILES['imagem']['tmp_name'];
		$arquivo_name = $_FILES['imagem']['name'];
		$extensao = strrchr($arquivo_name, '.');
		$extensao = strtolower($extensao);
		if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
			# apagar antiga
			$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM home WHERE id = '$id'"));
			$img = $linha['img'];
			if($img && file_exists('../..'.$img)){ unlink('../..'.$img); }

			$novoNome = $id;
			if(strlen($novoNome)==3){$novoNome = "0".$novoNome;}
			if(strlen($novoNome)==2){$novoNome = "00".$novoNome;}
			if(strlen($novoNome)==1){$novoNome = "000".$novoNome;}
			$novoNome = $novoNome.$extensao;

			$destino = '../../img/home/'.$novoNome;
			$nome_imagem = '/img/home/'.$novoNome;

			upload_full($arquivo_tmp, $destino, $extensao);
			mysqli_query($lnk,"UPDATE home SET img='$nome_imagem' WHERE id='$id'");
			//if(@move_uploaded_file($arquivo_tmp, $destino)){mysqli_query($lnk,"UPDATE home SET img='$nome_imagem' WHERE id='$id'");}
		}
	}
}
echo $id;
?>