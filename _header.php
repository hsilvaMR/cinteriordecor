<!-- GOOGLE ANALYTICS ANTIGO
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-105632489-1', 'auto');
  ga('send', 'pageview');
</script> -->

<? $carrinho = $_COOKIE['CARRINHO'];
if($carrinho){
	$QTP = 0;
	$lista = explode(",", $carrinho);
	foreach ($lista as $i => $value){
		$idqt = explode("-", $value);
		$idC = $idqt[0];
		$qtC = $idqt[1];
		$QTP=$QTP+$qtC;
	}
}

if ($_COOKIE["USER"]) {
	$id = $_COOKIE["USER"];

	$user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id'"));
	$nome = $user['nome'];
	$email = $user['email'];
	$user_estado = $user['estado'];
	$id_user = $user['id'];
}


$var_xs = '';
$var_sucesso = '';


if(isset($_COOKIE["USER"])){
	$var = "<div id=\"icon_menu_user\" class=\"user_in\" onClick=\"verMenuUser();\"></div>";
	$var_xs = "<div class=\"sep HA tx_uppercase\" onclick=\"irContaMenu();\">$nome</div>";
}else{
	$var = "<div class=\"user_out\" onClick=\"openLogin();\"></div>";
	$var_xs = "<div class=\"sep HA\" onclick=\"openLogin();\">INICIAR SESSÃO</div>";
}

if($LANG=='pt'){
	$encomendas_lg = "As minhas encomendas";
	$moradas_lg = "As minhas moradas";
	$dados_pessoais_lg = "Os meus dados pessoais";
	$vales_lg = "Os meus vales de desconto";
	$encerrar_lg = "Encerrar sessão";
} 
if($LANG=='en'){
	$encomendas_lg = "My orders";
	$moradas_lg = "My addresses";
	$dados_pessoais_lg = "My personal details";
	$vales_lg = "My discount vouchers";
	$encerrar_lg = "Log out";
}

if($sepConta=='moradas' || $sepConta=='nova_morada'){$cor_morada = "verde_agua";}else{$cor_morada = "cinza";}
if($sepConta=='dados_pessoais'){$cor_dados = "verde_agua";}else{$cor_dados = "cinza";}
if($sepConta=='vale_desconto'){$cor_desconto = "verde_agua";}else{$cor_desconto = "cinza";}
if($sepConta=='user_encomendas'){$cor_encomenda = "verde_agua";}else{$cor_encomenda = "cinza";}

if($user['estado'] == 'ativo'){ 
	$href_encomenda = "href=\"/encomendas\""; 
	$href_morada = "href=\"/morada\""; 
	$href_pessoais = "href=\"/dados-pessoais\""; 
	$href_vale = "href=\"/vales-de-desconto\""; 
}

$var_menu = "<div id=\"menu_user\" class=\"div_popup none\">
	<div class=\"seta_popup\"></div>
	<p onClick=\"irConta($id_user);\" class=\"div_conta_menu_nome margin-top10 margin-bottom5\" style=\"text-align:center;\">$nome</p>
	<p class=\"div_conta_menu_email\" style=\"text-align:center;\">$email</p>
	<a $href_encomenda><div class=\"div_conta_menu_li $cor_encomenda\" style=\"padding:0px 15px;\">$encomendas_lg<img style=\"right:0px;\" src=\"/img/seta_popup.png\"></div></a>
	<a $href_morada><div class=\"div_conta_menu_li $cor_morada\" style=\"padding:0px 15px;\">$moradas_lg<img style=\"right:0px;\" src=\"/img/seta_popup.png\"></div></a>
	<a $href_pessoais><div class=\"div_conta_menu_li $cor_dados\" style=\"padding:0px 15px;\">$dados_pessoais_lg<img style=\"right:0px;\" src=\"/img/seta_popup.png\"></div></a>
	<a $href_vale><div class=\"div_conta_menu_li $cor_desconto\" style=\"padding:0px 15px;\">$vales_lg<img style=\"right:0px;\" src=\"/img/seta_popup.png\"></div></a>
	<a href=\"/_logout\"><div class=\"div_conta_menu_li cinza margin-bottom10\" style=\"padding:0px 15px;\">$encerrar_lg<img style=\"right:0px;\" src=\"/img/seta_popup.png\"></div></a>
