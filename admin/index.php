<?php session_start(); session_destroy(); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<? include '_head.php';?>
</head>

<body>
<div class="loginForm">
	<div class="loginTop"><a href="/"><div class="loginLogo"></div></a></div>
	<form id="FORMULARIO" method="post">
		<div class="loginBottom" id="login">		
			<input class="inP" type="email" placeholder="Email" name="email" id="email" autofocus/>				
			<input class="inP" type="password" placeholder="Password" name="password" id="password"/>
			<input type="submit" class="btA loginBt" name="login" value="LOGIN"/>
			<div class="loginEsqueceu" onclick="form2()">Esqueceu a password?</div>
		</div>
	</form>
	<div class="loginBottom none" id="esqueceu">
		<div class="loginTit">Esqueceu a password?</div>
		<input class="inP" type="email" placeholder="Email" name="email2" id="email2" onKeyPress="if(event.keyCode == 13){esqueceu();}"/>
		<button class="btC loginBt2" name="voltar" onclick="form1()">VOLTAR</button>
		<button class="btA loginBt3" name="submeter" onclick="esqueceu()">SUBMETER</button>
	</div>
</div>
<? include '_footer.php';?>
<div id="loginErro" class="none"></div>
<!-- SCRIPT -->
<script>
$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
			url: "/admin/_login/login.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				data = data.replace(/^\s+|\s+$/g,"");
				if(data == 'TM') { window.location.href="/admin/painel"; }
				else { $.notific8(data, {heading: 'Erro', theme: 'ruby'}); }
			}         
		});
	}));
});
function esqueceu()
{
	var email = $('#email2').val();

	$.post("_login/js_esqueceu.php",{ email:email })
	.done(function( data ) {
		var jsonRetorna = $.parseJSON(data);
		if(jsonRetorna == 'TM') {
			$('#email2').val('');
			$.notific8('Enviamos os dados para o seu email!', {heading: 'Aviso'});
			/*$('#loginErro').html('Enviamos os dados para o seu email!');
			$('#loginErro').css("background","#64b052");
			$('#loginErro').css("display","block");
			setTimeout(function(){ $('#loginErro').css("display","none"); }, 6000);*/
		}
		else {
			$.notific8(jsonRetorna, {heading: 'Erro', theme: 'ruby'});
			/*$('#loginErro').html(jsonRetorna);
			$('#loginErro').css("background","#d35351");
			$('#loginErro').css("display","block");
			setTimeout(function(){ $('#loginErro').css("display","none"); }, 6000);*/
		}
	});	
}
function form1()
{
	$('#esqueceu').css("display","none");
	$('#login').css("display","block");	
}
function form2()
{
	$('#login').css("display","none");
	$('#esqueceu').css("display","block");	
}
</script>
</body>
</html>