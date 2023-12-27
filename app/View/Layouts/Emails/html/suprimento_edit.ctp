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
                    <td align='left'><img style="max-height: 100px;height:auto" src="<?php echo $auth_user['EmpresaSelected']['Empresa']['logo']; ?>"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align='center' valign="middle" bgcolor='#012B49'><h3 style="margin-top:20px"><strong><br>
                    <span style="color:#FFF; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif">ALTERA&Ccedil;&Atilde;O SOLICITAÇÃO  N°:</span><span
                        style="color:#FFf; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif"> <?php echo $numero; ?></span></strong>
            </h3></td>
    </tr>
    <tr>
        <td align='center'></td>
    </tr>
    <tr>
        <td align="center"><span style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif"><p>
                    Ol&aacute; <?php echo $solicitacao['contato']; ?>,</p></span>
            <p><span style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif">Houve uma altera&ccedil;&atilde;o no status da sua solicita&ccedil;&atilde;o de suprimento.</span><br>
                <span style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif"><strong>Status: <?php
                        switch ($solicitacao['status']) {
                            case 'P':
                                echo "Pendente";
                                break;
                            case 'O':
                                echo "Concluída";
                                break;
                            case 'T':
                                echo "Em Trânsito";
                                break;
                            case 'C':
                                echo 'Cancelada/Rejeitada';
                                break;
                            case 'E':
                                echo "Em Análise";
                                break;
                            case 'L':
                                echo "Liberada";
                                break;
                        }

                        ?></strong></span></p>

            <table width='500' border='0' align='center' cellpadding='0' cellspacing='0' style="margin-top:10px">

                <tr>
                    <td colspan="2"><span
                            style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif"><strong>Cliente:</strong></span><span> <?php echo $solicitacao['NMCLIENTE']; ?> </span>
                    </td>
                </tr>
                <tr>
                    <td width="241"><span
                            style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Data da
                                Solicitação:</strong></span></td>
                    <td width="259"><span class='style4'><?php echo $solicitacao['created']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Contato:</strong></span>
                    </td>
                    <td><span><?php echo $solicitacao['contato']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Telefone:</strong></span>
                    </td>
                    <td><span><?php echo $solicitacao['fone']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Email:</strong></span>
                    </td>
                    <td><span><?php echo $solicitacao['email']; ?> </span></td>
                </tr>
                <tr>
                    <td colspan='2'>
                        <hr/>
                    </td>
                </tr>
                <?php if (empty($solicitacao['contrato_id'])) { ?>
                    <tr>
                        <td><span style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif"><strong>Equipamento:</strong></span>
                        </td>
                        <td><span></span></td>
                    </tr>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Série:</strong></span>
                        </td>
                        <td><span><?php echo $solicitacao['SERIE']; ?></span></td>
                    </tr>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Patrimônio:</strong></span>
                        </td>
                        <td><span> <?php echo $solicitacao['PATRIMONIO']; ?></span></td>
                    </tr>

                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Modelo:</strong></span>
                        </td>
                        <td><?php echo $solicitacao['MODELO']; ?></td>
                    </tr>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Departamento:</strong></span>
                        </td>
                        <td><?php echo $solicitacao['DEPARTAMENTO']; ?> </td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Modelo:</strong></span>
                        </td>
                        <td><?php echo $solicitacao['modelo']; ?></td>
                    </tr>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Cidade:</strong></span>
                        </td>
                        <td><span><?php echo $solicitacao['cidade']; ?></span></td>
                    </tr>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Local Instalação:</strong></span>
                        </td>
                        <td><span> <?php echo $solicitacao['localinstal']; ?></span></td>
                    </tr>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Departamento:</strong></span>
                        </td>
                        <td><?php echo $solicitacao['departamento']; ?> </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan='2'>
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td><span style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif"><strong>Transportadora:</strong></span>
                    </td>
                    <td><span><?php echo $solicitacao['transportadora']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>C&oacute;digo
                                de Rastreio:</strong></span></td>
                    <td><span><?php echo $solicitacao['cdrastreio']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Nr Da
                                Nota:</strong></span></td>
                    <td><span><?php echo $solicitacao['NRNFSAIDA']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Data
                                de emiss&atilde;o NF:</strong></span></td>
                    <td><span><?php echo $solicitacao['DTEMISSAONFS']; ?></span></td>
                </tr>

                <tr>
                    <td colspan='2'>&nbsp;</td>
                </tr>
            </table>
            <p><span style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif">Para ver mais detalhes da sua solicita&ccedil;&atilde;o</span>
            </p>
            <p><a href="<?php echo $solicitacao['url']; ?>" style="
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