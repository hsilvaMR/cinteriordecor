<?php

#
# Exemplo de envio de e-mail SMTP PHPMailer
#
# Inclui os ficheiros class.phpmailer.php localizado na pasta phpmailer
require_once("phpmailer/class.phpmailer.php");
require_once("phpmailer/class.smtp.php");

# Inicia a classe PHPMailer
$mail = new PHPMailer();

# Define os dados do servidor e tipo de conexão
$mail->IsSMTP(); // Define que a mensagem será SMTP
$mail->Host = 'localhost'; # Endereço do servidor SMTP, na WebHS basta usar localhost caso a conta de email esteja na mesma máquina de onde esta a correr este código, caso contrário altere para o seu desejado ex: mail.nomedoseudominio.com
$mail->Port = 587; // Porta TCP para a conexão
$mail->SMTPAutoTLS = false; // Utiliza TLS Automaticamente se disponível
$mail->SMTPAuth = true; # Usar autenticação SMTP - Sim
$mail->Username = 'admin@ci-interiordecor.com'; # Login de e-mail
$mail->Password = 'mkv7p5n9ks'; // # Password do e-mail
# Define o remetente (você)
$mail->From = "geral@ci-interiordecor.com"; # Seu e-mail
$mail->FromName = "Ci-interiordecor"; // Seu nome
#$mail->AddReplyTo('seu@e-mail.com.br', 'Nome');
# Define os destinatário(s)
$mail->AddAddress($paraEmail, $paraNome); # Os campos podem ser substituidos por variáveis
#$mail->AddAddress('webmaster@nomedoseudominio.com'); # Caso queira receber uma copia
//if(strlen($Cc) > 0){ $mail->AddCC($Cc); } #$mail->AddCC('pessoa2@dominio.com', 'Pessoa Nome 2'); # Copia
//if(strlen($CcOculto) > 0){ $mail->AddBCC($CcOculto); } #$mail->AddBCC('pessoa3@dominio.com', 'Pessoa Nome 3'); # Cópia Oculta
# Define os dados técnicos da Mensagem
$mail->IsHTML(true); # Define que o e-mail será enviado como HTML
$mail->CharSet = 'UTF-8'; #$mail->CharSet = 'iso-8859-1'; # Charset da mensagem (opcional)
# Define a mensagem (Texto e Assunto)
$mail->Subject = $assunto; # Assunto da mensagem
$mail->Body = $mensagem;
$mail->AltBody = $mensagem;

# Define os anexos (opcional)
#$mail->AddAttachment("c:/temp/documento.pdf", "documento.pdf"); # Insere um anexo
# Envia o e-mail
$enviado = $mail->Send();

# Limpa os destinatários e os anexos
$mail->ClearAllRecipients();
$mail->ClearAttachments();

# Exibe uma mensagem de resultado (opcional)
if ($enviado) {
	$retorna = "TM";//echo "E-mail enviado com sucesso!";
} else {
	$retorna = "Não foi possível enviar o e-mail.";
//echo "Não foi possível enviar o e-mail.";
//echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
}
?>

<?
#$paraEmail = $email;
#$paraNome = $nome;
?>


<?
//$para = $nome_util." <".$email_util.">";
//$De = $nome_user." <".$email_user.">";
//$Cc = "";
//$CcOculto = "";
//$respPara = "";

//$assunto = "Plataforma Online Sá Machado";
/*$mensagem = '
<html>
<head>
 <title>'.$assunto.'</title>
 <style>*{font-size:14px;}</style>
</head>
<body>
<p>Olá '.$nome_util.', tem uma <b>nova tarefa</b>.</p>
<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
<p>Na plataforma tens informações sobre a tafera a realizares bem como um chat para te ajudar, no caso de teres dúvidas.</p>
<p>Todas as tuas interações são guardadas e apresentadas no histórico!</p>
<p>Melhores Cumprimentos</p>
<p>'.$nome_user.'</p>
<br><hr>
</body>
</html>
';*/

//$headers = "MIME-Version: 1.1\n";
//$headers .= "Content-type: text/html; charset=utf-8\n";
//$headers .= "From: ".$De."\n";
//$headers .= "Return-Path: ".$De."\n";
//if(strlen($Cc) > 0){ $headers .= "Cc: ".$Cc."\n"; }
//if(strlen($CcOculto) > 0){ $headers .= "Bcc: ".$CcOculto."\n"; }
//$headers .= "Reply-To: ".$respPara."\n";

//mail($para, $assunto, $mensagem, $headers);
?>