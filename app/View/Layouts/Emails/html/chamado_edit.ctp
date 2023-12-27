<html>
<head>
    <meta http-equiv=Content-Type content=text/html; charset=iso-8859-1>
</head>
<body style="background:#DDD">
<table width='635'>
    <tr>
        <td height="20"></td>
    </tr>
</table>
<table width='635' style="background-color:#FFF;" border='0' align='center' cellpadding='0' cellspacing='0'>
    <tr>
        <td>
            <table width='100%' border='0'>
                <tr>
                    <td align='left'><img src="<?php echo $auth_user['EmpresaSelected']['Empresa']['logo']; ?>"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align='center' valign="middle" bgcolor='#012B49'><h3 style="margin-top:20px"><strong>
                    <span style="color:#FFF; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif"><?php if (!isset($chamado['app']['peca'])){ echo 'ALTERA&Ccedil;&Atilde;O DE CHAMADO N°:';}else{echo 'Solicitação de Peça - CHAMADO N°:';} ?></span><span
                        style="color:#FFf; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif"> <?php echo "# $numero / {$chamado['SEQOS']}"; ?></span></strong>
            </h3></td>
    </tr>
    <tr>
        <td align='center'></td>
    </tr>
    <tr>
        <td>
            <table width='500' border='0' align='center' cellpadding='0' cellspacing='0' style="margin-top:10px">

                <tr>
                    <td colspan="2"><span
                            style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Cliente:</strong></span><span> <?php echo $chamado['NMCLIENTE']; ?> </span>
                    </td>
                </tr>
                <tr>
                    <td width="241"><span
                            style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Data
                                Abertura:</strong></span></td>
                    <td width="259"><span class='style4'><?php echo $chamado['DTINCLUSAO'].' '.$chamado['HRINCLUSAO']; ?></span></td>
                </tr>
                <?php if (!isset($chamado['app']['peca'])): ?>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Data
                                    de Altera&ccedil;&atilde;o:</strong></span></td>
                        <td><span><?php echo $chamado['DTALTERACAO']; ?> </span></td>
                    </tr>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Data
                                    de Atendimento:</strong></span></td>
                        <td><span><?php echo $chamado['DTATENDIMENTO']; ?></span></td>
                    </tr>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Tempo
                                    de Atendimento:</strong></span></td>
                        <td><span><?php echo $chamado['TEMPOATENDIMENTO']; ?> min </span></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Local
                                de Instalação:</strong></span></td>
                    <td><span><?php echo $chamado['LOCALINSTAL']; ?> </span></td>
                </tr>
                <tr>
                    <td colspan='2'>
                        <hr/>
                    </td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Equipamento:</strong></span>
                    </td>
                    <td><span><?php echo $chamado['CDEQUIPAMENTO']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Série:</strong></span>
                    </td>
                    <td><span><?php echo $chamado['SERIE']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Patrimônio:</strong></span>
                    </td>
                    <td><span> <?php echo $chamado['PATRIMONIO']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Modelo:</strong></span>
                    </td>
                    <td><?php echo $chamado['MODELO']; ?> </td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Departamento:</strong></span>
                    </td>
                    <td><?php echo $chamado['DEPARTAMENTO']; ?> </td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Status:</strong></span>
                    </td>
                    <td><span><?php echo $chamado['STATUS']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Follow-up
                                do t&eacute;cnico:</strong></span></td>
                    <td><span><em><?php echo $chamado['OBSERVACAO'] ?></em></span></td>
                </tr>
                <?php if (isset($this->request->data['Peca']) && count($chamado['Peca']) > 0): ?>
                    <?php foreach ($chamado['Peca'] as $key => $peca) { ?>
                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td height="19"><span
                                    style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif">
                                    <strong>Solicita&ccedil;&atilde;o de Pe&ccedil;a <?php echo $key; ?>:</strong>
                                </span>
                            </td>
                            <td><span><em><?php echo $peca['CDPRODUTO'] ?></em></span></td>
                        </tr>
                        <tr>
                            <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Produto
                                        Equiv:</strong></span></td>
                            <td><span><em><?php echo $peca['CDPRODUTO2'] ?></em></span></td>
                        </tr>
                        <tr>
                            <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Quantidade:</strong></span>
                            </td>
                            <td><span><em><?php echo $peca['QUANTIDADE'] ?></em></span></td>
                        </tr>
                    <?php } ?>
                <?php endif; ?>
                        
                <?php if (isset($chamado['app']['peca']) && count($chamado['app']['peca']) > 0): ?>
                    <?php foreach ($chamado['app']['peca'] as $key => $peca) { ?>
                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td height="19"><span
                                    style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif">
                                    <strong>Pe&ccedil;a (<?php echo $key + 1; ?>):</strong>
                                </span>
                            </td>
                            <td><span><em><?php echo $peca->produto ?></em></span></td>
                        </tr>
                        <tr>
                            <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Quantidade:</strong></span></td>
                            <td><span><em><?php echo $peca->qtd ?></em></span></td>
                        </tr>
                        <tr>
                            <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Status:</strong></span>
                            </td>
                            <td><span><em><?php echo $peca->status ?></em></span></td>
                        </tr>
                        <tr>
                            <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Peça crítica:</strong></span>
                            </td>
                            <td><span><em><?php echo $peca->critica ?></em></span></td>
                        </tr>
                        <tr>
                            <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Devolução:</strong></span>
                            </td>
                            <td><span><em><?php echo $peca->devolucao ?></em></span></td>
                        </tr>
                    <?php } ?>
                <?php endif; ?>
                <tr>
                    <td colspan='2' align="center">
                        <p>&nbsp;</p>
                        <p><span style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif">Para ver mais detalhes deste Chamado</span>
                        </p>
                        <p><a href="<?php echo $chamado['url']; ?>" style="
	background-color:#0260a3;
	-moz-border-radius:4px;
	-webkit-border-radius:4px;
	border-radius:4px;
	border:1px solid #0260a3;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:16px;
	font-weight:bold;
	padding:16px 31px;
	text-decoration:none;">Acesse Aqui</a></p>
                        <p>&nbsp;</p></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>
            <table width='100%' border='0'>
                <tr>
                    <td colspan='2'>
                        <hr/>
                    </td>
                </tr>
                <tr>
                    <td colspan='2' align='center' style='font-style: italic;'>Esta mensagem foi enviada por um sistema
                        automático. Por favor, não responda a
                        este e-mail diretamente.
                    </td>
                </tr>
                <tr>
                    <td width='441'><p><strong><?php echo $auth_user['EmpresaSelected']['Empresa']['empresa_nome']; ?>
                                <br/>
                                Endereço: </strong><?php echo $auth_user['EmpresaSelected']['Empresa']['endereco']; ?>
                            , <?php echo $auth_user['EmpresaSelected']['Empresa']['numero']; ?> <?php echo $auth_user['EmpresaSelected']['Empresa']['complemento']; ?>
                            <br/>
                            Fone: <?php echo $auth_user['EmpresaSelected']['Empresa']['ddd']; ?> <?php echo $auth_user['EmpresaSelected']['Empresa']['fone']; ?>
                        </p></td>
                    <td width='49' align='center'>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table width='635'>
    <tr>
        <td height="20"></td>
    </tr>
</table>
</body>
</html>