</div>";

$var_div = "<div id=\"erroCode_header\" class=\"div_erro none\"></div>";

$var_sucesso = "<div id=\"sucesso_header\" class=\"div_sucesso\"></div>";
?>
<header onmouseover="mcancel()" onmouseout="mcloset()">
	<div class="menu_xs">
		<a href="/"><div class="logo"></div></a>
		<div id="BT_MENU" class="menu DN768"></div>
	</div>

	<a class="menu_logo" href="/"><div class="logo"></div></a>


	<div class="DB768" style="height:70px;">
		<div class="carrinho" onClick="verCarrinho();"><div id="TPH" class="circQt <? if(!$QTP){echo 'none';}?>"><? echo $QTP;?></div></div>
		<div class="mundo" onClick="verIdioma();"></div>
		<? echo $var; ?>
		<a href="/contactos"><div class="separador HA <?php if($sepCor=='contactos'){echo 'corSep';}?>"><? if($LANG=='pt'){echo "CONTACTOS";} if($LANG=='en'){echo "CONTACTS";} ?></div></a>
		<a href="/blog"><div class="separador HA <?php if($sepCor=='blog'){echo 'corSep';}?>"><? if($LANG=='pt'){echo "BLOG";} if($LANG=='en'){echo "BLOG";} ?></div></a>
		<a href="/loja"><div class="separador HA <?php if($sepCor=='loja'){echo 'corSep';}?>"><? if($LANG=='pt'){echo "LOJA ONLINE";} if($LANG=='en'){echo "ONLINE STORE";} ?></div></a>
		<a href="/projectos"><div class="separador HA <?php if($sepCor=='projectos'){echo 'corSep';}?>"><? if($LANG=='pt'){echo "PROJECTOS";} if($LANG=='en'){echo "PROJECTS";} ?></div></a>
		<a href="/essencia"><div class="separador HA <?php if($sepCor=='essencia'){echo 'corSep';}?>"><? if($LANG=='pt'){echo "ESSÊNCIA";} if($LANG=='en'){echo "ESSENCE";} ?></div></a>
	</div>

	<? echo $var_menu;?>
	
	

	
</header>
<? 

	if(isset($_COOKIE["USER"]) && (($sepCor!='loja') && ($sepCor!='lojaonline'))){
	
	echo "<div class=\"header_aviso\">";
		
			if($user_estado == 'ativo'){
				if ($sepConta == 'conta') {
					if($LANG=='pt'){$tipo = "A minha conta";} if($LANG=='en'){$tipo = "My account";}

					echo "<div id=\"profile_header\" class=\"div_profile\">$tipo</div>";
				}

				if ($sepConta == 'moradas') {
					if($LANG=='pt'){$tipo = "A minha conta > As minhas moradas";} if($LANG=='en'){$tipo = "My account > My addresses";} 
					echo "<div id=\"profile_header\" class=\"div_profile\">$tipo</div>";
				}

				if ($sepConta == 'nova_morada') {
					if($LANG=='pt'){$tipo = "A minha conta > As minhas moradas > + Adicionar morada";} if($LANG=='en'){$tipo = "My account > My addresses > + Add address";} 
					echo "<div id=\"profile_header\" class=\"div_profile\">$tipo</div>";
				}

				if ($sepConta == 'dados_pessoais') {
					if($LANG=='pt'){$tipo = "A minha conta > Os meus dados pessoais";} if($LANG=='en'){$tipo = "My account > My personal details";} 
					echo "<div id=\"profile_header\" class=\"div_profile\">$tipo</div>";
				}

				if ($sepConta == 'vale_desconto') {
					if($LANG=='pt'){$tipo = "A minha conta > Os meus vales de desconto";} if($LANG=='en'){$tipo = "My account >My discount vouchers";} 
					echo "<div id=\"profile_header\" class=\"div_profile\">$tipo</div>";
				}

				if ($sepConta == 'user_encomendas') {
					if($LANG=='pt'){$tipo = "A minha conta > As minhas encomendas";} if($LANG=='en'){$tipo = "My account >My orders";} 
					echo "<div id=\"profile_header\" class=\"div_profile\">$tipo</div>";
				}

				if ($sepConta == 'fale_connosco') {

					$url = $_SERVER['REQUEST_URI'];
					$urlPartes = explode("/", $url);
					$id_url = urldecode($urlPartes[2]);

					if($LANG=='pt'){$tipo = "A minha conta > As minhas encomendas > #$id_url > Formulário";} if($LANG=='en'){$tipo = "My account >My orders";} 
					echo "<div id=\"profile_header\" class=\"div_profile\">$tipo</div>";
				}

				
			}else{
				if($LANG=='pt'){$tipo = "Conta pendente! Por favor valide a sua conta clicando no link do e-mail que lhe enviamos. Se não tiver recebido o e-mail, carregue em reenviar email. <a onClick=\"resendEmailRegister('$email');\" class=\"tx_underline branco\">REENVIAR EMAIL</a>";} if($LANG=='en'){$tipo = "Account pending! Please validate your account by clicking on the link in the email we sent you. If you have not received the email, click on resend email. <a onClick=\"resendEmailRegister('$email');\" class=\"tx_underline branco\">RESEND EMAIL</a>";}
				if ($sepConta == 'conta') {echo "<div id=\"profile_header_pendente\" class=\"div_erro\">$tipo</div>";}
			}
			

			echo $var_div;
			echo $var_sucesso;

		
		echo "</div>";
	}elseif (!isset($_COOKIE["USER"])) {
		echo "<div class=\"header_aviso\">";
		echo $var_div;
		echo $var_sucesso;
		echo "</div>";
	}

	
