
<div id="new_password" class="modal">
	<div class="modalFundo"></div>
	<div class="modalScroll"></div>
	<div class="news-size-NEW">
		<div style="padding:0px 40px;">
			<div class="news-close-NEW" onClick="fecharPassword();"></div>
			<h3 class="textl"><? if($LANG=='pt'){echo "RECUPERAR PASSWORD";} if($LANG=='en'){echo "RETRIEVE PASSWORD";} ?></h3>
		
			<input id="mail_pass" name="mail_pass" type="email"  placeholder="<? if($LANG=='pt'){echo "EMAIL";} if($LANG=='en'){echo "EMAIL";} ?>"/><br>
		</div>

		<p onClick="showLoginPass();" style="margin-bottom:20px;"><? if($LANG=='pt'){echo "SABE A SUA PASSWORD?";} if($LANG=='en'){echo "DO YOU KNOW YOUR PASSWORD?";} ?></p>

		<label id="erro_pass" class="none vermelho"></label>
		<label id="sucesso_pass" class="none textl verde"></label>

		<div style="height:50px;margin-top:40px;">
			<label class="label_entrar" style="width:100%;" onclick="esqueceuPass()"><? if($LANG=='pt'){echo "RECUPERAR";} if($LANG=='en'){echo "TO RECOVER";} ?></label>
		</div>
	</div>
</div>

<script>

function fecharPassword()
{
	esconder('new_password');
	$('#erro_pass').hide();
	$('#sucesso_pass').hide();
}

function showLoginPass()
{
	esconder('new_password');
	mostrar0('login');
}

function esqueceuPass()
{
	var email = $('#mail_pass').val();

	$.post("/_login/js_newPass.php",{ email:email })
	.done(function( data ) {
		var jsonRetorna = $.parseJSON(data);
		var aviso = jsonRetorna['aviso'];

		if(jsonRetorna == 'TM') {
			$('#mail_pass').val('');
			$('#erro_pass').hide();
			$('#sucesso_pass').show();
			$('#sucesso_pass').html('Email enviado com sucesso! Verifique a sua caixa de email.');
		}
		else {
			console.log('erro');
			$('#erro_pass').html(aviso);
			$('#erro_pass').show();
			$('#sucesso_pass').hide();
	
		}
	});	
}
</script>