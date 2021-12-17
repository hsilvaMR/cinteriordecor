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

        // $existe = mysqli_num_rows(mysqli_query($lnk, "SELECT * FROM voucher_unico WHERE id='$id'  LIMIT 1"));

        $query = mysqli_query($lnk, "SELECT * FROM voucher_unico WHERE id='$id' LIMIT 1");
        $row = mysqli_fetch_assoc($query);

        if (!empty($row['codigo'])) {

            //extract(mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM vales_desconto WHERE id='$id'")));
            $id_url = urldecode($urlPartes[3]);
        }

        $sep = 17;
        if (!$row) {
            $sub = 17.2;
        }
        include '_menu.php';
        ?>

        <div class="conteudo">
            <div class="linha">
                <div class="titulo">
                    <h1><? if ($row) {
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

            <!-- FORMULARIO  formEdit -->
            <div class="linha">
                <div class="coluna1">
                    <div class="corpo">

                        <form id="<? if ($id) {
                                        echo "formEdit";
                                    } else {
                                        echo "formVoucher";
                                    } ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="call" value="<? if ($id) {
                                                                        echo "edit";
                                                                    } else {
                                                                        echo "add";
                                                                    } ?>">
                            <input type="hidden" name="id" value="<? if ($row) {
                                                                        echo  $id;
                                                                    } ?>">

                            <div class="corpoCima">
                                <div class="grupo">
                                    <div class="grupoEsq">Nome:</div>
                                    <div class="grupoDir">
                                        <input type="text" class="inP" id="idName" name="nome" value="<? if ($row) {
                                                                                                            echo $row['nome'];
                                                                                                        } ?>" autofocus placeholder='Designação Voucher'>
                                    </div>
                                </div>

                                <div class="grupo">
                                    <div class="grupoEsq">Descrição:</div>
                                    <div class="grupoDir">
                                        <input type="text" class="inP" id="descrID" name="descricao" value="<? if ($row) {
                                                                                                                echo $row['descricao'];
                                                                                                            } ?>" autofocus placeholder='Descrição'>
                                    </div>
                                </div>

                                <div class="grupo">
                                    <div class="grupoEsq">Código:</div>
                                    <div class="grupoDir">
                                        <input type="text" class="inP" id="cdVouhcer" name="codigo" readonly value="<? if ($row) {
                                                                                                                        echo $row['codigo'];
                                                                                                                    } ?>" autofocus placeholder='Código do Voucher'>
                                    </div>
                                </div>

                                <div class="grupo">
                                    <div class="grupoEsq">Valor:</div>
                                    <div class="grupoDir">
                                        <input type="text" class="inP" maxlength="6" name="valor" onkeypress="return onlyNumberKey(event)" value="<? if ($row) {
                                                                                                                                                        echo $row['valor'];
                                                                                                                                                    } ?>" autofocus placeholder='Valor do voucher'>
                                    </div>
                                </div>
                                <div class="grupo">
                                    <div class="grupoEsq">Incio:</div>
                                    <div class="grupoDir">
                                        <input type="text" class="inP" name="inicio" id="CALENDARIO" maxlength="10" value="<? if ($row) {
                                                                                                                                echo $row['inicio'];
                                                                                                                            } ?>" onchange="settingCalendario()">
                                    </div>
                                </div>

                                <div class="grupo">
                                    <div class="grupoEsq">Fim:</div>
                                    <div class="grupoDir">

                                        <input type="text" class="inP" name="fim" id="CALENDARIO2" maxlength="10" value="<? if ($row) {
                                                                                                                                echo $row['fim'];
                                                                                                                            } ?>">
                                    </div>
                                </div>


                                <div class="grupo">
                                    <div class="grupoEsq">Tipo:</div>
                                    <div class="grupoDir">

                                        <select id="history" class="seL" name="tipo">
                                            <option class="selS" disabled selected>Tipo de Voucher</option>
                                            <option class="selS" value="vale" <? if ($row['tipo'] == 'vale') {
                                                                                    echo "selected";
                                                                                } ?>>Vale</option>
                                            <option class="selS" value="cupao" <? if ($row['tipo'] == 'cupao') {
                                                                                    echo "selected";
                                                                                } ?>>Cupão </option>
                                            <option class="selS" value="family" <? if ($row['tipo'] == 'family') {
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
            // generateVoucher()
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

        // setting calendario and day
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

        // generate voucher
        function generateVoucher() {
            var call = "generate"
            $.ajax({
                url: "/admin/_vales/voucherNovo.php",
                type: "POST",
                // dataType: "text",
                data: {
                    call: call
                },
                // contentType: false,
                cache: false,
                //processData: false,
                success: function(response) {

                    if (response != "") {
                        document.getElementById("cdVouhcer").value = response
                        // alert(document.getElementById("cdVouhcer").value)
                    } else {
                        alert("ERror")
                    }
                },
                error: function(xhr) {
                    //alert(ajaxContext.responseText)

                    console.log(xhr.status)
                    console.log(xhr.statusText)
                    console.log(xhr.readyState)
                    console.log(xhr.responseText)
                    alert(xhr.responseText)

                }
            });
        }
        $(document).ready(function() {

            var inicio = "<? echo $id; ?>"
            var id = "<? echo $row['id'];  ?>"

            if (inicio == "") {

                generateVoucher()
            } else {


                // alert("id: "+ id)
            }



        })

        function onlyNumberKey(evt) {
            // Only ASCII character in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }



        // update voucher 
        $("#formEdit").on('submit', (function(e) {

            e.preventDefault();
            $.ajax({
                url: "/admin/_vales/voucherNovo.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {

                    var jsonRetorna = $.parseJSON(data);
                    var result = jsonRetorna['result'];
                    var error = jsonRetorna['error'];

                    if (result == "update") {
                        alert("UPDATE FIELD");
                        $('#formEdit').trigger("reset");
                    } else {

                        switch (error) {
                            case 'empty_id':
                                alert("empty ID .");
                                break;
                            case 'empty_field':
                                alert("empty FIELD .");
                                break;
                            default:
                                alert("failure dataBase ...");
                                break;
                        }

                    }
                }
            });
        }));


        // add  voucher
        $("#formVoucher").on('submit', (function(e) {

            e.preventDefault();
            $.ajax({
                url: "/admin/_vales/voucherNovo.php",
                type: "POST",
                data: new FormData(this),
                contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
                cache: false,
                processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
                success: function(data) {

                    var jsonRetorna = $.parseJSON(data);
                    var result = jsonRetorna['result'];
                    var error = jsonRetorna['error'];

                    if (result == "adicionado") {
                        mostrar('GUARDAR');
                        $('#formVoucher').trigger("reset");

                    } else if (result == "update") {

                        //alert(result.":".jsonRetorna['id']);  
                        $('#formVoucher').trigger("reset");
                    } else {

                        switch (error) {
                            case 'existe':
                                alert("Voucher existe ! Deve Criar outro.");
                                break;
                            case 'empty':
                                alert("Deve prencher os Campos !");
                                break;
                            case 'empty_id':
                                alert(" send id update ... !");
                                break;
                            default:
                                alert("failure dataBase ...");
                                break;
                        }

                    }
                }
            });
        }));
    </script>
</body>


</html>