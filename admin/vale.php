<?php include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">

<head>
	<meta charset="utf-8">
	<title>Portes</title>
	<? include '_head.php'; ?>

	<!-- CALENDARIO -->
	<link href="/admin/funcao/datepicker/jquery-ui.css" rel="stylesheet">
	<script src="/admin/funcao/datepicker/jquery-ui.js" type="text/javascript"></script>

</head>

<body>
	<? include '_header.php'; ?>

	<article>
		<?
		$url = $_SERVER['REQUEST_URI'];
		$urlPartes = explode("/", $url);
		$id = urldecode($urlPartes[3]);
		$existe = mysqli_num_rows(mysqli_query($lnk, "SELECT * FROM vales_desconto WHERE id='$id'"));
		if ($existe) {
			extract(mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM vales_desconto WHERE id='$id'")));
			$id_url = urldecode($urlPartes[3]);
		}

		$sep = 17;
		if (!$existe) {
			$sub = 17.2;
		}
		include '_menu.php';
		?>

		<div class="conteudo">
			<div class="linha">
				<div class="titulo">
					<h1><? if ($existe) {
							echo "Editar";
						} else {
							echo "Novo";
						} ?> Vale de Desconto<h1>
							<a href="/admin/painel">Painel</a>
							<div class="ponto"></div>
							<a href="/admin/vales">Vales de Desconto</a>
							<div class="ponto"></div>
							<a href="">Vale de Desconto</a>
				</div>
			</div>
			<div class="linha">
				<div class="coluna1">
					<div class="corpo">
						<form id="FORMULARIO_" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<? if ($existe) {
																		echo $id_url;
																	} ?>">
							<div class="corpoCima">
								<div class="grupo">
									<div class="grupoEsq">Nome:</div>
									<div class="grupoDir">
										<input type="text" class="inP" name="nome" value="<? echo $nome ?>" autofocus placeholder='DESCONTO CI'>
									</div>
								</div>

								<div class="grupo">
									<div class="grupoEsq">Código:</div>
									<div class="grupoDir">
										<input type="text" class="inP" name="codigo" value="<? echo $codigo ?>" placeholder='DESCONTOCI'>
									</div>
								</div>

								<div class="grupo">
									<div class="grupoEsq">Oferta:</div>
									<div class="grupoDir">
										<select id="history" class="seL" name="oferta" onchange="historyChanged(this);">
											<option class="selS" disabled selected>Regras de ofertas</option>
											<option class="selS" value="acima_de" <? if ($tipo == 'acima_de') {
																						echo "selected";
																					} ?>>valor acima de</option>
											<option class="selS" value="desconto_perc" <? if ($tipo == 'desconto_perc') {
																							echo "selected";
																						} ?>>desconto em %</option>
											<option class="selS" value="cupao" <? if ($tipo == 'cupao') {
																					echo "selected";
																				} ?>>cupão em €</option>
											<option class="selS" value="gratis" <? if ($tipo == 'gratis') {
																					echo "selected";
																				} ?>>grátis</option>
										</select>

										<div id="select_acima" style="margin:20px 0 10px 0;width:100%;display:none;<? if ($tipo == 'acima_de') {
																														echo "display:block";
																													} ?>">
											<div style="float:left;">
												<label>acima de (€)</label>
												<input type="text" class="inP" name="codigo_acima" value="<? if ($valor_condicao != 0) {
																												echo $valor_condicao;
																											} ?>" placeholder='20'>
											</div>

											<div style="float:left;margin-left:20px;">
												<label>Selecione uma opção</label>
												<select id="option" class="seL" style="float:left;" name="oferta_opcao" onchange="optionChanged(this);">
													<option class="selS" value="gratis_acima" <? if ($gratis == 1) {
																									echo "selected";
																								} ?>>grátis</option>
													<option class="selS" value="desconto_perc_acima" <? if ($valor_desconto != 0) {
																											echo "selected";
																										} ?>>desconto em %</option>
												</select>


												<div id="select_desc_acima" style="display:none;<? if ($valor_desconto != 0) {
																									echo "display:block";
																								} ?>">
													<input id="desc_select" type="text" class="inP" name="desc_Acima" value="<? if ($valor_desconto != 0) {
																																	echo $valor_desconto;
																																} ?>" placeholder='25'>
												</div>
											</div>
										</div>

										<div id="select_desconto" style="margin:20px 0 10px 0;display:none; <? if ($tipo == 'desconto_perc') {
																												echo "display:block";
																											} ?>">

											<div style="float:left;">
												<label>desconto de (%)</label>
												<input type="text" class="inP" name="desconto_desc" value="<? if ($valor_desconto != 0) {
																												echo $valor_desconto;
																											} ?>" placeholder='20'>
											</div>

											<div style="float:left;margin-left:20px;">
												<label>acima de (€) - opcional</label>
												<input type="text" class="inP" name="desconto_acima" value="<? if ($valor_condicao != 0) {
																												echo $valor_condicao;
																											} ?>" placeholder='60'>
											</div>
										</div>

										<div id="select_cupao" style="margin:20px 0 10px 0;display:none; <? if ($tipo == 'cupao') {
																												echo "display:block";
																											} ?>">

											<div style="float:left;">
												<label>cupão de (€)</label>
												<input type="text" class="inP" name="desconto_cupao" value="<? if ($valor_desconto != 0) {
																												echo $valor_desconto;
																											} ?>" placeholder='20'>
											</div>

											<div style="float:left;margin-left:20px;">
												<label>acima de (€) - opcional</label>
												<input type="text" class="inP" name="desconto_acima_cupao" value="<? if ($valor_condicao != 0) {
																														echo $valor_condicao;
																													} ?>" placeholder='60'>
											</div>
										</div>

									</div>
								</div>

								<div class="grupo">
									<div class="grupoEsq">Início:</div>
									<div class="grupoDir">
										<? if ($data_inicio == '0000-00-00') {
											$data_inicio = "";
										} ?>
										<input type="text" class="inP" name="inicio" id="CALENDARIO" maxlength="10" value="<? echo $data_inicio ?>" onchange="mudaCal1(this);">
									</div>
								</div>

								<div class="grupo">
									<div class="grupoEsq">Fim:</div>
									<div class="grupoDir">
										<? if ($data_fim == '0000-00-00') {
											$data_fim = "";
										} ?>
										<input type="text" class="inP" name="fim" id="CALENDARIO2" maxlength="10" value="<? echo $data_fim ?>" onchange="mudaCal2(this);">
									</div>
								</div>

								<div class="grupo">
									<div class="grupoEsq">Descrição:</div>
									<div class="grupoDir">
										<textarea class="teX" name="descricao" placeholder="Descrição do funcionamento do código"><? echo $descricao ?></textarea>
									</div>
								</div>


								<div class="clear"></div>
							</div>
							<div class="corpoBaixo">
								<input type="submit" class="btV" name="guardar" value="GUARDAR" />
								<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/vales';">CANCELAR</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</article>
	<? include '_footer.php'; ?>
	<!-- MODALS -->
	<div id="GUARDAR" class="modal">
		<div class="modalFundo" onClick="window.location.reload();"></div>
		<span class="modalClose lnr lnr-cross-circle" onClick="window.location.reload();"></span>
		<div class="modalSize">
			<div class="modalHead">Guardado</div>
			<div class="modalBody">Guardado com sucesso.</div>
			<div class="modalFoot">
				<button class="btV modalBt" name="nao" onclick="window.location.reload();">FECHAR</button>
				<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/vales';">VOLTAR</button>
			</div>
		</div>
	</div>
	<!-- -->
	<script>
		$(function() {
			var fim = "<? echo $fim ?>";
			fim = fim.replace("-", ",");
			fim = fim.replace("-", ",");
			$("#CALENDARIO").datepicker({
				maxDate: new Date(fim)
			});
			var inicio = "<? echo $inicio ?>";
			inicio = inicio.replace("-", ",");
			inicio = inicio.replace("-", ",");
			$("#CALENDARIO2").datepicker({
				minDate: new Date(inicio)
			});
		});

		function mudaCal1(input) {
			var inicio = input.value;
			inicio = inicio.replace("-", ",");
			inicio = inicio.replace("-", ",");
			$('#CALENDARIO2').datepicker('option', 'minDate', new Date(inicio));
		}

		function mudaCal2(input) {
			var fim = input.value;
			fim = fim.replace("-", ",");
			fim = fim.replace("-", ",");
			$('#CALENDARIO').datepicker('option', 'maxDate', new Date(fim));
		}

		$(document).ready(function(e) {
			$("#FORMULARIO_").on('submit', (function(e) {
				//mostrar('LOADING');
				e.preventDefault();
				$.ajax({
					url: "/admin/_vales/novo.php",
					type: "POST",
					data: new FormData(this),
					contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
					cache: false,
					processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
					success: function(data) {
						console.log(data);
						//esconder('LOADING');
						if (data) {
							mostrar('GUARDAR');
							window.history.pushState("object or string", "Title", "/admin/vale/" + data);
							//window.location.replace("pagina?id="+data);
						}
					}
				});
			}));
		});

		function historyChanged() {
			var historySelectList = $('select#history');
			var selectedValue = $('option:selected', historySelectList).val();


			if (selectedValue == 'acima_de') {
				$('#select_desconto').hide();
				$('#select_cupao').hide();
				$('#select_acima').show();
			} else if (selectedValue == 'desconto_perc') {
				$('#select_acima').hide();
				$('#select_desconto').show();
				$('#select_cupao').hide();
			} else if (selectedValue == 'cupao') {
				$('#select_acima').hide();
				$('#select_desconto').hide();
				$('#select_cupao').show();
			} else {
				$('#select_acima').hide();
				$('#select_desconto').hide();
				$('#select_cupao').hide();
			}


		}

		function optionChanged() {
			var optionSelectList = $('select#option');
			var selectedValue = $('option:selected', optionSelectList).val();

			if (selectedValue == 'gratis_acima') {
				$('#select_desc_acima').hide();
				$('#desc_select').val('');
			} else if (selectedValue == 'desconto_perc_acima') {
				$('#select_desc_acima').show();
			}
		}
	</script>
</body>

</html>