<?
	if ($_COOKIE["USER"]) {
		$id = $_COOKIE["USER"];

		$user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id'"));
	}
	
?>

<p onClick="irConta(<?echo $id;?>);" class="div_conta_menu_nome cursor-pointer"><? echo $user['nome']?></p>
<p class="div_conta_menu_email"><? echo $user['email']?></p>

<? 
	$div_conta_morada_menu = "<div class=\"menu_height\"></div>";
	if($sepConta == 'conta') {
		if($LANG=='pt'){$lg="Adicionar Morada";} 
		if($LANG=='en'){$lg="Add Address";}
		if($user['estado'] == 'ativo'){ $href = "href=\"/nova-morada\"";}
		$div_conta_morada_menu = "<a $href><div class=\"div_conta_morada\"><span>+ $lg</span></div></a>";
	}	
?>

<?echo $div_conta_morada_menu ?>

<div class="textl margin-bottom40">
	<a <? if($user['estado'] == 'ativo'){ echo "href=\"/encomendas\""; }?>><div class="div_conta_menu_li <? if($sepConta=='user_encomendas' || $sepConta=='fale_connosco'){echo "verde_agua";}else{echo "cinza";}?>"><? if($LANG=='pt'){echo "As minhas encomendas";} if($LANG=='en'){echo "My orders";} ?><img src="/img/arrow.png"></div></a>
	<a <? if($user['estado'] == 'ativo'){ echo "href=\"/morada\""; }?>><div class="div_conta_menu_li <? if($sepConta=='moradas' || $sepConta=='nova_morada'){echo "verde_agua";}else{echo "cinza";}?>"><? if($LANG=='pt'){echo "As minhas moradas";} if($LANG=='en'){echo "My addresses";} ?><img src="/img/arrow.png"></div></a>
	<a <? if($user['estado'] == 'ativo'){ echo "href=\"/dados-pessoais\""; }?>><div class="div_conta_menu_li <? if($sepConta=='dados_pessoais'){echo "verde_agua";}else{echo "cinza";}?>"><? if($LANG=='pt'){echo "Os meus dados pessoais";} if($LANG=='en'){echo "My personal details";} ?><img src="/img/arrow.png"></div></a>
	<a <? if($user['estado'] == 'ativo'){ echo "href=\"/vales-de-desconto\""; }?>><div class="div_conta_menu_li <? if($sepConta=='vale_desconto'){echo "verde_agua";}else{echo "cinza";}?>"><? if($LANG=='pt'){echo "Os meus vales de desconto";} if($LANG=='en'){echo "My discount vouchers";} ?><img src="/img/arrow.png"></div></a>
	<a href="/_logout"><div class="div_conta_menu_li cinza cursor-pointer"><? if($LANG=='pt'){echo "Encerrar sessão";} if($LANG=='en'){echo "Log out";} ?><img src="/img/arrow.png"></div></a>
</div>

<script>
	function encerrar(){
		location.replace("http://www.ci-interiordecor.com/");
	}

	function irConta($id_user){
		location.replace("http://www.ci-interiordecor.com/conta/"+$id_user);
	}
</script>