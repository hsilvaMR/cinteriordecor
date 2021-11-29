<?php
include('../../_connect.php');
include('../funcao/upload_img.php');
session_start();

$id = $_POST["id"];
$nome = trim($_POST["nome"]);
$nome = str_replace("'", "′", $nome);
$nome = str_replace("\"", "“", $nome);
$url = $_POST["url"];
$inicio = $_POST["inicio"];
$fim = $_POST["fim"];
$countdown = trim($_POST["countdown"]);

//echo "$id \n $titulo \n $img";

if($id || $nome || $_FILES['tlm']['name'] || $_FILES['pc']['name']){
	if($id){
		mysqli_query($lnk,"UPDATE banner SET nome='$nome',url='$url',inicio='$inicio',fim='$fim',countdown='$countdown' WHERE id='$id'");
	}
	else{
		mysqli_query($lnk, "INSERT INTO banner(nome,url,inicio,fim,ordem,countdown) VALUES ('$nome','$url','$inicio','$fim','0','$countdown')");
		$id = mysqli_insert_id($lnk);
	}

	if($_FILES['tlm']['name']){
		$arquivo_tmp = $_FILES['tlm']['tmp_name'];
		$arquivo_name = $_FILES['tlm']['name'];
		$extensao = strrchr($arquivo_name, '.');
		$extensao = strtolower($extensao);
		if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
			# apagar antiga
			$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM banner WHERE id = '$id'"));
			$img = $linha['tlm'];
			if($img && file_exists('../..'.$img)){ unlink('../..'.$img); }

			$novoNome = $id;
			if(strlen($novoNome)==3){$novoNome = "0".$novoNome;}
			if(strlen($novoNome)==2){$novoNome = "00".$novoNome;}
			if(strlen($novoNome)==1){$novoNome = "000".$novoNome;}
			$novoNome = $novoNome.'-tlm'.$extensao;

			$destino = '../../img/banner/'.$novoNome;
			$nome_imagem = '/img/banner/'.$novoNome;

			if($extensao == '.gif'){
				if(@move_uploaded_file($arquivo_tmp, $destino)){ mysqli_query($lnk,"UPDATE banner SET tlm='$nome_imagem' WHERE id='$id'"); }
			}else{
				upload_big($arquivo_tmp, $destino, $extensao);
				mysqli_query($lnk,"UPDATE banner SET tlm='$nome_imagem' WHERE id='$id'");
			}			
		}
	}
	if($_FILES['pc']['name']){
		$arquivo_tmp = $_FILES['pc']['tmp_name'];
		$arquivo_name = $_FILES['pc']['name'];
		$extensao = strrchr($arquivo_name, '.');
		$extensao = strtolower($extensao);
		if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
			# apagar antiga
			$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM banner WHERE id = '$id'"));
			$img = $linha['pc'];
			if($img && file_exists('../..'.$img)){ unlink('../..'.$img); }

			$novoNome = $id;
			if(strlen($novoNome)==3){$novoNome = "0".$novoNome;}
			if(strlen($novoNome)==2){$novoNome = "00".$novoNome;}
			if(strlen($novoNome)==1){$novoNome = "000".$novoNome;}
			$novoNome = $novoNome.'-pc'.$extensao;

			$destino = '../../img/banner/'.$novoNome;
			$nome_imagem = '/img/banner/'.$novoNome;

			if($extensao == '.gif'){
				if(@move_uploaded_file($arquivo_tmp, $destino)){ mysqli_query($lnk,"UPDATE banner SET pc='$nome_imagem' WHERE id='$id'"); }
			}else{
				upload_big($arquivo_tmp, $destino, $extensao);
				mysqli_query($lnk,"UPDATE banner SET pc='$nome_imagem' WHERE id='$id'");
			}
		}
	}
}
echo $id;
?>