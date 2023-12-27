<div class="span12">
    <h2>
        <?php echo __('Chamado Técnico'); ?>
    </h2>
    <div class="row-fluid show-grid" id="tab_user_manager">
        <div class="span12">
            <ul class="nav nav-pills">
                <li class="active">
                    <?php
                    if ($salvo == 0) { ?>
                        <a href="javascript:window.history.go(-1)">Voltar</a>
                    <?php } else { ?>
                        <?php echo $this->Html->link(__('Voltar'), array('controller' => 'chamados', 'action' => 'index')); ?>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </div>

    <div class="row-fluid">
        <?php if (count($errors) > 0) { ?>
            <div class="alert alert-error">
                <button data-dismiss="alert" class="close" type="button">Ã—</button>
                <?php foreach ($errors as $error) { ?>
                    <?php foreach ($error as $er) { ?>
                        <strong><?php echo __('Error!'); ?> </strong>
                        <?php echo h(($er)); ?>
                        <br />
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>

        <?php if ($this->Session->check('Message.flash')) { ?>
            <div class="alert">
                <button data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <?php echo ($this->Session->flash()); ?>
                <br />
            </div>
        <?php } ?>

        <div class="row-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Chamado Técnico
                        <small class="text-right">Chamado Nº #
                            <?php echo h($chamado['Chamado']['id']) . ' / ' . h($chamado['Chamado']['SEQOS']);
                            ?>
                        </small></h1>
                </div>
                <div class="panel-body">

                    <ul class="nav nav-tabs" id="chamados">
                        <li id="dados-chamado"><a href="#dadosChamado">Dados do Chamado</a></li>
                        <li id="pre-atendimento"><a href="#preService">Pré-atendimento</a></li>
                        <?php if($auth_user_group['id'] != 12){?><li id="historicos-tab"><a href="#historicos">Histórico de Atendimento</a></li><?php } ?>
                        <li id="anexos-tab"><a href="#anexos">Anexos</a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- Interações SLA -->
                        <div class="tab-pane" id="preService">
                            <div class="row-fluid">
                                <div class="span12">
                                
                                <div><a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'exportMessagePreAtedimento', '?' => ['id' => $chamado['Chamado']['id']])); ?>" target="_blank">imprimir conversa</a></div>
                                    <div class="panel panel-info" style="background:#f1f1f1;border: 1px solid #e1e1e1;box-shadow:none">
                                        <div class="collapse in" id="collapsepreService">
                                            <div class="panel-body">
                                                <div>
                                                <!-- <a href='javascript:refresh()'>atualizar</a> -->
                                                </div>
                                                <div>
                                                    Status: <span id="prevServiceStatus" style="font-weight: bold"></span>
                                                </div>
                                                <div id="preServiceContainerField">
                                                    <div id="prevServiceLoading">aguarde..</div>
                                                    <textarea id="preServiceInput" rows="5" cols="33"></textarea>
                                                    <button type="button" id="preServiceButtom">enviar</button>
                                                    <div id="preServiceAttachFile">
                                                        <form action="https://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']?>#pre-atendimento" enctype="multipart/form-data" id="preServiceForm" onsubmit="return false">
                                                            <input type="hidden" id="idBase" name="idBase" value="">
                                                            <input type="hidden" id="empresaId" name="empresaId" value="">
                                                            <input type="hidden" id="userId" name="userId" value="">
                                                            <input type="hidden" id="chamadoId" name="chamadoId" value="">
                                                            <input type="hidden" id="message" name="message" value="">
                                                            <input type="file" id="file" name="file">
                                                        </form>
                                                    </div>
                                                </div>
                                                <div id="prevServiceInfoTop"></div>
                                                <div id="preServiceContainerMessage"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Interações SLA -->
                        <div class="tab-pane" id="dadosChamado">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            <h4><a data-toggle="collapse" href="#collapseChamado" aria-controls="collapseChamado"> Dados do Chamado</a></h4>
                                        </div>
                                        <div class="collapse in" id="collapseChamado">
                                            <div class="panel-body">
                                                <?php
                                                    echo $this->Acl->link('<i class="fa fa-file-archive-o"></i>', array(
                                                        'controller' => 'Chamados',
                                                        'action' => 'printPdf',
                                                        $chamado['Chamado']['id'],
                                                        0
                                                    ), array(
                                                        'class' => 'btn btn-large btn-default',
                                                        'escape' => false,
                                                        'title' => 'Formulário da O.S'
                                                    ));
                                                ?>
                                                <p>
                                                    <strong>Técnico Responsável:</strong> <?php echo h($chamado['Chamado']['NMSUPORTET']); ?><br>
                                                    <strong>Data de
                                                        Abertura:</strong> <?php echo h(date('d/m/Y', strtotime($chamado['Chamado']['DTINCLUSAO']))); ?>
                                                    <strong>Hora</strong> <?php echo h($chamado['Chamado']['HRINCLUSAO']); ?>
                                                    <br />
                                                    <strong>Data Prevista de Atendimento:</strong> <?php echo h(date('d/m/Y', strtotime($chamado['Chamado']['DTPREVENTREGA']))) . ' ' . h(date('H:i', strtotime($chamado['Chamado']['HRPREVENTREGA']))); ?>
                                                    <br>
                                                    <?php if ($chamado['Chamado']['STATUS'] == 'O') { ?>
                                                        <strong>Data de Conclusão:</strong> <?php echo h(date('d/m/Y', strtotime($chamado['Chamado']['DTATENDIMENTO'])))  . ' ' . h(date('H:i', strtotime($chamado['Chamado']['HRATENDIMENTO'])));  ?>
                                                        <br>
                                                    <?php } ?>
                                                    <strong> Status:</strong>
                                                    <?php
                                                    // status L,S e R serão visualizados como P=pendente para perfil cliente
                                                    $statusPendente = array('S', 'L', 'R', 'P');

                                                    // perfil cliente
                                                    if($auth_user_group['id'] == 3){
                                                        // se identificar status S,L,R seta para P
                                                        $Chamado['Chamado']['STATUS'] = in_array($Chamado['Chamado']['STATUS'], $statusPendente) ? 'P' : $Chamado['Chamado']['STATUS'];
                                                    }

                                                    switch ($chamado['Chamado']['STATUS']) {
                                                        case 'A':
                                                            echo "<span class='label label-info-bootstrap4'style='font-size: 14px'>Abertura</span>";
                                                            break;
                                                        case 'E':
                                                            echo "<span class='label label-primary-bootstrap4' style='font-size: 14px;'>Despachado</span>";
                                                            break;
                                                        case 'P':
                                                            echo "<span class='label label-info'style='font-size: 14px'>Pendente</span>";
                                                            break;
                                                        case 'S':
                                                            echo "<span class='label label-info'style='font-size: 14px'>Pendente</span>";
                                                            break;
                                                        case 'L':
                                                            echo "<span class='label label-info'style='font-size: 14px'>Pendente</span>";
                                                            break;
                    
                                                        case 'R':
                                                            echo "<span class='label label-default' style='font-size: 14px'>Retorno</span>";
                                                            break;

                                                        case 'M':
                                                            echo "<span class='label label-warning'style='font-size: 14px'>Em Manutenção</span>";
                                                            break;
                                                        case 'C':
                                                            echo "<span class='label label-important'style='font-size: 14px'>Cancelado</span>";
                                                            break;
                                                        case 'O':
                                                            echo "<span class='label label-success'style='font-size: 14px'>Concluído</span>";
                                                            break;
                                                        case 'A':
                                                            echo "<span class='label label-info-bootstrap4'style='font-size: 14px'>Abertura</span>";
                                                            break;
                                                        case 'T':
                                                            echo "<span class='label label-default'style='font-size: 14px'>Atendido</span>";
                                                            break;
                                                    }
                                                    ?><br>
                                                    <?php if (isset($chamado['Chamado']['TIPO_OS']) && $chamado['Chamado']['TIPO_OS'] !== '') { ?>
                                                        <strong>Modalidade:</strong>
                                                        <?php
                                                        switch ($chamado['Chamado']['TIPO_OS']) {
                                                            case '0':
                                                                echo "Suprimento";
                                                                break;
                                                            case '1':
                                                                echo "Assistência/Chamado Técnico";
                                                                break;
                                                            case '2':
                                                                echo "Solicitação (Retirada/Instalação/Outros)";
                                                                break;
                                                        }
                                                        ?>
                                                        <br>
                                                    <?php } ?>
                                                    <strong>Tipo de Chamado:</strong> <?php echo h($chamado['ChamadoTipo']['NMOSTP']); ?> <br>
                                                    <strong>Tipo de Defeito:</strong> <?php echo h($chamado['Defeito']['NMDEFEITO']); ?><br>
                                                    <strong>Defeito Relatado pelo Cliente:</strong> <?php echo str_replace('/n', '<br>', $chamado['Chamado']['OBSDEFEITOCLI']); ?><br>
                                                    <strong>Severidade:</strong> <?php echo h($STATUS_SEVERIDADE); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4><a data-toggle="collapse" href="#collapseCliente" aria-controls="collapseCliente"> Dados do Cliente</a></h4>
                                        </div>
                                        <div class="collapse in" id="collapseCliente">
                                            <div class="panel-body">
                                                <p>
                                                    <strong>Cliente:</strong> <?php echo h($chamado['Chamado']['CDCLIENTE']); ?>
                                                    - <?php echo h($chamado['Chamado']['NMCLIENTE']); ?> <br>
                                                    <strong>Endereço:</strong> <?php echo h($chamado['Chamado']['ENDERECO']); ?>
                                                    , <?php echo h($chamado['Chamado']['NUM']); ?> <?php echo h($chamado['Chamado']['COMPLEMENTO']); ?>
                                                    <br>
                                                    <strong>Bairro:</strong> <?php echo h($chamado['Chamado']['BAIRRO']); ?>
                                                    <strong>CEP:</strong> <?php echo h($chamado['Chamado']['CEP']); ?> <br>
                                                    <strong>Cidade:</strong> <?php echo h($chamado['Chamado']['CIDADE']); ?>
                                                    <strong>UF:</strong> <?php echo h($chamado['Chamado']['UF']); ?> <br>
                                                    <strong>Contato:</strong> <?php echo h($chamado['Chamado']['CONTATO']); ?>
                                                    <strong>Fone:</strong> <?php echo h($chamado['Chamado']['DDD']); ?> <?php echo h($chamado['Chamado']['FONE']); ?>
                                                    <br>
                                                    <strong>Email:</strong> <?php echo h($chamado['Chamado']['EMAIL']); ?><br>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 offset0">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4><a data-toggle="collapse" href="#collapseEquipamento" aria-controls="collapseEquipamento"> Dados do Equipamento</a></h4>
                                        </div>
                                        <div class="collapse in" id="collapseEquipamento">
                                            <div class="panel-body">
                                                <p>
                                                    <strong>Série:</strong> <?php echo h($chamado['Equipamento']['SERIE']); ?><br>
                                                    <strong>Patrimônio:</strong> <?php echo h($chamado['Equipamento']['PATRIMONIO']); ?>
                                                    <br>
                                                    <strong>Modelo:</strong> <?php echo h($chamado['Equipamento']['MODELO']); ?><br>
                                                    <strong>Departamento:</strong> <?php echo h($chamado['Equipamento']['DEPARTAMENTO']); ?>
                                                    <br>
                                                    <strong>Local de
                                                        Instalação:</strong> <?php echo h($chamado['Equipamento']['LOCALINSTAL']); ?>
                                                    <br>

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane" id="historicos">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4><a data-toggle="collapse" href="#collapseAtendimentos" aria-controls="collapseAtendimentos"> Histórico de Atendimentos</a></h4>
                                        </div>
                                        <div class="collapse in" id="collapseAtendimentos">
                                            <div class="panel-body">
                                                <?php foreach ($atendimentos as $atendimento) : ?>

                                                    <div class="row-fluid show-grid">
                                                        <div class="span12 well">
                                                            <div class="row-fluid">
                                                                <div class="span3">
                                                                    <div><strong>Data da Visita:</strong>&nbsp;
                                                                        <?php echo date('d/m/Y', strtotime($atendimento['Atendimento']['DTATENDIMENTO'])); ?>
                                                                    </div>
                                                                </div>

                                                                <div class="span3">
                                                                    <div>
                                                                        <strong>Hora
                                                                            Inicial:</strong>&nbsp; <?php echo $atendimento['Atendimento']['HRATENDIMENTO']; ?>
                                                                    </div>

                                                                </div>

                                                                <div class="span3">
                                                                    <div>
                                                                        <strong>Hora
                                                                            Final:</strong>&nbsp; <?php echo $atendimento['Atendimento']['HRATENDIMENTOFIN']; ?>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row-fluid">
                                                                <?php if($atendimento['Atendimento']['ORIGEM_CADASTRO'] != 'APP' and $atendimento['Atendimento']['TFVISITA'] == 'S'){ ?>
                                                                    <div class="span3">
                                                                        <div>
                                                                            <strong>Data de fechamento</strong>&nbsp; <?php echo $atendimento['Atendimento']['DATAHORA']; ?>
                                                                        </div>
                                                                    </div>
                                                                <?php }?>
                                                                <div class="span3">
                                                                    <div>
                                                                        <strong>Descrição da
                                                                            Visita:</strong>&nbsp; <?php echo $atendimento['Atendimento']['OBSERVACAO']; ?>
                                                                    </div>
                                                                </div>
                                                                <?php if($atendimento['Atendimento']['NOME_CONTATO'] != ""){?>
                                                                    <div class="span3">
                                                                        <div>
                                                                            <strong>Nome do contato:</strong>&nbsp; <?php echo $atendimento['Atendimento']['NOME_CONTATO']; ?>
                                                                        </div>
                                                                    </div>
                                                                <?php }?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="anexos">
                            <?php 
                            
                                if($chamado['Chamado']['attachments'] != ''){
                                    // decodifica o json
                                    $json = json_decode($chamado['Chamado']['attachments']);
                                    // seta o caminho de leitura dos arquivos
                                    $pathReading = "/var/www/html/files/os_" . $chamado['Chamado']['ID_BASE'] . "/" . $chamado['Chamado']['id'];
                                    
                                    $items = glob($pathReading."/*");

                                    echo '<div style="display:flex">';

                                    foreach($items as $data){
                                        $isImg = in_array(strrchr($data, '.'), array('.jpg', '.png')) === true ? true : false;

                                        echo '<div style="margin:5px">';
                                        if($isImg == true){
                                            echo '<div><img height="250" width="300" src="'.Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'renderFile/'.pathinfo($data, PATHINFO_BASENAME).'/'.$chamado['Chamado']['id'].'/'.$chamado['Chamado']['ID_BASE'])).'"/></div>';
                                        }else{
                                            echo '<div style="background:#e1e1e1;height:150px;width:200px;display:flex;justify-content: center;align-items: center;">arquivo '. strrchr($data, '.') .'</div>';
                                        }
                                        echo '<div style="text-align:center"><a target="_blank" href="'.Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'downloadFile/'.pathinfo($data, PATHINFO_BASENAME).'/'.$chamado['Chamado']['id'].'/'.$chamado['Chamado']['ID_BASE'])) .'">download</a></div>';
                                        echo '</div>';
                                    }

                                    echo '</div>';
                                }else{
                                    echo '<em>Nenhum anexo.</em>';
                                }
                            ?>
                        </div>
                    </div>


                </div>
                <div class="panel-footer">
                    <?php
                    if ($salvo == 0) { ?>
                        <a class="btn " href="javascript:window.history.go(-1)">Voltar</a>
                    <?php } else { ?>
                        <?php echo $this->Html->link(__('Voltar'), array('controller' => 'chamados', 'action' => 'index'), array('class' => 'btn')); ?>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#chamados a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    })
</script>
<script  type="text/javascript" >
// responsável pelas interações SLA
// @autor Gustavo Silva
// @size 22/02/2021


// verificar se o chamado ainda está para monstrar a opção dos campos
// bloquear o campos esperando as respostas
// 

const usePreService = (idBase, empresaId, user, chamadoId, status) =>{

    const statusSend = true
    const userId = user.User.id
    const idUsers = []
    
    const index = () =>{
        // seta as mensagens
        showMessage()

        if(status != 'O' && status != 'C'){
            // define a ação do botão para o campo de mensagem
            handleButton()
        }else{
            setStatus('O status do chamado não permite mais interação')

            // remove os campos
            // $('#preServiceContainerField').remove()
        }

    }

    const showMessage = () =>{
        // consulta as mensagens na api
        const {success, message, content} = getMessages()

        setInfoTop('carregando mensagens...')

        // remove qualquer elemento no container de mensagem
        // $("#preServiceContainerMessage > div").remove();

        content.reverse();
       
        if(success == true){
            // pega o tipo de usuário
            const userType = Number(user.Group[0].id)
            
            // verifica se possui alguma mensagem
            if(content.length > 0){

                // busca a última mensagem
                const lastMessage = content[content.length-1];
                const lastUserName = lastMessage.user.userName;
                const lastUserId = lastMessage.userGroup.userId;
                const lastGroupId = lastMessage.userGroup.groupId
                
                if(userId == lastUserId){

                    if(content.length > 2){
                        setStatus(`Aguardando (${content[content.length-2].user.userName}) responder.`)
                    }else{
                        setStatus(`Aguardando resposta.`)
                    }

                    // remove os campos
                    // $('#preServiceContainerField').remove()

                }else{
                    setStatus(`(${content[content.length-1].user.userName}) enviou uma mensagem.`)
                }

                $("#preServiceContainerMessage").html('');

                //monta as mensagens
                content.map(data =>{

                    if(idUsers.includes(data.user.id) == false){
                        // adiciona os usuários que podem interagir com o  pré-atendimento
                        idUsers.push(Number(data.user.id))
                    }

                    // define o template e adiciona na estrutura
                    templateMessage(data);

                    setInfoTop('')
                });

                // if(idUsers.includes(Number(userId)) === true ||  userType === 3 || content.length <= 0){

                    $('#preServiceContainerField').css('display', 'flex');
                // }

            }else{

                // remove os campos para o cliente enquanto ainda não tiver mensagem
                if(userType == 3){
                    // remove os campos
                    // $('#preServiceContainerField').remove()
                    
                    setStatus('Aguardando mensagem do suporte.')
                }else{

                    $('#preServiceContainerField').css('display', 'flex');

                    setStatus('Aguardando interação.')
                }
                
                setInfoTop('Nenhuma mensagem')

            }
        }else{
            setInfoTop(message)
        }

        

    }

    // monta o template da mensagem
    const templateMessage = (data) =>{
        const {message, user, dateTime, file, userGroup:{groupId}, empresa:{logo}} = data;
        
        // customização para visualização do usuário
        let customCssContainer = '';
        let customCssMessage = '';
        let customCssTextAlign = ''
        const attachment = file != '' ? `<a href="${file}" target="_blank">arquivo em anexo</a> -` : ''

        if(userId == user.id || (idUsers.includes(Number(userId)) === false && groupId == 3)){
            customCssTextAlign = `style="text-align:left"`;
        }else{
            customCssTextAlign = `style="text-align:right"`;
            customCssContainer = `style="flex-direction:row-reverse"`;
            customCssMessage = `style="justify-content:flex-end;color:#000;"`;
        }

        // define a mensagem
        const contentMessage = `<p ${customCssTextAlign}>${message}<br/><span>${attachment} ${user.userName} - ${dateTime}</span></p>`
        
        const avatar = Number(groupId) != 3 ? `<div id="preServiceAvatar"><img src="${logo}"/></div>` : '';
        
        const template = `<div id="preServiceContentMessage" ${customCssContainer}>
            <div id="preServiceAvatar">${avatar}</div>
            <div id="preServiceMessage" ${customCssMessage}>${contentMessage}</div>
        </div>
        <div id="preServiceMessageSeparator"></div>`;

        // adiciona a mensagem ao container
        $("#preServiceContainerMessage").prepend(template);

    }

    const handleButton = () =>{

        //define o input
        const input = $("#preServiceInput");

        // define o focu no botão
        input.focus()

        // enviar mensagem
        $("#preServiceButtom").click(()=>{

            if(input.val().trim() == ''){
                // define o focu
                input.focus()

                return false;
            
            }

            // envia mensagem
            sendMessage(input.val())

        })

    }

    const sendMessage = (message) =>{
        // define a máscara
        loadingMark()

        $('#idBase').val(idBase)
        $('#empresaId').val(empresaId)
        $('#userId').val(userId)
        $('#chamadoId').val(chamadoId)
        $('#message').val(message)
        
        // cria a instancia do form
        const componentForm = new FormData($("#preServiceForm")[0]) 

        $.ajax({
            url : `https://api.psfx.com.br/pre-attendance-messages/create`,
            type : "POST",
            data : componentForm,
            enctype: 'multipart/form-data',
            contentType: false,
            processData : false,
            cache: false,
            headers:{
                'apiVersion': 'v3'
            }
        }).done(function(response){

            // envia a mensagem
            const {success} = response;

            //define o input
            const input = $("#preServiceInput");

            if(success == true){
                // atuliza as mensagens
                showMessage()

                // remove qual informação
                setInfoTop('Mensagem enviada com sucesso!')
    
                // zera o input
                input.val('')
    
                // remove os arquivos
                $("#file").val('')

                // remove os campos
                // $('#preServiceContainerField').remove()
            }

            // define o focu
            input.focus()

            loadingMark(false)

        }).fail(function(error){
            response.success = false;
            response.message = 'erro'
            Alert('Atenção', 'Não foi possível enviar a mensagem')
        }).always(function(){
            // alert("AJAX request finished!");
        });

    }

    const getMessages = () =>{
        
        let response = {success:false, message:"", content:[]}
        
        $.ajax({
            url : `https://api.psfx.com.br/pre-attendance-messages/show/`,
            type : "POST",
            async: false,
            data : JSON.stringify({idBase,
	                empresaId,
                    chamadoId}),
            contentType: 'application/json',
            headers:{
                "apiVersion":'v3',
            },
            dataType: 'json',
            processData : false,
        }).done(function(result){
            response = result
        }).fail(function(e){
            // Here you should treat the http errors (e.g., 403, 404)
        }).always(function(){
            // alert("AJAX request finished!");
        });

        return response;

    }

    const exportMessage = () =>{

        // pega as mensagens
        const messages = getMessages()

        console.log(messages)

    }

    const loadingMark = (active = true) =>{
        // seta a máscara de loading do formulário
        $("#prevServiceLoading").css("display", active ? "flex" : "none");
    }

    const setInfoTop = (message) =>{
        $("#prevServiceInfoTop").html(message)
    }

    const setStatus = (message) =>{
        $("#prevServiceStatus").html(message)
    }

    return {index}

}

const preService = usePreService(<?php echo $chamado['Chamado']['ID_BASE']?>, <?php echo $chamado['Chamado']['empresa_id']?>, <?php echo json_encode($auth_user)?>, <?php echo $chamado['Chamado']['id'] ?>, '<?php echo $chamado['Chamado']['STATUS'] ?>');

preService.index();

const getHashFromUrl = () =>{
    a = window.location.hash;
    const hash = a.replace(/^#/, "");

    if(hash == ''){
        $('#dados-chamado').addClass('active')
        $('#dadosChamado').addClass('active')
    }else if(hash == 'pre-atendimento'){
        $('#pre-atendimento').addClass('active')
        $('#preService').addClass('active')
    }

    console.log(hash)
}

const refresh = () =>{

    // $("#preServiceForm").onsubmit(function(){
    //     return true;
    // })
        
    // $("#preServiceForm").submit(function(event){
    //     return 
    //     // event.preventDefault();
    // })
}

getHashFromUrl();

</script>

<style>
#preServiceContentMessage{
    display:flex;
}

#preServiceAvatar{
    background:#e1e1e1;
    border-radius:50px;
    height: 70px;
    width: 70px;
    justify-content: center;
    align-items: center;
    display: flex;
    font-size: 12px;
}