?>

<!-- MENU  noticias blog  -->
<div id="MENU" onmouseover="mcancel()" onmouseout="mcloset()">
  <section>
    <a href="/essencia"><div class="sep HA <?php if($sepCor=='essencia'){echo 'corSep';}?>"><? if($LANG=='pt'){echo "ESSÊNCIA";} if($LANG=='en'){echo "ESSENCE";} ?></div></a>
    <a href="/projectos"><div class="sep HA <?php if($sepCor=='projectos'){echo 'corSep';}?>"><? if($LANG=='pt'){echo "PROJECTOS";} if($LANG=='en'){echo "PROJECTS";} ?></div></a>
    <a href="/loja"><div class="sep HA <?php if($sepCor=='loja'){echo 'corSep';}?>"><? if($LANG=='pt'){echo "LOJA ONLINE";} if($LANG=='en'){echo "ONLINE STORE";} ?></div></a>
    <a href="/blog"><div class="sep HA <?php if($sepCor=='blog'){echo 'corSep';}?>"><? if($LANG=='pt'){echo "BLOG";} if($LANG=='en'){echo "BLOG";} ?></div></a>
    <a href="/contactos"><div class="sep HA <?php if($sepCor=='contactos'){echo 'corSep';}?>"><? if($LANG=='pt'){echo "CONTACTOS";} if($LANG=='en'){echo "CONTACTS";} ?></div></a>
    <a href="/carrinho"><div class="sep HA"><? if($LANG=='pt'){echo "CARRINHO";} if($LANG=='en'){echo "CART";} ?></div></a>
    <div class="sep HA" onclick="mudarIdioma('pt');">PORTUGUÊS</div>
    <div class="sep HA" onclick="mudarIdioma('en');">ENGLISH</div>
    <? echo $var_xs ?>
    <div class="clear"></div>
  </section>
</div>
<script>
function openLogin(){
	mostrar0('login');
}


function irContaMenu($id_user){
	location.replace("http://www.ci-interiordecor.com/conta/"+$id_user);
}

var aux_idioma = 'nao';
function verIdioma(){
	if(aux_idioma == 'nao')
	{
		$("#IDIOMA").css('opacity','0');
		$("#IDIOMA").css('display','block');
		$("#IDIOMA").animate({opacity:"1"}, 300);
		aux_idioma = 'sim';
		//setTimeout(function(){ $("#mod_conta").css('display','none'); }, 500);
		// CARRINHO
		$("#CARRINHO").animate({opacity:"0"},400);
		setTimeout(function(){ $("#CARRINHO").css('display','none'); }, 500);
		aux_carrinho = 'nao';

		$("#menu_user").animate({opacity:"0"},400);
		setTimeout(function(){ $("#menu_user").css('display','none'); }, 500);
		aux_menu_user = 'nao';
	}
	else
	{
		$("#IDIOMA").animate({opacity:"0"},400);
		setTimeout(function(){ $("#IDIOMA").css('display','none'); }, 400);
		aux_idioma = 'nao';
	}
}

