
<div id="register" class="modal">
	<div class="modalFundo"></div>
	<div class="modalScroll"></div>
	<div class="news-size-NEW">

		

		<div style="padding:0px 40px;">
			<div class="news-close-NEW" onClick="fecharRegister();"></div>
			<h3 class="textl"><? if($LANG=='pt'){echo "REGISTO";} if($LANG=='en'){echo "REGISTRATION";} ?></h3>
											
			<div class="textl" style="border-bottom: 0.5px solid rgba(0, 0, 0, 0.1);padding:0px 10px 10px 10px;">
				<label style="color: #00A19B;font-family: 'Open Sans', sans-serif;font-style: normal;font-weight: normal;font-size: 14px;line-height: 18px;">TIPO DE CLIENTE</label>
				<br>
				<input type="radio" id="check_particular" name="tipo_morada" class="RD-50-conta" value="" >
				<label for="check_particular"></label><span class="margin-right30 fonte14"><? if($LANG=='pt'){echo "Particular / Por conta própria";} if($LANG=='en'){echo "Private / Self-employed";} ?></span>

				<input type="radio" id="check_company" name="tipo_morada" class="RD-50-conta" value="">
				<label for="check_company"></label><span class="fonte14"><? if($LANG=='pt'){echo "Empresa";} if($LANG=='en'){echo "Company";} ?></span>
			</div>
			
			<div id="next_register" class="none">
				<input id="language" type="hidden" name="language" value="<? echo $LANG?>">
				<input id="nome" name="nome" type="text" value="" placeholder="<? if($LANG=='pt'){echo "NOME";} if($LANG=='en'){echo "NAME";} ?>"/>
				<input id="apelido" name="apelido" type="text"  placeholder="<? if($LANG=='pt'){echo "APELIDO";} if($LANG=='en'){echo "NICKNAME";} ?>"/>
				<input id="mail_register" name="mail_register" type="email"  placeholder="<? if($LANG=='pt'){echo "EMAIL";} if($LANG=='en'){echo "EMAIL";} ?>"/>

				<input id="password_register" name="password_register" type="password"  placeholder="<? if($LANG=='pt'){echo "PASSWORD (Mínimo 8 caractéres)";} if($LANG=='en'){echo "PASSWORD (Minimum 8 characters)";} ?>"/><br>
				
				<div class="textl" style="font-family: Open Sans;font-style: normal;font-weight: 300;font-size: 14px;margin-top:20px;margin-bottom:30px;color: #00A19B;">
					<input type="checkbox" id="check_priv" class="RD-50-conta" value="0">
					<label for="check_priv"></label><span><? if($LANG=='pt'){echo "Li e aceito a \"Política de Privacidade\"";} if($LANG=='en'){echo "I have read and accept the \"Privacy Policy\"";} ?></span><br>

					<input type="checkbox" id="check_desc" class="RD-50-conta" value="0">
					<label for="check_desc"></label><span><? if($LANG=='pt'){echo "Deseja receber os melhores descontos?";} if($LANG=='en'){echo "Do you want to receive the best discounts?";} ?></span>
				</div>
				

				<p onClick="show();" style="margin-bottom:20px;"><? if($LANG=='pt'){echo "JÁ ESTA REGISTADO?";} if($LANG=='en'){echo "ARE YOU ALREADY REGISTERED?";} ?></p>
			
				<label id="erro_registo" class="none vermelho"></label>
				<label id="sucesso_registo" class="none textl verde"></label>
			</div>
			
		</div>
		
		<div style="height:50px;margin-top:40px;">
			<label class="label_registar" onClick="registerUser();"><? if($LANG=='pt'){echo "REGISTAR";} if($LANG=='en'){echo "REGISTER";} ?></label>
			<label class="label_entrar" onClick="loginUserRegister();"><? if($LANG=='pt'){echo "ENTRAR";} if($LANG=='en'){echo "LOG IN";} ?></label>
		</div>
	</div>
</div>

<script>

