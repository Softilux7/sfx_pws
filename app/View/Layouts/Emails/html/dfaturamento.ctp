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
                    <td align='left'></td>
                </tr>
            </table></td>
    </tr>

    <tr>
        <td align='center' valign="middle" bgcolor='#012B49'>
            <h3 style="margin-top:20px"><strong><br>
                    <span style="color:#FFF; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" >FATURAMENTO</span></strong></h3>
                    <span style="color:#FFF; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" >
                    Prezado cliente, já está disponível os arquivos referente ao faturamento de seu contrato. </br>
                    Baixe os arquivos diretamente ou acesse o portal para fazer o upload.</br></span>
        </td>
    </tr>
    <tr>
        <td align='center'>
            <div style="margin-top:20px;margin-bottom:15px">
            Arquivo(s):
            </div>
            </br>
            <?php foreach ($data as $key => $value) : ?>
                <div><a href="http://psfx.com.br/pws/app/webroot/index.php/pws/DFaturamentos/downloadFile/<?php echo $value['url']?>"><?php echo $value['name']?></a></div>
            <?php endforeach; ?>

        </td>
    </tr>
    <tr>
        <td><table width='500' border='0' align='center' cellpadding='0' cellspacing='0' style="margin-top:10px">
                <tr>
                    <td colspan='2' align="center"> <p><span style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif"></span></p>
                        <p><a href="http://psfx.com.br/pws/app/webroot/index.php/pws/DFaturamentos" style="
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
	text-decoration:none;">Acessar o portal</a></p>
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