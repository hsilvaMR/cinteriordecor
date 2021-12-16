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

                        <form id="formVoucher" method="post" enctype="multipart/form-data">

                            <input type="hidden" name="call" value="add">
                            <input type=" hidden" name="id" value="<? if ($existe) {
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
                                        <input type="text" class="inP" name="descricao" value="<? echo $nome ?>" autofocus placeholder='Descrição'>
                                    </div>
                                </div>

                                <div class="grupo">
                                    <div class="grupoEsq">Código:</div>
                                    <div class="grupoDir">
                                        <input type="text" id="cdVouhcer" readonly class="inP" name="codigo" value="<? echo $nome ?>" autofocus placeholder='Código do Voucher'>
                                    </div>
                                </div>

                                <div class="grupo">
                                    <div class="grupoEsq">Valor:</div>
                                    <div class="grupoDir">
                                        <input type="text" class="inP" maxlength="6" name="valor" onkeypress="return onlyNumberKey(event)" name="valor" value="<? echo $nome ?>" autofocus placeholder='Valor do voucher'>
                                    </div>
                                </div>

                                <div class="grupo">
                                    <div class="grupoEsq">Incio:</div>
                                    <div class="grupoDir">
                                        <? if ($data_fim == '0000-00-00') {
                                            $data_fim = "";
                                        } ?>
                                        <input type="text" class="inP" name="inicio" id="CALENDARIO2" maxlength="10" value="<? echo $data_fim ?>" onchange="mudaCal2(this);">
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
                                        <select id="history" class="seL" name="tipo" onchange="historyChanged(this);">
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

        generateVoucher();

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


    function settingCalendario() {

        var dataInicio = $.datepicker.formatDate("yy-mm-dd", $("#CALENDARIO").datepicker("getDate"))
        var novaData = settingDia(dataInicio)

        if (novaData != "") {

            //dataInicio = dataInicio.replace("-", ",");
            $("#CALENDARIO2").datepicker('option', {
                minDate: new Date(novaData),
                maxDate: '2Y'
            });
        }
    }

    function settingDia(date) {

        var dia = date.slice(8) // captura o dia na string data 
        var novoDia = parseInt(dia) + 1 // acrescenta 1 dia,  no dia capturado
        var novaData = date.substring(0, date.length - 2); // remove o dia na data atual 
        novaData = novaData + novoDia.toString() // acrescenta um dia a mais , na nova data 

        return novaData;
    }


    function setingDateFim_V4() {

        var dataInicio = $.datepicker.formatDate("yy-mm-dd", $("#CALENDARIO").datepicker("getDate"))
        var sliceDay = dataInicio.slice(8)
        alert(sliceDay)
        var newdAY = parseInt(sliceDay)
        alert(newdAY)
        newdAY = newdAY + 1;
        alert(newdAY)
        var newDate = dataInicio.substring(0, dataInicio.length - 2);
        newDate = newDate + newdAY.toString()
        alert(newDate)
        if (dataInicio != "") {
            // dataInicio = $.datepicker.parseDate( dateFormat, dataInicio);
            dataInicio = dataInicio.replace("-", ",");
            $("#CALENDARIO2").datepicker('option', {
                minDate: new Date(newDate),
                maxDate: '2Y'
            });
        }
    }

    // add voucher 
    $(document).ready(function(e) {
        $("#formVoucher").on('submit', (function(e) {
            //mostrar('LOADING');
            e.preventDefault();
            $.ajax({
                url: "/admin/_vales/voucherNovo.php",
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

    // generate voucher

    function generateVoucher() {

        var call = "generate"
        $.ajax({
            url: "/admin/_vales/voucherNovo.php",
            type: "POST",
            data: {
                call: call,
            },
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                var jsonRetorna = $.parseJSON(data);
                var result = jsonRetorna['result'];
                var codigo = jsonRetorna['codigo'];

                if (result == "sucess") {
                    document.getElementById("cdVouhcer").value = codigo
                } else {

                    alert("ERror")
                }
            }
        });
    }

    // only number
    function onlyNumberKey(evt) {

        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>

</html>