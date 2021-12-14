<div class="linhaScroll" style="margin-top: 15px;">
    <div class="coluna1">
        <div class="corpo tabelaBorda">
            <div class="tabelaHead">VAUCHER UNICO <label for="" style="background-color: red;"> Em Densevolvimento ! </label></div>
            <div class="linhaScroll">
                <table id="sortable1" class="listagem">
                    <thead>
                        <tr>
                            <th class="none"></th>
                            <th class="compMin">#&ensp;</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Codigo</th>
                            <th>Valor</th>
                            <th>Validade</th>
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
                            $validade = $linha["validade"];
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
                                <td><? echo $valor ?></td>
                                <td><? echo $validade ?></td>
                                <td><? echo $tipo ?></td>
                                <td><? echo $status ?> </td>
                                <td>
                                    <a href="/admin/vale/<? echo $id; ?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>&nbsp;&nbsp;
                                    <span class="opcoes" onclick="mostrar('APAGAR',<? echo $id; ?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
                                </td>
                            </tr>
                        <? } ?>
                    </tbody>
                </table>
            </div>
            <button class="btV margin-top20 floatr" onClick="window.location.href='/admin/vale';">ADICIONAR NOVO</button>
            <div class="clear"></div>
        </div>
    </div>
</div>