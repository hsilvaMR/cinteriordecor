<?php
include('../../_connect.php');
include('../funcao/upload_img.php');
session_start();

$id = $_POST["id"];
$referencia = mysqli_real_escape_string($lnk,trim($_POST["referencia"]));
$produto_pt = mysqli_real_escape_string($lnk,trim($_POST["produto_pt"]));
$produto_en = mysqli_real_escape_string($lnk,trim($_POST["produto_en"]));
$id_categoria = $_POST["id_categoria"];
$dimensoes = mysqli_real_escape_string($lnk,trim($_POST["dimensoes"]));
$descricao_pt = mysqli_real_escape_string($lnk,trim($_POST["descricao_pt"]));
$descricao_en = mysqli_real_escape_string($lnk,trim($_POST["descricao_en"]));
$quantidade = trim($_POST["quantidade"]);
$produzir = isset($_POST["produzir"]) ? $_POST["produzir"] : '';
$preco = trim($_POST["preco"]);
$desconto = trim($_POST["desconto"]);
$saldo = isset($_POST["saldo"]) ? $_POST["saldo"] : '';
$comprimento = str_replace(",", ".", trim($_POST["comprimento"]));
$largura = str_replace(",", ".", trim($_POST["largura"]));
$altura = str_replace(",", ".", trim($_POST["altura"]));
$peso = str_replace(",", ".", trim($_POST["peso"]));
$orcamento = isset($_POST["orcamento"]) ? $_POST["orcamento"] : '';


if($id || $referencia || $produto_pt || $produto_en || $_FILES['imagem']['name'][0]){
	if($id){
		mysqli_query($lnk,"UPDATE produto SET referencia='$referencia', produto_pt='$produto_pt', produto_en='$produto_en', id_produto_cat='$id_categoria', dimensoes='$dimensoes', descricao_pt='$descricao_pt', descricao_en='$descricao_en', quantidade='$quantidade', produzir='$produzir', preco='$preco', desconto='$desconto', saldo='$saldo', comprimento='$comprimento', largura='$largura', altura='$altura', peso='$peso', orcamento='$orcamento' WHERE id='$id'");
	}
	else{
		mysqli_query($lnk, "INSERT INTO produto(referencia, produto_pt, produto_en, id_produto_cat, dimensoes, descricao_pt, descricao_en, quantidade, produzir, preco, desconto, saldo, comprimento, largura, altura, peso, orcamento) 
			VALUES ('$referencia', '$produto_pt', '$produto_en','$id_categoria', '$dimensoes', '$descricao_pt', '$descricao_en', '$quantidade', '$produzir', '$preco', '$desconto', '$saldo', '$comprimento', '$largura', '$altura', '$peso', '$orcamento')");
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
					$nome_imagem = "/img/produtos/".$novoNome.$extensao;

					$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM produto_gal WHERE img='$nome_imagem'"));
					if(!$numero){$nomeExiste='nao';}
				}
				$destino = '../..'.$nome_imagem;
				upload_big($arquivo_tmp, $destino, $extensao);
				mysqli_query($lnk,"INSERT INTO produto_gal(id_produto,img,online) VALUES ('$id','$nome_imagem','1')");

				//if(@move_uploaded_file($arquivo_tmp, $destino)){ mysqli_query($lnk,"INSERT INTO produto_gal(id_produto,img,online) VALUES ('$id','$nome_imagem','1')"); }
			}
		}
	}
}
echo $id;
?>