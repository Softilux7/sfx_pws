<!-- Novo layout user add-->
<div class="span12">
    <div class="row-fluid show-grid" id="tab_user_manager">
        <div class="span12">
            <p><a class="btn btn-large " title="Voltar"
                  href="<?php echo Router::url(array('controller' => 'users', 'action' => 'index')); ?>"><i
                        class="fa fa-arrow-circle-left"></i> Voltar</a>
            </p>
        </div>
    </div>
        <div class="row-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Central de notificação</h1>
                </div>
                <div class="panel-body">
                    <?php echo $this->Form->create('User', array('class' => 'form-horizontal')); ?>
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a href="#dados">Envio de notificação</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="dados">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="panel-body">
                                        <div class="panel panel-warning">
                                            <div class="panel-heading">
                                                <h4>Dados</h4>
                                            </div>
                                            <div class="panel-body">
                                                
                                                <div class="control-group" id="tecnicoBox">
                                                    <label for="inputEmail" class="control-label"><?php echo __('Usuário'); ?>
                                                        <span style="color: red;">*</span>
                                                    </label>
                                                    <div class="controls">
                                                        <?php
                                                        echo $this->Form->input('fcmTokenDevice', array(
                                                            'empty' => 'Selecione o Usuário',
                                                            'required', 
                                                            'options' => $arrTecnicos,
                                                            'id' => 'fcmTokenDevice',
                                                            'label' => false,
                                                            'class' => 'select2_category form-control'
                                                        ));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div
                                                    class="control-group <?php if (array_key_exists('title', $errors)) {
                                                        echo 'error';
                                                    } ?>">
                                                    <label for="inputEmail" class="control-label"><?php echo __('Title'); ?>
                                                        <span style="color: red;">*</span>
                                                    </label>
                                                    <div class="controls">
                                                        <?php echo $this->Form->input('title', array('id' => 'title', 'div' => false, 'label' => false, 'class' => 'input-xlarge', 'error' => false, 'maxlength' => '50')); ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label"><?php echo __('Mensagem:'); ?><span style="color: red;">*</span> </label>
                                                    <div class="controls">
                                                        <?php echo $this->Form->input('bodyMessage', array(
                                                            'type' => 'textarea',
                                                            'id' => 'bodyMessage',
                                                            'div' => false,
                                                            'class'=>"span4",
                                                            'label' => false,
                                                            'required', 
                                                            'disabled' => false,
                                                            'maxlength' => '200',
                                                            'error' => false)); ?>
                                                    </div>
                                                </div>
                                             </div>
                                             <div style="margin-left:173px;color:#666"><em style="font-size:10px">Você pode definir um título de até 50 caracteres e uma mensagem de até 100 caracteres.</em></div>
                                             <span id="message"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="panel-footer">
                    <input type="button" id="buttonSend" class="btn btn-large btn-primary" value="<?php echo __('Enviar mensagem'); ?>"/>
                    <input type="button" class="btn btn-large" value="<?php echo __('Cancelar'); ?>" onclick="cancel_add_user();"/>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script  type="text/javascript" >
    const useNotifications = () =>{

        const index = () =>{

            $('#buttonSend').click(()=>{
                
                messageLoading('Iniciando envio de notificação', '#000');

                const fcm_token_device = $('#fcmTokenDevice').val(); 
                const title = $.trim($('#title').val());
                const body = $.trim($('#bodyMessage').val());
                
                if(fcm_token_device != ''){
                    if(title != '' && body != ''){
                    
                        messageLoading('Aguardando retorno servidor', '#000');

                        // desabilita o botão
                        $("#buttonSend").prop("disabled", true);

                        $.ajax({
                            url : `https://api.psfx.com.br/send-notification/create`,
                            type : "POST",
                            // async: false,
                            data : JSON.stringify({title, body, data:{}, fcm_token_device}),
                            contentType: 'application/json',
                            headers:{
                                "apiVersion":'v3',
                            },
                            dataType: 'json',
                            processData : false,
                        }).done(function(result){
                            response = result

                            messageLoading('Notificação enviada com sucesso', '#468847');

                            $('#fcmTokenDevice').val('');
                            $('#title').val('');
                            $('#bodyMessage').val('');
                            
                            // habilita o botão
                            $("#buttonSend").prop("disabled", false);

                        }).fail(function(e){
                            messageLoading('Erro ao enviar notificação2', '#cc0000');
                            
                            // habilita o botão
                            $("#buttonSend").prop("disabled", false);
                            // Here you should treat the http errors (e.g., 403, 404)
                        }).always(function(e){ });

                }else{
                    messageLoading('Preecha o título e o corpo da mensagem', '#cc0000');
                }
                }else{
                    messageLoading('Informe o usuário', '#cc0000');
                }

            });

        }

        const messageLoading = (title, color) =>{

            $("#message").css('background-color', color);
            $('#message').html(title);

        }



        return {index}

    }

    const notifications = useNotifications();

    notifications.index();

</script>

<style>
    #message{
        margin: 10px;
        padding: 5px;
        color: #fff;
        margin-left: 173px;
    }
</style>