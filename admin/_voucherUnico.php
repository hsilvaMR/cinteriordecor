<div class="linhaScroll" style="margin-top: 15px;">
    <div class="coluna1">
        <div class="corpo tabelaBorda">
            <div class="tabelaHead" style="background: #FFC300;">VOUCHER UNICO Em Densevolvimento ... </div>
            <div class="linhaScroll">
                <table id="sortable1" class="listagem">
                    <thead>
                        <tr>
                            <th class="none"></th>
                            <th class="compMin">ID&ensp;</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Codigo</th>
                            <th>Valor</th>
                            <th> Periodo Vigente</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th style="text-align: center;">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        $risca = 1;
                        $hoje = date('Y-m-d');
                        $query = mysqli_query($lnk, "SELECT * FROM voucher_unico ORDER BY id DESC");
                        while ($linha = mysqli_fetch_array($query)) {
                            $id = $linha["id"];
                            $nome = $linha["nome"];
                            $descricao = $linha["descricao"];
                            $codigo = $linha["codigo"];
                            $valor = $linha["valor"];
                            $inicio = $linha["inicio"];
                            $fim = $linha["fim"];
                            $tipo = $linha["tipo"];
                            $status = $linha["status"];

                            if (($risca % 2) == 0) {
                                $classe = "tabelaFundoP";
                            } else {
                                $classe = "tabelaFundoI";
                            }
                            $risca++; ?>
                            <tr id="linha_<? echo $id ?>" class="<? echo $classe ?>">
                                <td class="none"></td>
                                <td><? echo $id ?></td>
                                <td><? echo $nome ?></td>
                                <td><? echo $descricao ?></td>
                                <td><? echo $codigo ?></td>
                                <td><? echo $valor . " € " ?></td>
                                <td><? echo $inicio . " a " . $fim ?></td>
                                <td><? echo $tipo ?></td>
                                <td><? echo $status ?> </td>
                                <td style="text-align: center;">
                                    <a href="/admin/voucherAction/<? echo $id; ?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>&nbsp;&nbsp;
                                    <span class="opcoes" onclick="mostrar('APAGAR_voucher',<? echo $id; ?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
                                </td>
                            </tr>
                        <? } ?>
                    </tbody>
                </table>
            </div>
            <button class="btV margin-top20 floatr" onClick="window.location.href='/admin/voucherAction.php';" style="background: #33FFB8;">Novo Voucher</button>
            <div class="clear"></div>
        </div>
    </div>

    <!-- MODALS voucher -->
    <div id="APAGAR_voucher" class="modal">
        <div class="modalFundo" onClick="esconder('APAGAR_voucher');"></div>
        <span class="modalClose lnr lnr-cross-circle" onClick="esconder('APAGAR_voucher');"></span>
        <div class="modalSize">
            <div class="modalHead">Apagar</div>
            <div class="modalBody">Tem a certeza que deseja apagar o voucher?</div>
            <div class="modalFoot">
                <button class="btV modalBt" name="sim" onclick="apagarVocuher()">SIM</button>
                <button class="btA modalBt" name="nao" onclick="esconder('APAGAR_voucher');">NÃO</button>
            </div>
        </div>
    </div>

    <script>
        $(document).keyup(function(e) {
            if (e.keyCode == 27) {
                esconder('APAGAR');
            }
        });

        function apagarVocuher() {
            var id_del = localStorage.getItem("id_del");
            var call = "delete"
            $.ajax({
                url: "/admin/_vales/voucherNovo.php",
                type: "POST",
                data: {

                    id_del: id_del,
                    call: call
                },
                cache: false,
                success: function(data) {

                    var jsonRetorna = $.parseJSON(data);
                    var result = jsonRetorna['result'];
                    if (result == "delete") {

                        //alert("removido com sucesso meu ID : " + id_del )
                        $('#linha_' + id_del).css("display", "none");
                        esconder('APAGAR_voucher');
                        $.notific8('voucher removido com sucesso.', {
                            heading: 'Apagado'
                        });
                        //localStorage.removeItem("id_del");
                    } else {

                        alert("delete error...")
                    }
                }

            })
        }
    </script>
</div>