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
                        } ?> Vale de Desconto<h1>
                            <a href="/admin/painel">Painel</a>
                            <div class="ponto"></div>
                            <a href="/admin/vales">Vales de Desconto</a>
                            <div class="ponto"></div>
                            <a href="">Vale de Desconto</a>
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
                                        <? if ($data_fim == '0000-00-00') {
                                            $data_fim = "";
                                        } ?>
                                        <input type="text" class="inP" name="fim" id="CALENDARIO2" maxlength="10" value="<? echo $data_fim ?>" onchange="mudaCal2(this);">
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
</body>

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

        var myDate = new Date('yy-mm-dd');
        var today = myDate.getTime();

        //seting datapicker
        $('#CALENDARIO').datepicker({

            dateFormat: 'yy-mm-dd',
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "images/calendar.gif",
            buttonImageOnly: true,
            minDate: new Date(today),
            maxDate: '+30Y',
            inline: true
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

    function setingDateFim(dateInicio) {

        /*var myDate  =  new Date('yy-mm-dd');
        var today = myDate.getTime();*/

        ///dateInicio = document.getElementById("CALENDARIO").value
        var dataFim = new Date(dateInicio.value)
        dataFim.setDate(dataFim.getDate() + 1);

        var minDate = dataFim;

        $('#CALENDARIO2').datepicker('option', 'minDate', new Date(minDate));


        /*if (today < date){


        }*/

    }

    function setingDateFim_v2() {

        var d = new Date();
        d.setDate(d.getDate() + 1);
        $('#txtStartDate').datepicker('setDate', d);
        d = new Date();
        d.setDate(d.getDate() + 4);
        $('#txtEndDate').datepicker('setDate', d);

    }

    function setingDateFim_V3() {

        var dataInicio = $.datepicker.formatDate("yy-mm-dd", $("#CALENDARIO").datepicker("getDate", "+1D"))

        if (dataInicio != "") {

            // dataInicio = $.datepicker.parseDate( dateFormat, dataInicio);
            dataInicio = dataInicio.replace("-", ",");
            $("#CALENDARIO2").datepicker('option', {
                minDate: new Date(dataInicio),
                maxDate: '2Y'
            });
        }

    }
</script>

</html>