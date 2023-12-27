<div class="span12">
    <div class="row-fluid">
        <div class="span12">
        <div id="contentLoading" style="position: absolute; background: #0182c2; border-radius: 5px; padding: 1px 10px; left: 50%; color: #fff;font-size:12px;display:none">atualizando...</div>
            <div class="page-header">
                <div style="display:flex;justify-content: space-between;align-items: center;">
                    <div>
                        <h1 style="margin-left:50px;color:#666"><i class="fa fa-home fa-lg"></i> Liberação de uso App </h1>
                        <?php if ($auth_user_group['id'] == 3) { ?>
                            <div class="text-left">
                                <i class="fa fa-info-circle fa-lg"></i> Bem vindo <strong><?php echo strtoupper($clienteSelected['Cliente']['FANTASIA']) ?></strong>
                            </div>
                        <?php } ?>
                    </div>
                    <div>
                    <div style="text-align:right;color:#666;margin-right:50px"><em>atualizado em <strong><?php echo date('d/m/Y H:i')?></strong></em></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($this->Session->check('Message.flash')) { ?>
        <div class="alert">
            <button data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <b><?php echo($this->Session->flash()); ?></b>
            <br/>
        </div>
    <?php } ?>
    
    <div class="row-fluid hidden-phone hidden-tablet hidden-sm" >
        <div class="span6" style="margin-left:0px;width:100%">
            <div class="panel panel-primary" style="border-color:#81d5ff">
                <div class="panel-heading" style="padding:1px 15px;background:#81d5ff;border-color:#81d5ff;text-align:center">
                    <h3 style="color:#0177b1"><i class="fa fa-check-square-o" aria-hidden="true" ></i> Solicitações</h3>
                </div>
                <div class="panel-body text-center" style="min-height: 200px;padding:0px">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>Login</th>
                                <th>Empresa</th>
                                <th>Versão android</th>
                                <th>Unique Id</th>
                                <th>Data solicitação</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody >
                            <?php 
                                foreach ($objData as $data): 
                                    $auth = $data['a'];
                                    $user = $data['u'];
                                    $empresa = $data['e'];
                            ?>
                                <tr>
                                    <td><?php echo $user['user_name'];?></td>
                                    <td><?php echo $user['user_email'];?></td>
                                    <td><?php echo $empresa['empresa_nome'];?></td>
                                    <td><?php echo $auth['android_version']?></td>
                                    <td><?php echo $auth['unique_id']?></td>
                                    <td><?php echo date("d/m/Y", strtotime($auth['create_at']));?></td>
                                    <td><a onClick="javascript:setPermissionApp('<?php echo $auth['id'];?>')">liberar</a></td>
                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(function() {
        setTimeout(function(){ 
            $("#contentLoading").css('display', 'block');
            location.reload();
        }, 60000);
    })

    function setPermissionApp(id)
    {
        $("#contentLoading").html('aguarde, atualizando...');
        $("#contentLoading").css('display', 'block');

        $.post('<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'setPermissionApp')); ?>', {id}, function (o) {
            
            if (o.error == 0 || o.result == false) {
                alert('Atenção', 'erro ao liberar app');
            } else {
                window.location = '<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'users', 'allowApp' => 'index')); ?>';
            }
        }, 'json');
    }

    

</script>