var aux_carrinho = 'nao';
function verCarrinho(){
	if(aux_carrinho == 'nao')
	{
		$("#CARRINHO").css('opacity','0');
		$("#CARRINHO").css('display','block');
		$("#CARRINHO").animate({opacity:"1"}, 300);
		aux_carrinho = 'sim';
		//setTimeout(function(){ $("#mod_conta").css('display','none'); }, 500);
		// IDIOMA
		$("#IDIOMA").animate({opacity:"0"},400);
		setTimeout(function(){ $("#IDIOMA").css('display','none'); }, 500);
		aux_idioma = 'nao';

		$("#menu_user").animate({opacity:"0"},400);
		setTimeout(function(){ $("#menu_user").css('display','none'); }, 500);
		aux_menu_user = 'nao';
	}
	else
	{
		$("#CARRINHO").animate({opacity:"0"},400);
		setTimeout(function(){ $("#CARRINHO").css('display','none'); }, 400);
		aux_carrinho = 'nao';
	}
}

var aux_menu_user = 'nao';
function verMenuUser(){
	if(aux_menu_user == 'nao')
	{
		$("#menu_user").css('opacity','0');
		$("#menu_user").css('display','block');
		$("#menu_user").animate({opacity:"1"}, 300);
		aux_menu_user = 'sim';
		//setTimeout(function(){ $("#mod_conta").css('display','none'); }, 500);
		// IDIOMA
		$("#IDIOMA").animate({opacity:"0"},400);
		setTimeout(function(){ $("#IDIOMA").css('display','none'); }, 500);
		aux_idioma = 'nao';

		$("#CARRINHO").animate({opacity:"0"},400);
		setTimeout(function(){ $("#CARRINHO").css('display','none'); }, 400);
		aux_carrinho = 'nao';
	}
	else
	{
		$("#menu_user").animate({opacity:"0"},400);
		setTimeout(function(){ $("#menu_user").css('display','none'); }, 500);
		aux_menu_user = 'nao';
	}
}

var aux_menu = 'nao';
$(document).ready(function() {
  
  $("#BT_MENU").click(function(){
	if(aux_menu=='nao')
	{
		//$("#HEAD").css("position","fixed");
		//setTimeout(function(){ $("#BT_MENU").css("background","url(/imgs/btnclose.svg)"); }, 400);
		$("#MENU").animate({top:"0"},500);
		aux_menu = 'sim';
	}
	else
	{
		//$("#HEAD").css("position","absolute");
		//setTimeout(function(){ $("#BT_MENU").css("background","url(/imgs/btnmenu.svg)"); }, 350);
		$("#MENU").animate({top:"-200%"},900);
		aux_menu = 'nao';
	}
 });
});

function mclose(){
	// IDIOMA
	$("#IDIOMA").animate({opacity:"0"},400);
	setTimeout(function(){ $("#IDIOMA").css('display','none'); }, 500);
	aux_idioma = 'nao';
	// CARRINHO
	$("#CARRINHO").animate({opacity:"0"},400);
	setTimeout(function(){ $("#CARRINHO").css('display','none'); }, 500);
	aux_carrinho = 'nao';
	// MENU USER
	$("#menu_user").animate({opacity:"0"},400);
	setTimeout(function(){ $("#menu_user").css('display','none'); }, 500);
	aux_menu_user = 'nao';
	// MENU TLM
	$("#MENU").animate({top:"-200%"},900);
	aux_menu = 'nao';
}

var timeout = 500;
var closetimer = 0;
function mcloset(){ closetimer = window.setTimeout(mclose, timeout); }
function mcancel(){ if(closetimer) {window.clearTimeout(closetimer); closetimer = null;} }
</script>

<!-- IDIOMA -->
<div id="IDIOMA" onmouseover="mcancel()" onmouseout="mcloset()">
  	<div class="seta_idioma"></div>
    <div class="pt" onclick="mudarIdioma('pt');">PORTUGUÊS</div>
    <div class="en" onclick="mudarIdioma('en');">ENGLISH</div>
  </div>
</div>

<!-- CARRINHO -->
<div id="CARRINHO" onmouseover="mcancel()" onmouseout="mcloset()">
	<? include '_carrinho/_carrinhoHeader.php';?>