#preServiceMessage{
    display: flex;
    justify-content: flex-start;
    align-items: center;
    flex: 1;
    margin-right: 15px;
    margin-left: 15px;
}

#preServiceMessage > p > span{
    font-size: 11px;
    font-style: italic;
    color:#666;
    margin-right:10px;
}

#preServiceMessage > p > a{
    margin-left:10px;
    text-decoration: underline;
    
}

#preServiceMessage > p{
    margin:0px;
}

#prevServiceInfoTop{
    text-align: center;
    color: #999;
    font-weight: 300;
}

#preServiceMessageSeparator{
    display: flex;
    flex: 1;
    height: 2px;
    border-bottom: 1px solid #e1e1e1;
    margin-left: 10%;
    margin-right: 10%;
    margin-bottom: 5px;
    margin-top: 5px;
}

#preServiceContainerField{
    /* display:flex; */
    margin-bottom:50px;
    position:relative;
    padding:4px;
    display:none;
}

#preServiceContainerField > textArea{
    width:90%;
    resize: none;
    border: 1px solid #e1e1e1;
    box-shadow: none;
}

#preServiceContainerField > button{
    width: 10%;
    background: #468847;
    border: none;
    color: #f1f1f1;
    font-size: 15px;
    height:100px;
}

#prevServiceLoading{
    position: absolute;
    background: #f1f1f1;
    width: 100%;
    height: 140%;
    z-index: 1;
    opacity: 0.8;
    display: none;
    justify-content: center;
    align-items: center;
    color: #468847;

}

#preServiceAttachFile{
    position: absolute;
    background: #fff;
    height: 30px;
    bottom: -18px;
    border: 1px solid #e1e1e1;
    padding-left: 10px;
    padding-right: 10px;
    color: #999;
}

#preServiceContainerMessage{
    margin-top:10px;
}
</style>