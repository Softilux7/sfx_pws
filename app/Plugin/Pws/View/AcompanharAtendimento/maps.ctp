<style type="text/css">
    .map_canvas {
        width: '100%';
        height: '100%';
    }

    .containerBox{
        display: flex;
        justify-content:center;
        position:relative;
        top: -50px;
    }

    .boxContent{
        width: 200px; 
        height: 100px;
        text-align: center; 
        background: #fff;
        margin-right: 5px;
        border-radius: 5px;
        box-shadow: 1px 1px 8px #ccc;
    }

    .boxContent p {
        font-size: 16px;
        color: #666;
        margin-top: 5px;
    }

    .boxContent span {
        font-size: 30px;
        font-weight: bold;
    }

    .boxTecnicoContainer{
        display: flex;
        justify-content: center;
        position:relative;
        top:-35px;
        flex-wrap: wrap;
    }

    .boxTecnicoContainer a{
        background: #fff;
        border-radius: 5px;
        padding-left: 10px;
        padding-right: 10px;
        font-size: 11px;
        font-weight: bold;
        margin: 3px;
        box-shadow: 1px 1px 8px #ccc;
        text-decoration:none;
        color:#666;
    }
    .boxTecnicoContainer a:hover{
        background:#ccc;
        color:#333;
    }

    .boxAtualization{
        text-align: center;
        top: -50px;
        position: relative;
    }
