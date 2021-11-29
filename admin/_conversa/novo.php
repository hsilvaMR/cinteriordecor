<?php
include('../../_connect.php');
include('../funcao/upload_img.php');
session_start();



/*$id_encomenda = isset($_POST['id_encomenda']) ? $_POST['id_encomenda'] : '';
$assunto = isset($_POST['assunto']) ? $_POST['assunto'] : '';
$mensagem = isset($_POST['mensagem']) ? $_POST['mensagem'] : '';*/

$id_encomenda = mysqli_real_escape_string($lnk,trim($_POST["id_encomenda"]));
$assunto = mysqli_real_escape_string($lnk,trim($_POST["assunto"]));
$mensagem = mysqli_real_escape_string($lnk,trim($_POST["mensagem"]));


$retorna['aviso']=''; $aviso='';



$existe = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM venda_conversa WHERE id_venda = '$id_encomenda'"));
$data = date('Y-m-d');

if(!$existe){
	mysqli_query($lnk,"INSERT INTO venda_conversa (id_venda, assunto, data) VALUES ('$id_encomenda', '$mensagem', '$data')");
	$id = mysqli_insert_id($lnk);
}else{
	$id = $existe['id'];
}

$respondido = 'BO';
mysqli_query($lnk,"INSERT INTO venda_conversa_msg (id_venda_conversa, mensagem, data, respondido) VALUES ('$id', '$mensagem', '$data', '$respondido')"); 
$id_msg = mysqli_insert_id($lnk);

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
				$nome_imagem = "/img/documentos_chat/".$novoNome.$extensao;

				$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM venda_conversa_ficheiro WHERE ficheiro='$nome_imagem'"));
				if(!$numero){$nomeExiste='nao';}
			}
			$destino = '../..'.$nome_imagem;
			upload_big($arquivo_tmp, $destino, $extensao);
			
			
			mysqli_query($lnk,"INSERT INTO venda_conversa_ficheiro(id_msg,ficheiro,nome) VALUES ('$id_msg','$nome_imagem','$novoNome')");

			/*if(@move_uploaded_file($arquivo_tmp, $destino)){
				$capaExiste=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM projeto_gal WHERE id_projeto='$id' AND capa='1'"));
				if($capaExiste){ $capa=0; }else{ $capa=1; }
				mysqli_query($lnk,"INSERT INTO projeto_gal(id_projeto,img,capa,online) VALUES ('$id','$nome_imagem','$capa','1')");
			}*/
		}
	}
}


//Usar array para varios parametros, usar a chave! $retorna['aviso'] = $email;

?>