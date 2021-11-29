
<div id="modal_boas_vindas" class="modal">
	<div class="modalFundo"></div>
	<div class="modalScroll"></div>
	<div class="news-size-NEW">
		<div style="padding:0px 40px;">
			<div class="news-close-NEW" onClick="fecharPassword();"></div>
			<h3 class="textl"><? if($LANG=='pt'){echo "BEM-VINDO À CI!";} if($LANG=='en'){echo "WELCOME TO CI!";} ?></h3>
			<img style="margin-top:40px;" height="70" width="70" src="/img/modal_visto.jpg">
			
		</div>

		<p><? if($LANG=='pt'){echo " Obrigado! Registado com sucesso. Verifique o seu email. Comece já a descobrir todas as vantagens de ser nosso cliente.";} if($LANG=='en'){echo "Thanks! Successfully registered. Check your email. Start to discover all the advantages of being our customer.";} ?></p>

		<div style="height:50px;margin-top:60px;line-height:50px;background-color:#4497A6;">
			<label class="label_entrar-100" onClick="showLogin();"><? if($LANG=='pt'){echo "ENTRAR";} if($LANG=='en'){echo "LOG IN";} ?></label>
		</div>
	</div>
</div>

<script>
function showLogin()
{
	esconder('modal_boas_vindas');
	mostrar0('login');
}
</script>