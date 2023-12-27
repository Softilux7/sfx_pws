<html>
<head>
    <meta http-equiv=Content-Type content=text/html; charset=iso-8859-1>
</head>
<body style="background:#DDD">
<table  width='635'><tr><td height="20"></td></tr></table>
<table width='635' style="background-color:#FFF;" border='0' align='center' cellpadding='0' cellspacing='0'>
    <tr>
        <td><table width='100%' border='0' >
                <tr>
                    <td align='left'><img src="<?php echo $auth_user['EmpresaSelected']['Empresa']['logo']; ?>"></td>
                </tr>
            </table></td>
    </tr>
    <tr>
        <td align='center' valign="middle" bgcolor='#012B49'><h3 style="margin-top:20px"><strong><br>
                    <span style="color:#FFF; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" >SOLICITAÇÃO N°:</span><span style="color:#FFf; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" > <?php echo $numero; ?></span></strong></h3></td>
    </tr>
    <tr>
        <td align='center'></td>
    </tr>
    <tr>
        <td><table width='500' border='0' align='center' cellpadding='0' cellspacing='0' style="margin-top:10px">

                <tr>
                    <td colspan="2"><span style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif"><strong>Cliente:</strong></span><span> <?php echo $solicitacao['Cliente']['CDCLIENTE']; ?> - <?php echo $solicitacao['Cliente']['NMCLIENTE']; ?> </span></td>
                </tr>
                <tr>
                    <td width="241"><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Data da Solicitação:</strong></span></td>
                    <td width="259"><span class='style4'><?php echo $solicitacao['Solicitacao']['created']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Contato:</strong></span></td>
                    <td><span><?php echo $solicitacao['Solicitacao']['contato']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Telefone:</strong></span></td>
                    <td><span><?php echo $solicitacao['Solicitacao']['fone']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Email:</strong></span></td>
                    <td><span><?php echo $solicitacao['Solicitacao']['email']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Local de Instalação:</strong></span></td>
                    <?php if (!empty($solicitacao['Equipamento']['LOCALINSTAL'])){ ?>
                        <td><span><?php echo $solicitacao['Equipamento']['LOCALINSTAL']; ?> </span></td>
                    <?php } else { ?>
                        <td><span><?php echo $solicitacao['Solicitacao']['localinstal']; ?> </span></td>
                    <?php } ?>
                </tr>

                <?php if (!empty($solicitacao['Equipamento']['ENDERECO'])){ ?>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Endereço:</strong></span></td>
                        <td><span><?php echo $solicitacao['Equipamento']['ENDERECO']; ?> </span></td>
                    </tr>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Complemento:</strong></span></td>
                        <td><span><?php echo $solicitacao['Equipamento']['COMPLEMENTO']; ?> </span></td>
                    </tr>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Numero:</strong></span></td>
                        <td><span><?php echo $solicitacao['Equipamento']['NUM']; ?> </span></td>
                    </tr>
                <?php } ?>

                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Cidade:</strong></span></td>
                    <?php if (!empty($solicitacao['Equipamento']['CIDADE'])){ ?>
                        <td><span><?php echo $solicitacao['Equipamento']['CIDADE']; ?> </span></td>
                    <?php }  else { ?>
                        <td><span><?php echo $solicitacao['Solicitacao']['cidade']; ?> </span></td>
                    <?php } ?>
                </tr>

                <?php if (!empty($solicitacao['Equipamento']['CEP'])){ ?>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>CEP:</strong></span></td>
                        <td><span><?php echo $solicitacao['Equipamento']['CEP']; ?> </span></td>
                    </tr>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Bairro:</strong></span></td>
                        <td><span><?php echo $solicitacao['Equipamento']['BAIRRO']; ?> </span></td>
                    </tr>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>UF:</strong></span></td>
                        <td><span><?php echo $solicitacao['Equipamento']['UF']; ?> </span></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan='2'><hr /></td>
                </tr>
                <?php if (!empty($solicitacao['Equipamento']['CDEQUIPAMENTO'])){ ?>
                    <tr>
                        <td><span style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif"><strong>Equipamento:</strong></span></td>
                        <td><span><?php echo $solicitacao['Equipamento']['CDEQUIPAMENTO']; ?></span></td>
                    </tr>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Série:</strong></span></td>
                        <td><span><?php echo $solicitacao['Equipamento']['SERIE']; ?> </span></td>
                    </tr>
                    <tr>
                        <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Patrimônio:</strong></span></td>
                        <td><span> <?php echo $solicitacao['Equipamento']['PATRIMONIO']; ?></span></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Modelo:</strong></span></td>

                    <?php if (!empty( $solicitacao['Equipamento']['MODELO'])){ ?>
                        <td><?php echo $solicitacao['Equipamento']['MODELO']; ?> </td>
                    <?php } else { ?>
                        <td><?php echo $solicitacao['Solicitacao']['modelo']; ?> </td>
                    <?php } ?>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Departamento:</strong></span></td>
                    <?php if (!empty( $solicitacao['Equipamento']['DEPARTAMENTO'])){ ?>
                        <td><?php echo $solicitacao['Equipamento']['DEPARTAMENTO']; ?> </td>
                    <?php } else { ?>
                        <td><?php echo $solicitacao['Solicitacao']['departamento']; ?> </td>
                    <?php } ?>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Observação relatada pelo cliente:</strong></span></td>
                    <td><span><em><?php echo $solicitacao['Solicitacao']['obs'] ?> </em></span></td>
                </tr>
                <tr>
                    <td colspan='2'><hr>
                        <span style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif"><strong>Suprimentos / Serviços Solicitados:</strong></span>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Tipo</strong></span></td>
                                <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Quantidade</strong></span></td>

                            </tr>
                            <?php foreach ($suprimentos as $suprimentos): ?>
                                <tr>
                                    <td><?php echo $suprimentos['SuprimentoTipo']['nome_tipo']; ?></td>
                                    <td><?php echo $suprimentos['SolicitacaoSuprimento']['quantidade']; ?></td>

                                </tr>
                            <?php endforeach; ?>
                        </table></td>
                </tr>
            </table></td>
    </tr>
    <tr>
        <td ><table width='100%' border='0'>
                <tr>
                    <td colspan='2'><hr/></td>
                </tr>
                <tr>
                    <td colspan='2' align='center' style='font-style: italic;'>Esta mensagem foi enviada por um sistema automático. Por favor, não responda a
                        este e-mail diretamente.</td>
                </tr>
                <tr>
                    <td width='441'><p><strong><?php echo $auth_user['EmpresaSelected']['Empresa']['empresa_nome']; ?><br />
                                Endereço: </strong><?php echo $auth_user['EmpresaSelected']['Empresa']['endereco']; ?>, <?php echo $auth_user['EmpresaSelected']['Empresa']['numero']; ?> <?php echo $auth_user['EmpresaSelected']['Empresa']['complemento']; ?><br />
                            Fone: <?php echo $auth_user['EmpresaSelected']['Empresa']['ddd'] ; ?> <?php echo $auth_user['EmpresaSelected']['Empresa']['fone']; ?></p></td>
                    <td width='49' align='center'>&nbsp;</td>
                </tr>
            </table></td>
    </tr>
</table>
<table  width='635'>
    <tr>
        <td height="20"></td>
    </tr>
</table>
</body>
</html>