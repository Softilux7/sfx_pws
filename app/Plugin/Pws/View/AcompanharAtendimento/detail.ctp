<div>
    <div class="span8">
        <div><strong>Técnico:</strong> <?php echo $data['AcompanharAtendimento']['NMATENDENTE'] ?></div>
    </div>
    <?php if ($data['AcompanharAtendimento']['ANDAMENTO_CHAMADO_APP'] >= 8) { ?>
        <div class="span3">
            <div><strong>Sintoma:</strong> <?php echo $data['AcompanharAtendimento']['SINTOMA'] ?></div>
        </div>
        <div class="span3">
            <div><strong>Causa:</strong> <?php echo $data['AcompanharAtendimento']['CAUSA'] ?></div>
        </div>
        <div class="span3">
            <div><strong>Ação:</strong> <?php echo $data['AcompanharAtendimento']['ACAO'] ?></div>
        </div>
        <div class="span5">
            <div><strong>Observação:</strong> <?php echo $data['AcompanharAtendimento']['OBSERVACAO'] ?></div>
        </div>
        <div class="span8">
            <div><strong>Follow-up:</strong> <?php echo $data['Chamado']['OBSDEFEITOATS'] ?></div>
        </div>
    <?php } else { ?>
        <div class="span8">
            <div>Atendimento ainda não finalizado.</div>
        </div>
    <?php } ?>
</div>