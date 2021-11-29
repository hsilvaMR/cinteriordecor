<input id="qtRestante" type="text" value="<? echo $qtRestante;?>" hidden/>
<input id="qtCarrinho" type="text" value="<? echo $qtCarrinho;?>" hidden/>
<input id="quantStock" type="text" value="<? echo $quantStock;?>" hidden/>

<div style="float:left;margin-top:10px">
	<b><? if($LANG=='pt'){echo "QUANTIDADE </b><br>Em stock:";} if($LANG=='en'){echo "QUANTITY </b><br>In stock:";} ?> <? echo "$quantStock";?>
</div>
<select id="qtP" class="seL slQt" name="quantidade" <? if($qtRestante<1){echo "disabled"; }?>>
<?php
if($qtRestante>0){$qt = 1;}else{$qt = 0;}
while ($qt <= $qtRestante)
{
	echo"<option class='selS' value='$qt'>$qt</option>";
	$qt++;
}
?>
</select>
<? if(!isset($quantidade)){$quantidade='';}if(!isset($orcamento)){$orcamento='';}if(!isset($comprimento)){$comprimento='';}if(!isset($largura)){$largura='';}if(!isset($altura)){$altura='';}
if(!$quantidade || $orcamento || $comprimento>180 || $largura>180 || $altura>180 || ($comprimento>120 && $largura>120) || ($comprimento>120 && $altura>120) || ($altura>120 && $largura>120) || ($comprimento>80 && $altura>80 && $largura>80)){?>
	<input id="bt_adicionar" type="button" class="btA adicionar" value="<? if($LANG=='pt'){echo "CONTACTAR";} if($LANG=='en'){echo "CONTACT US";} ?>" onclick="mostrar('CONTACTO');"><? }
elseif($qtRestante>0){?>
	<input id="bt_adicionar" type="button" class="btA adicionar" value="<? if($LANG=='pt'){echo "ADICIONAR";} if($LANG=='en'){echo "ADD";} ?>" onclick="adiCarrinho('<? echo $id?>');"><? }
elseif(!$noCarrinho){ ?><input id="bt_adicionar" type="button" class="btC adicionar" value="<? if($LANG=='pt'){echo "INDISPONÍVEL";} if($LANG=='en'){echo "UNAVAILABLE";} ?>"><? }
else{ ?><input id="bt_adicionar" type="button" class="btC adicionar" value="<? if($LANG=='pt'){echo "ADICIONAR";} if($LANG=='en'){echo "ADD";} ?>"><? }?>

<!-- CONTACTO -->
<div id="CONTACTO" class="modal">
	<div class="modalFundo" onClick="esconder('CONTACTO');"></div>
	<div class="modalScroll" onClick="esconder('CONTACTO');"></div>
	<div class="modalClose" onClick="esconder('CONTACTO');"></div>
	<div class="modalSize">
		<h3><? if($LANG=='pt'){echo "CONTACTAR";} if($LANG=='en'){echo "CONTACT US";} ?></h3>
		<h4><? if($LANG=='pt' && isset($produto_pt)){echo $produto_pt;} if($LANG=='en' && isset($produto_en)){ echo $produto_en; } ?></h4>
		<form id="FORMULARIO" method="post">
			<input type="hidden" name="id" value="<? echo $id;?>">
			<input type="hidden" name="produto" value="<? if($LANG=='pt' && isset($produto_pt)){echo $produto_pt;} if($LANG=='en' && isset($produto_en)){ echo $produto_en; } ?>">
			<input type="text" class="modalInput" name="nome" value="" placeholder="<? if($LANG=='pt'){echo "Nome";} if($LANG=='en'){echo "Name";} ?>" autofocus required>
			<input type="email" class="modalInput" name="email" value="" placeholder="<? if($LANG=='pt'){echo "Email";} if($LANG=='en'){echo "Email";} ?>" required>
			<div class="modalEsq"><input type="tel" class="modalInput" name="contacto" value="" placeholder="<? if($LANG=='pt'){echo "Contacto";} if($LANG=='en'){echo "Contact";} ?>" required></div>
			<div class="modalDir"><input type="tel" class="modalInput" name="quantidade" value="" placeholder="<? if($LANG=='pt'){echo "Quantidade";} if($LANG=='en'){echo "Quantity";} ?>" required></div>
			<textarea rows="5" class="modalText" name="mensagem" placeholder="<? if($LANG=='pt'){echo "Informações Adicionais";} if($LANG=='en'){echo "Additional Information";} ?>" required></textarea>
			<input type="submit" class="modalBt" name="enviar" value="<? if($LANG=='pt'){echo "ENVIAR";} if($LANG=='en'){echo "SUBMIT";} ?>"/>
			<div id="aviso" class="modalAviso"></div>
		</form>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
			url: "/_encomenda/novo.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				if(data=='TM'){					
					$("#FORMULARIO")[0].reset();
					$('#aviso').html('<? if($LANG=='pt'){echo "Obrigado pelo seu contacto.";} if($LANG=='en'){echo "Thanks for your contact.";} ?>');
					setTimeout(function(){ $('#aviso').html(''); }, 10000);

				}else{
					$('#aviso').html(data);
					setTimeout(function(){ $('#aviso').html(''); }, 5000);
				}
			}         
		});
	}));
});
</script>