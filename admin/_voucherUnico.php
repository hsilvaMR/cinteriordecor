<div class="linhaScroll">
    <div class="coluna1">
        <div class="corpo tabelaBorda">
            <div class="tabelaHead">VALES DE DESCONTO</div>
            <div class="linhaScroll">
                <table id="sortable" class="listagem">
                    <thead>
                        <tr>
                            <th class="none"></th>
                            <th class="compMin">#&ensp;</th>
                            <th>Nome</th>
                            <th>Código</th>
                            <th>Desconto</th>
                            <th>Período</th>
                            <th>Opção</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? $risca = 1;
                        $hoje = date('Y-m-d');
                        $query = mysqli_query($lnk, "SELECT * FROM vales_desconto ORDER BY data_fim DESC");
                        while ($linha = mysqli_fetch_array($query)) {
                            $id = $linha["id"];
                            $nome = $linha["nome"];
                            $codigo = $linha["codigo"];
                            $tipo = $linha["tipo"];
                            $inicio = $linha["data_inicio"];
                            $fim = $linha["data_fim"];

                            $tipo = $linha["tipo"];
                            $valor_desconto = $linha["valor_desconto"];
                            $valor_condicao = $linha["valor_condicao"];
                            $gratis = $linha["gratis"];



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
                                <td><? echo $codigo ?></td>
                                <td>
                                    <?
                                    if ($tipo == 'acima_de') {
                                        echo "Acima de $valor_condicao € <br>";
                                        if ($valor_desconto > 0) {
                                            echo "Desconto de $valor_desconto % <br>";
                                        } elseif ($gratis == 1) {
                                            echo "<span class=\"labelRoxo\">Portes gratuitos</span>";
                                        }
                                    } elseif ($tipo == 'desconto_perc') {
                                        echo "Desconto de $valor_desconto % <br>";
                                        if ($valor_condicao > 0) {
                                            echo "Acima de $valor_condicao € <br>";
                                        }
                                    } elseif ($tipo == 'cupao') {
                                        echo "Cupão de $valor_desconto € <br>";
                                        if ($valor_condicao > 0) {
                                            echo "Acima de $valor_condicao € <br>";
                                        }
                                    } else {
                                        echo "<span class=\"labelRoxo\">Portes gratuitos</span>";
                                    }

                                    ?>
                                </td>
                                <td>
                                    <!-- labelAmarelo labelVermelho labelVerde labelCinza labelRoxo labelAzul -->
                                    <? if ($inicio <= $hoje && $fim >= $hoje) { ?><span class="labelVerde"><? echo $inicio . ' a ' . $fim; ?></span>
                                    <? } elseif ($inicio > $hoje) { ?><span class="labelAmarelo"><? echo $inicio . ' a ' . $fim; ?>
                                        <? } else { ?><span class="labelCinza"><? echo $inicio . ' a ' . $fim; ?><? } ?>
                                </td>

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