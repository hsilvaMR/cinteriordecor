<!-- Newsletter -->
<!--<div id="NEWSLETTERSMALL" class="news-size-small" < ?php if(isset($_COOKIE['NEWSLETTERFULL']) && !isset($_COOKIE['NEWSLETTERSMALL'])) echo 'style="visibility:visible;"';?>>-->
<div id="NEWSLETTERSMALL" class="news-size-small">
	<div class="news-close-small" onClick="fecharNewsSmall();"></div>
	<h3><? if($LANG=='pt'){echo "APROVEITE JÁ";} if($LANG=='en'){echo "ENJOY NOW";} ?></h3>
	<h4><? if($LANG=='pt'){echo "Insira o seu email para receber <b>gratuitamente</b> todas as nossas <b>promoções</b> em primeira mão.";} if($LANG=='en'){echo "Enter your email to be the first to receive all our <b>promotions for free</b>.";} ?></h4>
	<input id="mail_small" name="mail_small" type="text" value="" placeholder="<? if($LANG=='pt'){echo "insira o seu email";} if($LANG=='en'){echo "enter your email";} ?>" onKeyPress="if(event.keyCode == 13){newsletterNovo('small');}"/><br>
	<button id="bt_small" type="button" onclick="newsletterNovo('small');"><? if($LANG=='pt'){echo "RECEBER PROMOÇÕES";} if($LANG=='en'){echo "RECEIVE PROMOTIONS";} ?></button>
	<p>* <? if($LANG=='pt'){echo "Ci Interior Decor recolhe dados de acordo com o RGPD (Regulamento (UE) 2016/679 do Parlamento Europeu e do Concelho de 27 de Abril 2016).";} if($LANG=='en'){echo "Ci Interior Decor collects data in accordance with the GDPR (Regulation (EU) 2016/679 of the European Parliament and of the Council of 27 April 2016).";} ?></p>
</div>

<script>
function fecharNewsSmall()
{
	esconder('NEWSLETTERSMALL');
	createCookie('NEWSLETTERSMALL','TM',1);
}
$(document).ready(function(){
  if(readCookie('NEWSLETTERFULL')=='TM' && readCookie('NEWSLETTERSMALL')!='TM'){
    window.setTimeout(function(){ mostrar('NEWSLETTERSMALL'); }, 5000);
  }
});
</script>