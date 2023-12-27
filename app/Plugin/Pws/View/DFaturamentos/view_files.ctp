<table class="table" style="margin-top:10px">
    <caption></caption>
    <thead>
         <tr>
            <th>Arquivos</th>
            <th></th>
            <th></th>
         </tr>
    </thead>
    <tbody>
        <?php foreach ($arrData as $data) : ?>
        <tr id="data-grid-<?php echo $data['DFaturamento']['id'] ?>">
            <td><div><?php echo $data['DFaturamento']['nome_arquivo']; ?><div><div><em style="font-size:10px"><strong>e-mail(s):</strong> <?php echo $data['DFaturamento']['emails'] ?></em></div></td>
            <?php $hashName = Security::hash($data['DFaturamento']['id'].$data['DFaturamento']['nome_arquivo_sistema']); ?>
            <td><a href="javascript:new dfaturamento().downloadFile('<?php echo $data['DFaturamento']['id'] ?>', '<?php echo $data['DFaturamento']['nome_arquivo_sistema'] ?>','<?php echo $data['DFaturamento']['nome_arquivo'] ?>', '<?php echo $hashName ?>')">Download</a></td>
            <?php $hash = Security::hash($data['DFaturamento']['id'].$data['Cliente']['id']); ?>
            <td>
            <?php if(in_array($this->Session->read('auth_user_group')['id'], array(1, 6))){ ?>
            <a href="javascript:new dfaturamento().deleteFile('<?php echo $data['DFaturamento']['id'] ?>', '<?php echo $data['Cliente']['id'] ?>', '<?php echo $hash ?>')">Excluir</a>
            <?php } ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>