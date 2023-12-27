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
                    <span style="color:#FFF; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif">CHAMADO N°:</span><span
                        style="color:#FFf; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif"> <?php echo "# $numero "; ?></span></strong>
            </h3></td>
    </tr>
    <tr>
        <td align='center'></td>
    </tr>
    <tr>
        <td><table width='500' border='0' align='center' cellpadding='0' cellspacing='0' style="margin-top:10px">

                <tr>
                    <td colspan="2"><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Cliente:</strong></span><span> <?php echo $chamado['Chamado']['CDCLIENTE']; ?> - <?php echo $chamado['Chamado']['NMCLIENTE']; ?> </span></td>
                </tr>
                <tr>
                    <td width="241"><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Data Abertura:</strong></span></td>
                    <td width="259"><span class='style4'><?php echo date('d/m/Y', strtotime($chamado['Chamado']['DTINCLUSAO'])); ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Hora Abertura:</strong></span></td>
                    <td><span><?php echo $chamado['Chamado']['HRINCLUSAO']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Data Prevista Atendimento:</strong></span></td>
                    <td><span><?php echo date('d/m/Y', strtotime($chamado['Chamado']['DTPREVENTREGA'])); ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Contato:</strong></span></td>
                    <td><span><?php echo $chamado['Chamado']['CONTATO']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Telefone:</strong></span></td>
                    <td><span><?php echo $chamado['Chamado']['DDD']; ?> - <?php echo $chamado['Chamado']['FONE']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Email:</strong></span></td>
                    <td><span><?php echo $chamado['Chamado']['EMAIL']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Local de Instalação:</strong></span></td>
                    <td><span><?php echo $equipamento['Equipamento']['LOCALINSTAL']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Endereço:</strong></span></td>
                    <td><span><?php echo $chamado['Chamado']['ENDERECO']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Complemento:</strong></span></td>
                    <td><span><?php echo $chamado['Chamado']['COMPLEMENTO']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Numero:</strong></span></td>
                    <td><span><?php echo $chamado['Chamado']['NUM']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Cidade:</strong></span></td>
                    <td><span><?php echo $chamado['Chamado']['CIDADE']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>CEP:</strong></span></td>
                    <td><span><?php echo $chamado['Chamado']['CEP']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Bairro:</strong></span></td>
                    <td><span><?php echo $chamado['Chamado']['BAIRRO']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>UF:</strong></span></td>
                    <td><span><?php echo $chamado['Chamado']['UF']; ?> </span></td>
                </tr>
                <tr>
                    <td colspan='2'><hr /></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Equipamento:</strong></span></td>
                    <td><span><?php echo $chamado['Chamado']['CDEQUIPAMENTO']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Série:</strong></span></td>
                    <td><span><?php echo $equipamento['Equipamento']['SERIE']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Patrimônio:</strong></span></td>
                    <td><span> <?php echo $equipamento['Equipamento']['PATRIMONIO']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Modelo:</strong></span></td>
                    <td><?php echo $equipamento['Equipamento']['MODELO']; ?> </td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Departamento:</strong></span></td>
                    <td><?php echo $equipamento['Equipamento']['DEPARTAMENTO']; ?> </td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Tipo:</strong></span></td>
                    <td><span><?php
                            if ($chamado['Chamado']['TPORCATEND']=='A') {
                                echo 'Atendimento';
                            }else{
                                echo 'Orçamento';
                            }
                            ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Tipo O.S:</strong></span></td>
                    <td><span> Chamado Web </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Tipo Defeito:</strong></span></td>
                    <td><span><?php echo $defeito['Defeito']['NMDEFEITO']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Status:</strong></span>></td>
                    <td><span>Aberto</span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Observação relatada pelo cliente:</strong></span></td>
                    <td><span><em><?php echo $chamado['Chamado']['OBSDEFEITOCLI'] ?> </em></span></td>
                </tr>
                <tr>
                    <td colspan='2'>&nbsp;</td>
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