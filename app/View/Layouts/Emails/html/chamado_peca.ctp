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
                    <td align='left'><img src="http://softilux.com.br/portal/demo/portal/imagens/logo.png"></td>
                </tr>
            </table></td>
    </tr>
    <tr>
        <td align='center' valign="middle" bgcolor='#012B49'><h3 style="margin-top:20px"><strong><br>
                    <span style="color:#FFF; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" >ALTERA&Ccedil;&Atilde;O DE CHAMADO N°:</span><span style="color:#FFf; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" > <?php echo $numero; ?></span></strong></h3></td>
    </tr>
    <tr>
        <td align='center'></td>
    </tr>
    <tr>
        <td><table width='500' border='0' align='center' cellpadding='0' cellspacing='0' style="margin-top:10px">

                <tr>
                    <td colspan="2"><span style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif"><strong>Cliente:</strong></span><span> <?php echo $chamado['NMCLIENTE']; ?> </span></td>
                </tr>
                <tr>
                    <td width="241"><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Data Abertura:</strong></span></td>
                    <td width="259"><span class='style4'><?php echo $chamado['DTINCLUSAO']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Data de Altera&ccedil;&atilde;o:</strong></span></td>
                    <td><span><?php echo $chamado['DTALTERACAO']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Data de Atendimento:</strong></span></td>
                    <td><span><?php echo $chamado['DTATENDIMENTO']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Tempo de Atendimento:</strong></span></td>
                    <td><span><?php echo $chamado['TEMPOATENDIMENTO']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Local de Instalação:</strong></span></td>
                    <td><span><?php echo $chamado['LOCALINSTAL']; ?> </span></td>
                </tr>
                <tr>
                    <td colspan='2'><hr /></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Equipamento:</strong></span></td>
                    <td><span><?php echo $chamado['CDEQUIPAMENTO']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Série:</strong></span></td>
                    <td><span><?php echo $chamado['SERIE']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Patrimônio:</strong></span></td>
                    <td><span> <?php echo $chamado['PATRIMONIO']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Modelo:</strong></span></td>
                    <td><?php echo $chamado['MODELO']; ?> </td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Departamento:</strong></span></td>
                    <td><?php echo $chamado['DEPARTAMENTO']; ?> </td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Status:</strong></span></td>
                    <td><span>Aberto</span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Follow-up do t&eacute;cnico:</strong></span></td>
                    <td><span><em><?php echo $chamado['OBSERVACAO'] ?></em></span></td>
                </tr>
                <tr>
                    <td colspan='2' align="center"> <p><span style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif">Para ver mais detalhes deste Chamado</span></p>
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
                    <td width='441'><p><strong><?php echo $auth_user['Empresa']['empresa_nome']; ?><br />
                                Endereço: </strong><?php echo $auth_user['Empresa']['endereco']; ?>, <?php echo $auth_user['Empresa']['numero']; ?> <?php echo $auth_user['Empresa']['complemento']; ?><br />
                            Fone: <?php echo $auth_user['Empresa']['ddd'] ; ?> <?php echo $auth_user['Empresa']['fone']; ?></p></td>
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