</div>

<!-- Newsletter -->
<!--<div id="NEWSLETTERFULL" class="modal" < ?php if(!isset($_COOKIE['NEWSLETTERFULL'])) echo 'style="visibility:visible;"';?>>-->
<div id="NEWSLETTERFULL" class="modal">
	<div class="modalFundo"></div>
	<div class="modalScroll"></div>
	<div class="news-size">
		<div class="news-close" onClick="fecharNewsFull();"></div>
		<h3><? if($LANG=='pt'){echo "APROVEITE JÁ";} if($LANG=='en'){echo "ENJOY NOW";} ?></h3>
		<h4><? if($LANG=='pt'){echo "Insira o seu email para receber <b>gratuitamente</b> todas as nossas <b>promoções</b> em primeira mão.";} if($LANG=='en'){echo "Enter your email to be the first to receive all our <b>promotions for free</b>.";} ?></h4>
		<input id="mail_full" name="mail_full" type="text" value="" placeholder="<? if($LANG=='pt'){echo "insira o seu email";} if($LANG=='en'){echo "enter your email";} ?>" onKeyPress="if(event.keyCode == 13){newsletterNovo('full');}"/><br>
		<button id="bt_full" type="button" onclick="newsletterNovo('full');"><? if($LANG=='pt'){echo "RECEBER PROMOÇÕES";} if($LANG=='en'){echo "RECEIVE PROMOTIONS";} ?></button>
		<p>* <? if($LANG=='pt'){echo "Ci Interior Decor recolhe dados de acordo com o RGPD (Regulamento (UE) 2016/679 do Parlamento Europeu e do Concelho de 27 de Abril 2016).";} if($LANG=='en'){echo "Ci Interior Decor collects data in accordance with the GDPR (Regulation (EU) 2016/679 of the European Parliament and of the Council of 27 April 2016).";} ?></p>
	</div>
</div>

<script>
function mudarIdioma(lang)
{
	createCookie('LINGUA',lang,720);
	location.reload();
}
function fecharNewsFull()
{
	esconder('NEWSLETTERFULL');
	createCookie('NEWSLETTERFULL','TM',48);
}
function newsletterNovo(id)
{
	var email = $("#mail_"+id).val();
	if(email){
		$.post("_newsletter/js_newsletter.php",{ email:email })
		.done(function(data){
	   		var jsonRetorna = $.parseJSON(data);
			if(jsonRetorna == 'TM'){
				$("#mail_"+id).val('');
				$("#bt_"+id).html('<? if($LANG=='pt'){echo "ADICIONADO COM SUCESSO";} if($LANG=='en'){echo "SUCCESSFULLY ADDED";} ?>');
				setTimeout(function(){ $("#bt_"+id).html('<? if($LANG=='pt'){echo "RECEBER PROMOÇÕES";} if($LANG=='en'){echo "RECEIVE PROMOTIONS";} ?>'); }, 2000);
			}
			else{
				$("#bt_"+id).html('<? if($LANG=='pt'){echo "EMAIL INVÁLIDO";} if($LANG=='en'){echo "INVALID EMAIL";} ?>');
				setTimeout(function(){ $("#bt_"+id).html('<? if($LANG=='pt'){echo "RECEBER PROMOÇÕES";} if($LANG=='en'){echo "RECEIVE PROMOTIONS";} ?>'); }, 2000);
			}
		});
	}
}



$(document).ready(function(){
  if(readCookie('NEWSLETTERFULL')!='TM'){
    window.setTimeout(function(){ mostrar('NEWSLETTERFULL'); }, 5000);
  }
});

function resendEmailRegister($email){
	var email = $email;
	$.post("/_register/js_registerEmail.php",{ email:email })
	.done(function( data ) {
		var jsonRetorna = $.parseJSON(data);
		var aviso = jsonRetorna['aviso'];

		if(jsonRetorna == 'TM') {
			$('#profile_header_pendente').hide();
			$('#sucesso_header').show();
			$('#sucesso_header').html('Email enviado com sucesso! Verifique a sua caixa de email.');
		}
		else {
			$('#sucesso_header').hide();
	
		}
	});	
}

function irConta($id_user){
	location.replace("http://www.ci-interiordecor.com/conta/"+$id_user);
}
</script>