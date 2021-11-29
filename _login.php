
<div id="login" class="modal">
	<div class="modalFundo"></div>
	<div class="modalScroll"></div>
	<div class="news-size-NEW">
		<div style="padding:0px 40px;">
			<div class="news-close-NEW" onClick="fecharLogin();"></div>
			<h3 class="textl"><? if($LANG=='pt'){echo "ACESSO";} if($LANG=='en'){echo "ACCESS";} ?></h3>
			<input id="mail" name="mail" type="email" value="" placeholder="<? if($LANG=='pt'){echo "EMAIL";} if($LANG=='en'){echo "EMAIL";} ?>"/><br>

			<input id="password" name="password" type="password" value="" placeholder="<? if($LANG=='pt'){echo "PASSWORD";} if($LANG=='en'){echo "PASSWORD";} ?>"/><br>
		
			<p onClick="showNewPass();" style="margin-bottom:20px;"><? if($LANG=='pt'){echo "ESQUECEU-SE DA SUA PASSWORD?";} if($LANG=='en'){echo "FORGOT YOUR PASSWORD?";} ?></p>

			<label id="erro_login" class="none vermelho"></label>
		</div>
		<div style="height:50px;margin-top:60px;">
			<label class="label_registar" onClick="openModals();"><? if($LANG=='pt'){echo "REGISTAR";} if($LANG=='en'){echo "REGISTER";} ?></label>
			<label class="label_entrar" onClick="loginUser();"><? if($LANG=='pt'){echo "ENTRAR";} if($LANG=='en'){echo "LOG IN";} ?></label>
		</div>
	</div>
</div>



<script>
function fecharLogin()
{
	esconder('login');
	$('#erro_login').hide();
}


function openModals()
{
	mostrar0('register');
	esconder('login');
	$('#erro_login').hide();
}

function showNewPass()
{
	esconder('login');
	mostrar0('new_password');
	$('#erro_login').hide();
}

function loginUser(){
	var mail = $('#mail').val();
	var password = $('#password').val();


	$.post("/_login/js_login.php",{ mail:mail,password:password }) 
	.done(function( data ){
	  	var jsonRetorna = $.parseJSON(data);
		var aviso = jsonRetorna['aviso'];
		var id_user = jsonRetorna['id_user'];
		
	
		if(aviso){
			$('#erro_login').html(aviso);
			$('#erro_login').show();
			//setTimeout(function(){ $('#erroCode_header').html(''); },3000);
		}
		else{
			$('#erro_login').hide();
			createCookie('USER',id_user,1);
			location.replace("http://www.ci-interiordecor.com/conta/"+id_user)
		}
	});
}

</script>