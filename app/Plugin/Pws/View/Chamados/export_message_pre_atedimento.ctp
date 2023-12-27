<script src="<?php echo $this->webroot; ?>jquery/jquery-1.8.2.min.js?"></script>
<div class="span12" style="margin:20px">
    <h2>
        <?php echo __('Pré atendimento'); ?>
    </h2>
    <h3>
        <?php echo __('chamado: ') . $chamado['Chamado']['SEQOS']; ?>
    </h3>
    <!-- Interações SLA -->
    <div class="tab-pane" id="preService">
        <div class="row-fluid">
            <div class="span12">
                <div class="panel panel-info" style="box-shadow:none">
                    <div class="collapse in" id="collapsepreService">
                        <div class="panel-body">
                            <div>
                            <!-- <a href='javascript:refresh()'>atualizar</a> -->
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
</div>
<script  type="text/javascript" >
// responsável pelas interações SLA
// @autor Gustavo Silva
// @size 22/02/2021


// verificar se o chamado ainda está para monstrar a opção dos campos
// bloquear o campos esperando as respostas
// 

window.print();

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
            $('#preServiceContainerField').remove()
        }

    }

    const showMessage = () =>{
        // consulta as mensagens na api
        const {success, message, content} = getMessages()

        setInfoTop('carregando mensagens...')

        // remove qualquer elemento no container de mensagem
        $("#preServiceContainerMessage > div").remove();

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

                if(idUsers.includes(Number(userId)) === true ||  userType === 3 || content.length <= 0){

                    $('#preServiceContainerField').css('display', 'flex');
                }

            }else{

                // remove os campos para o cliente enquanto ainda não tiver mensagem
                if(userType == 3){
                    // remove os campos
                    $('#preServiceContainerField').remove()
                    
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
        
        const avatar = Number(groupId) != 3 ? `<div id="preServiceAvatar"><img style="border-radius:50px" src="${logo}" height="70" width="70"/></div>` : '';
        
        const template = `<div id="preServiceContentMessage" ${customCssContainer}>
            <div id="preServiceAvatar">${avatar}</div>
            <div id="preServiceMessage" ${customCssMessage}>${contentMessage}</div>
        </div>
        <div id="preServiceMessageSeparator"></div>`;

        // adiciona a mensagem ao container
        $("#preServiceContainerMessage").prepend(template);

    }

    const getMessages = () =>{
        
        let response = {success:false, message:"", content:[]}

        $.ajax({
            url : `https://api.psfx.com.br/pre-attendance-messages/show/0/0`,
            type : "POST",
            async: false,
            data : JSON.stringify({idBase,
	                empresaId,
                    chamadoId}),
            contentType: 'application/json',
            dataType: 'json',
            processData : false,
        }).done(function(result){
            response = result
        }).fail(function(){
            // Here you should treat the http errors (e.g., 403, 404)
        }).always(function(){
            // alert("AJAX request finished!");
        });

        return response;

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

</script>

<style>

body{
    font-size:14px;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}

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