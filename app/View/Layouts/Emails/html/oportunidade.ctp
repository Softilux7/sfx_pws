<html>
<head>
    <meta http-equiv=Content-Type content=text/html; charset=iso-8859-1>
</head>
<body style="background:#DDD">
<table width="635">
    <tbody>
    <tr>
        <td height="20">&nbsp;</td>
    </tr>
    </tbody>
</table>

<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color:#FFF;" width="635">
    <tbody>
    <tr>
        <td>
            <table border="0" width="100%">
                <tbody>
                <tr>
                    <td align="left"><img src="<?php echo $auth_user['EmpresaSelected']['Empresa']['logo']; ?>" /></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" bgcolor="#012B49" valign="middle">
            <h3 style="margin-top:20px"><br />
                <strong><span style="color:#FFF; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif">OPORTUNIDADE COMERCIAL:</span></strong></h3>
        </td>
    </tr>
    <tr>
        <td align="center">&nbsp;</td>
    </tr>
    <tr>
        <td>
            <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px" width="500">
                <tbody>
                <tr>
                    <td colspan="241"><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Cliente:</strong></span><span> <?php echo $oportunidade['Oportunidade']['NMCLIENTE']; ?></span></td>
                </tr>
                <tr>
                    <td width="241"><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Data da oportunidade identificada:</strong></span></td>
                    <td width="259"><span class="style4"><?php echo date('d-m-Y')?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Técnico:</strong></span></td>
                    <td><span><?php echo $oportunidade['Oportunidade']['NMSUPORTE']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Contato Cliente:</strong></span></td>
                    <td><span><?php echo $oportunidade['Oportunidade']['CONTATO']; ?> </span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Telefone Cliente:</strong></span></td>
                    <td><span><?php echo $oportunidade['Oportunidade']['TELEFONE']; ?></span></td>
                </tr>
                <tr>
                    <td><span style="font-family:'Courier New', Courier, monospace, Helvetica, sans-serif"><strong>Oportunidade comercial identificada:</strong></span></td>
                    <td><span><em><?php echo $oportunidade['Oportunidade']['DSOPORTUNIDADE'] ?> </em></span></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr /></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table border="0" width="100%">
                <tbody>
                <tr>
                    <td colspan="2">
                        <hr /></td>
                </tr>
                <tr>
                    <td align="center" colspan="2" style="font-style: italic;">Esta mensagem foi enviada por um sistema autom&aacute;tico. Por favor, n&atilde;o responda a este e-mail diretamente.</td>
                </tr>
                <tr>
                    <td width="441"><p><strong><?php echo $auth_user['EmpresaSelected']['Empresa']['empresa_nome']; ?><br />
                                Endere&ccedil;o: </strong><?php echo $auth_user['EmpresaSelected']['Empresa']['endereco']; ?>, <?php echo $auth_user['EmpresaSelected']['Empresa']['numero']; ?> <?php echo $auth_user['EmpresaSelected']['Empresa']['complemento']; ?><br />
                            Fone: <?php echo $auth_user['EmpresaSelected']['Empresa']['ddd'] ; ?> <?php echo $auth_user['EmpresaSelected']['Empresa']['fone']; ?></p>
                    </td>
                    <td align="center" width="49">&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>

<table width="635">
    <tbody>
    <tr>
        <td height="20">&nbsp;</td>
    </tr>
    </tbody>
</table>

</body>
</html>