<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Ci | Interior Decor</title>
<? include '_head.php';?>
</head>

<body>
<? $sepCor=''; include '_header.php';?>
<div class="barraH"></div>
<article>
	<section>
		<img src="/img/disclaimer/arvores.jpg" class="disclaimer-capa">
	</section>
	<section>
		<? if($LANG=='pt'){echo "Antes de imprimir este email pense bem se tem mesmo que o fazer. Há cada vez menos árvores.
		<br><br><br><b>AVISO.</b> Esta mensagem está destinada ao uso dos indivíduos ou entidades ao qual está endereçada, e poderá conter informação confidencial. A sua divulgação, cópia ou distribuição ficará sujeita ao regime de responsabilidade civil e criminal legalmente estabelecido. Se recebeu esta mensagem por engano, por favor contacte o remetente e elimine-a. Esta mensagem foi verificada contra vírus e conteúdo.";}
		if($LANG=='en'){echo "Before printing this email, please think if you really need it. Trees are each time less and less.
		<br><br><br><b>WARNING.</b> This message is intended for use by individuals or entities to which it is addressed and may contain confidential information. The disclosure, copying or distribution will be subjected to the civil and criminal liability regime established by law. If you have received this message by error, please contact the sender and delete it. This message was checked against viruses and content.";}
		if($LANG=='fr'){echo "Avant imprimer ce courrier électronique pensez bien si vous avez besoin de le faire. Il y à de moins en moins arbres.
		<br><br><br><b>AVERTISSEMENT.</b> Ce message est destiné à être utilisé par les personnes ou entités auxquelles il est adressé et peut contenir des informations confidentielles. La divulgation, la reproduction ou la distribution sera soumis au regime de responsabilite civile et penale etablie par la loi. Si vous avez reau ce message par erreur, veuillez s'il vous plait contacter l'expediteur et le supprimer. Ce message ainsi que son contenu a été vérifié contre les virus.";} ?>
	</section>
	<div class="disclaimer-fundo"></div>
</article>
<? include '_footer.php';?>
</body>
</html>