</style>

    <div class="contexto_canvas" style="display:flex;flex-direction:column;height:100%">
        <div class="map_canvas" id="map_canvas" style="flex:1 1 auto"></div>
        <div>
            <div class="containerBox">
                <div class="boxContent"><p>Em deslocamento</p><span id="value_deslocamento"></span></div>
                <div class="boxContent"><p>Em atendimento</p><span id="value_atendimento_"></span></div>
                <div class="boxContent"><p>Total</p><span id="value_total"></span></div>
            </div>
        </div>
        <div class="boxAtualization"></div>
        <div class="boxTecnicoContainer" id="boxTecnicoContainer"></div>
    </div>
    <div id="debug"></div>
    
    <script type="text/javascript">
            
            var infoWindow = null;
            var firstTime = false;
            var map = null;
            var data = getData();
            var arrMarker = [];
            var arrDataAtendimento = [];
            var modalActive = null;
            var idSetInterval = 0;

            $('body').css('height', '80%');
            $('#container').css('height', '100%');
            $('#container').css('padding-top', '31px');
            $('#container').css('padding-right', '0px');
            $('#container').css('padding-left', '0px');

            function showMap(){

                var myOptions = {
                    zoom: 5,
                    center: new google.maps.LatLng(-27.583574, -48.57779),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }

                // renderiza o mapa
                map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

                directionsDisplay = new google.maps.DirectionsRenderer();
                directionsDisplay.setMap(map);

                infoWindow = new google.maps.InfoWindow;
                
                // atualiza o mapa com o técnicos
                updateMaps();

                // a cada 1 minuto atualiza os dados
                // window.setInterval(getData, 60000);
                window.setInterval(getData, 120000);
            }

            function updateMaps(){
                // remove os marcadores antes de inserior os novos
                arrMarker.forEach(function(item, key){
                    arrMarker[key].setMap(null);
                });
                
                // atualizao painel
                updatePanel(data);

                data.forEach(function(item, key){
                    // seta a última hora de atualização
                    $('.boxAtualization').html(`úlitma atualização às ${item.atualizacao}h`);

                    // const pinViewBackground = new google.maps.marker.PinView({
                    //     background: '#FBBC04',
                    // });

                    // cria o marcador
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(item.lat, item.lng),
                        label: `${item.tecnico} - ${getStatus(item.andamento)}`,
                        // icon: iconMarker,
                        map: map,
                        scale: 2,
                        // content: pinViewBackground.element
                    });

                    // referencia do marker
                    arrMarker[item.atendimentoId] = marker;

                    // referencia dos dados
                    arrDataAtendimento[item.atendimentoId] = item;

                    // cria o evento click do marcador
                    (function (marker, data) {
                        google.maps.event.addListener(arrMarker[item.atendimentoId], 'click', function () {
                            // abre o conteúdo da modal
                            openContentModal(item, item.atendimentoId);

                            // seta o zoom que está ativo
                            modalActive = item.atendimentoId;
                        });
                    })(marker, item);
                });

                // atualiza o zoom na primeira renderizada
                if(firstTime == false && data.length > 0){
                    map.setCenter(new google.maps.LatLng(data[0].lat, data[0].lng));
                    map.setZoom(10);
                    firstTime = true;
                }else if(modalActive != null){
                    // verifica se possui algum zoom ativo e reabre
                    zoomTecnico({atendimentoId : modalActive});
                }else{
                    modalActive = null;
                }
            }

            function getData(){
                let response = [];
                
                $.ajax({
                    url : '<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'AcompanharAtendimento', 'action' => 'getServiceTechnician')); ?>',
                    type : "POST",
                    data : {},
                    contentType: 'application/json',
                    dataType: 'json',
                    processData : false,
                }).done(function(result){
                    // seta o json de retorno
                    data = result;
                    
                    // atualiza os dados do mapa
                    updateMaps();
                });

                return response;
            }

            function updatePanel(data){
                let deslocamento = 0;
                let atendimento = 0;
                let total = 0;

                // remove os técnicos do box
                $('#boxTecnicoContainer').html('');

                data.forEach(function(item, key){
                    // adiciona os técnicos ao box
                    $('#boxTecnicoContainer').append(`<a href="javascript:zoomTecnico({atendimentoId:${item.atendimentoId}}, true)" title="Status: ${item.status} | Situação: ${getStatus(item.andamento)}">${item.tecnico}</a>`);

                    if(item.andamento != 15){
                        if(item.andamento >= 6 && item.andamento <=11){
                            atendimento++
                        }else{
                            deslocamento++;
                        }
                    }

                    total++;
                });
                
                $('#value_atendimento_').html(atendimento);
                $('#value_deslocamento').html(deslocamento);
                $('#value_total').html(total);
            }

            function zoomTecnico(data, zoom){
                // seta os dados de atendimento
                const atendimento = arrDataAtendimento[data.atendimentoId];

                // seta o zoom que está ativo
                modalActive = data.atendimentoId;

                if(zoom == true){
                    // zoom 
                    map.setCenter(new google.maps.LatLng(atendimento.lat, atendimento.lng));
                    map.setZoom(15);
                }

                // abre amodal
                openContentModal(atendimento, data.atendimentoId);
            }

            function openContentModal(item, key){
                infoWindow.setContent(
                    `<div>Empresa: <strong>${item.empresa.empresa_fantasia}</strong></div>`+ 
                    `<div>Técnico: <strong>${item.tecnico}</strong></div>`+ 
                    `<div>SEOQS: <strong>${item.seqos}/${item.chamadoId}</strong></div>` +
                    `<div>Status: <strong>${item.status}</strong></div>` +
                    `<div>Situação: <strong>${getStatus(item.andamento)}</strong></div>` +
                    `<div>Tempo de atendimento: <strong><span id="value_tempoatendimento"></span></strong></div>` +
                    `<div>Início do atendimento: <strong>${item.HRATENDIMENTO} </strong></div>` +
                    `<div>Final do atendimento: <strong>${item.HRATENDIMENTOFIN != '00:00:00' ? item.HRATENDIMENTOFIN : '-'} </strong></div>` +
                    `<div>--------------------------------------------------------------------------------------------------------------------------------------------</div>` +
                    `<div>Código: <strong>${formaterText(item.equipamento.CDPRODUTO)}</strong></div>` +
                    `<div>Série: <strong>${formaterText(item.equipamento.SERIE)}</strong></div>` +
                    `<div>Modelo: <strong>${formaterText(item.equipamento.MODELO)}</strong></div>` +
                    `<div>Fabricante: <strong>${formaterText(item.equipamento.FABRICANTE)}</strong></div>` +
                    `<div>Local instalação: <strong>${formaterText(item.cliente.LOCALINSTAL)}</strong></div>` +
                    `<div>Departamento: <strong>${formaterText(item.chamado.DEPARTAMENTO)}</strong></div>` +
                    `<div>Relato cliente: <strong>${formaterText(item.chamado.OBSDEFEITOATS)}</strong></div>` +
                    `<div>--------------------------------------------------------------------------------------------------------------------------------------------</div>` +
                    `<div>Cliente: <strong>${formaterText(item.cliente.NMCLIENTE)}</strong></div>` +
                    `<div>Endereço: <strong>${formaterText(item.cliente.ENDERECO)} ${formaterText(item.cliente.BAIRRO)}</strong></div>` +
                    `<div>Contato: <strong>${formaterText(item.chamado.CONTATO)}</strong></div>` +
                    `<div>--------------------------------------------------------------------------------------------------------------------------------------------</div>`);

                infoWindow.open(map, arrMarker[item.atendimentoId]);

                calcTimeAtendimento(item);
            }

            function getStatus(andamento){

                if(andamento >= 0 && andamento <= 5){
                    return 'Em deslocamento para o cliente';
                }else if(andamento >= 6 && andamento <= 11){
                    return 'Em atendimento';
                }else if(andamento == 15){
                    return 'Atendimento cancelado';
                }else if(andamento == 20){
                    return 'Em deslocamento para outro chamado';
                }else if(andamento == 23){
                    return 'Em deslocamento';
                }else if(andamento == 24){
                    return 'Em deslocamento';
                }else{
                    return '';
                }
            }

            function formaterText(data){
                if(data != null && data != undefined){
                    return data;
                }else{
                    return '';
                }
            }

            function calcTimeAtendimento(data){
                // limpa o intervalo anterior
                if(idSetInterval != null){ clearInterval(idSetInterval); }

                idSetInterval = setInterval(function(){

                    const startTime = data.HRATENDIMENTO != '00:00:00' ? `${data.DTATENDIMENTO} ${data.HRATENDIMENTO}` : null;
                    const endTime = data.HRATENDIMENTOFIN != '00:00:00' ? `${data.DTATENDIMENTO} ${data.HRATENDIMENTOFIN}` : moment().format("YYYY-MM-DD HH:mm:ss");

                    if(startTime != null){
                        
                        // calcula o tempo de atendimento
                        var t = moment(new Date(startTime)).twix(endTime);

                        const amount = t.count('minutes');
                        let text = '';

                        if(amount < 60){
                            text = `${amount} min`; 
                        }else{
                            let hour = Math.floor(amount / 60);
                            let minutes = amount - (hour * 60);

                            text = `${hour}h e ${minutes}min`; 
                        }

                        $('#value_tempoatendimento').html(text);
                    }else{
                        $('#value_tempoatendimento').html("-");
                    }
                }, 1000);
            }
    </script>
<script src="<?php echo $this->webroot; ?>js/moment.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/twix.min.js?v=<?php echo $version; ?>"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJzqCIQ3uPa_gK3-VG3LhHNDB-pWL09ho&callback=showMap" type="text/javascript"></script>