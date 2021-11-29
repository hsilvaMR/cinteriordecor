<?php
include('../../_connect.php');
include('../funcao/upload_img.php');
session_start();

$id = $_POST["id"];
$titulo_pt = mysqli_real_escape_string($lnk,trim($_POST["titulo_pt"]));
$titulo_en = mysqli_real_escape_string($lnk,trim($_POST["titulo_en"]));
$nome_pt = mysqli_real_escape_string($lnk,trim($_POST["nome_pt"]));
$nome_en = mysqli_real_escape_string($lnk,trim($_POST["nome_en"]));
$texto_pt = mysqli_real_escape_string($lnk,trim($_POST["texto_pt"]));
$texto_en = mysqli_real_escape_string($lnk,trim($_POST["texto_en"]));
//$texto = str_replace("'", "′", $texto);
//$texto = str_replace("\"", "“", $texto);

//echo "$id \n $titulo \n $nome";

if($id || $titulo_pt || $titulo_en || $nome_pt || $nome_en || $texto_pt || $texto_en || $_FILES['imagem']['name'][0]){
	if($id){
		mysqli_query($lnk,"UPDATE projeto SET titulo_pt='$titulo_pt', titulo_en='$titulo_en', nome_pt='$nome_pt', nome_en='$nome_en', texto_pt='$texto_pt', texto_en='$texto_en' WHERE id='$id'");
	}
	else{
		mysqli_query($lnk, "INSERT INTO projeto(titulo_pt,titulo_en,nome_pt,nome_en,texto_pt,texto_en) VALUES ('$titulo_pt','$titulo_en','$nome_pt','$nome_en','$texto_pt','$texto_en')");
		$id = mysqli_insert_id($lnk);
	}

	if($_FILES['imagem']['name'][0]){
		$contar = count($_FILES['imagem']['name']);
		for($i=0; $i<$contar; $i++){
			$arquivo_tmp = $_FILES['imagem']['tmp_name'][$i];
			$arquivo_name = $_FILES['imagem']['name'][$i];
			$extensao = strrchr($arquivo_name, '.');
			$extensao = strtolower($extensao);
			if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
				$novoNome = $id."000";
				$nomeExiste = 'sim';
				while($nomeExiste=='sim'){
					$novoNome++;
					if(strlen($novoNome)==6){$novoNome = "0".$novoNome;}
					if(strlen($novoNome)==5){$novoNome = "00".$novoNome;}
					if(strlen($novoNome)==4){$novoNome = "000".$novoNome;}
					$nome_imagem = "/img/projectos/".$novoNome.$extensao;

					$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM projeto_gal WHERE img='$nome_imagem'"));
					if(!$numero){$nomeExiste='nao';}
				}
				$destino = '../..'.$nome_imagem;
				upload_big($arquivo_tmp, $destino, $extensao);
				
				$capaExiste=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM projeto_gal WHERE id_projeto='$id' AND capa='1'"));
				if($capaExiste){ $capa=0; }else{ $capa=1; }
				mysqli_query($lnk,"INSERT INTO projeto_gal(id_projeto,img,capa,online) VALUES ('$id','$nome_imagem','$capa','1')");

				/*if(@move_uploaded_file($arquivo_tmp, $destino)){
					$capaExiste=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM projeto_gal WHERE id_projeto='$id' AND capa='1'"));
					if($capaExiste){ $capa=0; }else{ $capa=1; }
					mysqli_query($lnk,"INSERT INTO projeto_gal(id_projeto,img,capa,online) VALUES ('$id','$nome_imagem','$capa','1')");
				}*/
			}
		}
	}
}
echo $id;
?>