$('#check_particular').click(function() {
	var language = $('#language').val();
	if ($(this).is(':checked') == true) {
	    $('#check_particular').prop('value', 1);
	    $('#check_company').prop('value', 0);
		$('#next_register').show();
		$('#apelido').show();
		$('#erro_registo').hide();
		$('#sucesso_registo').hide();
		if(language=='pt'){document.getElementById("nome").placeholder = "NOME";}
		if(language=='en'){document.getElementById("nome").placeholder = "NAME";}
	}
});

$('#check_company').click(function() {
	var language = $('#language').val();
	if ($(this).is(':checked') == true) {
	    $('#check_company').prop('value', 1);
	    $('#check_particular').prop('value', 0);
	    $('#next_register').show();
	    $('#apelido').hide();
	    $('#erro_registo').hide();
		$('#sucesso_registo').hide();
	    if(language=='pt'){document.getElementById("nome").placeholder = "NOME DA EMPRESA";}
		if(language=='en'){document.getElementById("nome").placeholder = "COMPANY NAME";}
	}
});

$('#check_priv').click(function() {
	if ($(this).is(':checked') == true) {
	    $('#check_priv').prop('value', 1);
	}else{
	    $('#check_priv').prop('value', 0);
	}
});

$('#check_desc').click(function() {
	if ($(this).is(':checked') == true) {
	    $('#check_desc').prop('value', 1);
	}else{
	    $('#check_desc').prop('value', 0);
	}
});

function fecharRegister()
{
	esconder('register');
	$('#erro_registo').hide();
}

function show()
{
	esconder('register');
	mostrar0('login');
	$('#erro_registo').hide();
}

function loginUserRegister(){
	var mail = $('#mail_register').val();
	var password = $('#password_register').val();
	

	$.post("/_login/js_login.php",{ mail:mail,password:password }) 
	.done(function( data ){
	  	var jsonRetorna = $.parseJSON(data);
		var aviso = jsonRetorna['aviso'];
		
	
		if(aviso){
			$('#erro_registo').html(aviso);
			$('#erro_registo').show();
			$('#sucesso_registo').hide();
			//setTimeout(function(){ $('#erroCode_header').html(''); },3000);
		}
		else{
			$('#erro_registo').hide();
			$('#sucesso_registo').hide();
		}
	});
}


function registerUser(){
	var check_particular = $('#check_particular').val();
	var check_company = $('#check_company').val();
	var nome = $('#nome').val();
	var apelido = $('#apelido').val();
	var mail = $('#mail_register').val();
	var password = $('#password_register').val();
	var check_priv = $('#check_priv').val();
	var check_desc = $('#check_desc').val();

	$.post("/_register/js_register.php",{ check_particular:check_particular,check_company:check_company,nome:nome,apelido:apelido,mail:mail,password:password,check_priv:check_priv,check_desc:check_desc }) 
	.done(function( data ){
	  	var jsonRetorna = $.parseJSON(data);
		var aviso = jsonRetorna['aviso'];
		var sucesso = jsonRetorna['sucesso'];

		if(aviso){
			$('#erro_registo').html(aviso);
			$('#erro_registo').show();
			$('#sucesso_registo').hide();
			//setTimeout(function(){ $('#erroCode_header').html(''); },3000);
		}
		else{
			if(sucesso){
				$('#sucesso_registo').html(sucesso);
				$('#sucesso_registo').show();
				sendEmailRegister(mail);
				setTimeout(function(){ $('#sucesso_registo').hide(); },1500);
				setTimeout(function(){ $('#register').hide(); },1600);
				setTimeout(function(){ mostrar0('modal_boas_vindas'); },1700);
			}
			$('#erro_registo').hide();
		}
	});
}

function sendEmailRegister($email){
	var email = $email;
	$.post("/_register/js_registerEmail.php",{ email:email })
	.done(function( data ) {
		var jsonRetorna = $.parseJSON(data);
		var aviso = jsonRetorna['aviso'];

		if(jsonRetorna == 'TM') {
			$('#mail_pass').val('');
			$('#erro_registo').hide();
			$('#sucesso_registo').show();
			$('#sucesso_registo').html('Email enviado com sucesso! Verifique a sua caixa de email.');
		}
		else {
			$('#erro_registo').html(aviso);
			$('#erro_registo').show();
			$('#sucesso_registo').hide();
	
		}
	});	
}
</script>