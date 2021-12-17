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
                        } ?> Voucher<h1>
                            <a href="/admin/painel">Painel</a>
                            <div class="ponto"></div>
                            <a href="/admin/vales">Voucher Unico</a>
                            <div class="ponto"></div>
                            <a href="">Voucher Unico</a>
                </div>
            </div>

            <!-- FORMULARIO -->
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
                                        <input type="text" class="inP" name="nome" value="<? echo $nome ?>" autofocus placeholder='Designação Voucher'>
                                    </div>
                                </div>

                                <div class="grupo">
                                    <div class="grupoEsq">Descrição:</div>
                                    <div class="grupoDir">
                                        <input type="text" class="inP" name="nome" value="<? echo $nome ?>" autofocus placeholder='Descrição'>
                                    </div>
                                </div>

                                <div class="grupo">
                                    <div class="grupoEsq">Código:</div>
                                    <div class="grupoDir">
                                        <input type="text" class="inP" name="nome" value="<? echo $nome ?>" autofocus placeholder='Código do Voucher'>
                                    </div>
                                </div>

                                <div class="grupo">
                                    <div class="grupoEsq">Valor:</div>
                                    <div class="grupoDir">
                                        <input type="text" class="inP" name="nome" value="<? echo $nome ?>" autofocus placeholder='Valor do voucher'>
                                    </div>
                                </div>
                                <div class="grupo">
                                    <div class="grupoEsq">Incio:</div>
                                    <div class="grupoDir">
                                        <input type="text" class="inP" name="inicio" id="CALENDARIO" maxlength="10" value="" onchange="setingDateFim()">
                                    </div>
                                </div>

                                <div class="grupo">
                                    <div class="grupoEsq">Fim:</div>
                                    <div class="grupoDir">

                                        <input type="text" class="inP" name="fim" id="CALENDARIO2" maxlength="10" value="">
                                    </div>
                                </div>


                                <div class="grupo">
                                    <div class="grupoEsq">Tipo:</div>
                                    <div class="grupoDir">

                                        <select id="history" class="seL" name="oferta" onchange="historyChanged(this);">
                                            <option class="selS" disabled selected>Tipo de Voucher</option>
                                            <option class="selS" value="vale" <? if ($tipo == 'vale') {
                                                                                    echo "selected";
                                                                                } ?>>Vale</option>
                                            <option class="selS" value="cupao" <? if ($tipo == 'cupao') {
                                                                                    echo "selected";
                                                                                } ?>>Cupão </option>
                                            <option class="selS" value="family" <? if ($tipo == 'family') {
                                                                                    echo "selected";
                                                                                } ?>>Family</option>

                                        </select>
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

    <script>
        $(function() {

            $("#CALENDARIO").datepicker({

                dateFormat: 'yy-mm-dd',
                minDate: '0',
                maxDate: '2Y'

            });

            $("#CALENDARIO2").datepicker({

                dateFormat: 'yy-mm-dd',
                minDate: '0',
                maxDate: '2Y'

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


        function setingDateFim() {

            var dataInicio = $.datepicker.formatDate("yy-mm-dd", $("#CALENDARIO").datepicker("getDate"))
            //dataInicio= $('#CALENDARIO').datepicker("setDate", dataInicio.getDate() + 1 );

            if (dataInicio != "") {

                dataInicio = dataInicio.replace("-", ",");
                //dataInicio = dataInicio.replace("-", ",");
                alert(dataInicio)
                $("#CALENDARIO2").datepicker('option', {
                    minDate: new Date(dataInicio),
                    maxDate: '2Y'
                });

            }

        }

        function setingDateFim_V3() {

            var dateIni = $('#CALENDARIO').datepicker('getDate');
            var date2 = new Date('yy-mm-dd')
            date2 = date2.getTime()
            date2.setDate(dateIni.getDate() + 1)

            // var dataInicio = $.datepicker.formatDate("yy-mm-dd",date2)

            if (date2 != "") {

                // dataInicio = $.datepicker.parseDate( dateFormat, dataInicio);
                date2 = date2.replace("-", ",");
                $("#CALENDARIO2").datepicker('option', {
                    minDate: new Date(date2),
                    maxDate: '2Y'
                });
            }

        }


        /*function setingDateFim_v2(this){
    	    
    	    var inicio = input.value;
			inicio = inicio.replace("-", ",");
			inicio = inicio.replace("-", ",");
		//	$('#CALENDARIO2').datepicker('option', 'minDate', new Date(inicio));
    	    
    	}*/

        /* function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }*/
    </script>
</body>


</html>