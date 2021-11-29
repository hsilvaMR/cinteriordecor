<?php
include('../../_connect.php');
include('../funcao/upload_img.php');
session_start();

$id = $_POST["id"];

//echo "$id \n $img";

if($_FILES['imagem']['name']){
	if(!$id){
		mysqli_query($lnk, "INSERT INTO essencia(online) VALUES ('1')");
		$id = mysqli_insert_id($lnk);
	}

	if($_FILES['imagem']['name']){
		$arquivo_tmp = $_FILES['imagem']['tmp_name'];
		$arquivo_name = $_FILES['imagem']['name'];
		$extensao = strrchr($arquivo_name, '.');
		$extensao = strtolower($extensao);
		if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
			# apagar antiga
			$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM essencia WHERE id = '$id'"));
			$img = $linha['img'];
			if($img && file_exists('../..'.$img)){ unlink('../..'.$img); }

			$novoNome = $id;
			if(strlen($novoNome)==3){$novoNome = "0".$novoNome;}
			if(strlen($novoNome)==2){$novoNome = "00".$novoNome;}
			if(strlen($novoNome)==1){$novoNome = "000".$novoNome;}
			$novoNome = $novoNome.$extensao;

			$destino = '../../img/essencia/'.$novoNome;
			$nome_imagem = '/img/essencia/'.$novoNome;

			upload_big($arquivo_tmp, $destino, $extensao);
			mysqli_query($lnk,"UPDATE essencia SET img='$nome_imagem' WHERE id='$id'");
			//if(@move_uploaded_file($arquivo_tmp, $destino)){mysqli_query($lnk,"UPDATE essencia SET img='$nome_imagem' WHERE id='$id'");}
		}
	}
}
echo $id;
?>