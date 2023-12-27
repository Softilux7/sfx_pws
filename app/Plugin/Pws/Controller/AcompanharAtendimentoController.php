<?php

App::uses('CakeTime', 'Utility');
App::uses('Chamado', 'Pws.Model');
App::uses('AcompanharAtendimento', 'Pws.Model');
App::uses('PaginatorHelper', 'View/Helper');
App::uses('S3', 'Lib');

/**
 * Classe responsável pelo controle dos arquivo de acompanhamento dos chamados
 *
 * @autor Gustavo Silva
 * @since 14/07/2019
 */

class AcompanharAtendimentoController extends PwsAppController
{

    // informações Bucket S3 Amazon
    protected $amazonKey          = "AKIAZK4EYKEE5I7KZE4L";
    protected $amazonSecretKey    = "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";
    protected $amazonEndPoint     = "pws-homologacao.s3.amazonaws.com";
    protected $amazonBucket       = "pws-homologacao";

    public function beforeFilter()
    {

        parent::beforeFilter();
    }

    /**
     * Lista todos os atendimentos
     * @autor Gustavo Silva
     * @since 14/07/2019
     */
    public function index($param = null)
    {

        // verifica se é uma requisição ajax
        if ($this->request->isAjax() || isset($this->request->query['json'])) {

            $this->autoRender                       = false;
            $this->layout                           = false;
            $this->AcompanharAtendimento->recursive = 0;

            // busca os atendimento que foram feitos pelo APP
            $paginate['conditions'] = array(
                $this->Filter->getConditions(),
                'AcompanharAtendimento.empresa_id'         =>  $this->empresa,
                'AcompanharAtendimento.ID_BASE = '          => $this->matriz,
                'AcompanharAtendimento.ORIGEM_CADASTRO = ' => 'APP',
            );

            // verifica o json de campos do filtros
            // TODO:: COLOCAR EM UMA CLASSE SEPARADA
            if ($this->request->query['json']) {

                foreach ($this->request->query['json'] as $key => $data) {

                    if (isset($data["item"])) {

                        if ($data["item"][0]['value'] != '') {

                            $date = DateTime::createFromFormat('d/m/Y', $data["item"][0]['value']);

                            if (is_object($date)) {

                                $paginate['conditions']["{$key} {$data["item"][0]['operator']}"] = $date->format('Y-m-d');
                            }
                        }
                        if ($data["item"][1]['value'] != '') {

                            $date = DateTime::createFromFormat('d/m/Y', $data["item"][1]['value']);

                            if (is_object($date)) {

                                $paginate['conditions']["{$key} {$data["item"][1]['operator']}"] = $date->format('Y-m-d');
                            }
                        }
                    } else {

                        if ($data['value'] != '') {

                            $paginate['conditions']["{$key} {$data['operator']}"] = $data['value'];
                        }
                    }
                }
            }

            $paginate['order']     = 'AcompanharAtendimento.id DESC';
            $paginate['limit']     = $_GET['rowCount'];
            $paginate['page']      = $_GET['current'];
            $paginate['recursive'] = '0';
            $this->paginate         = $paginate;

            $paginatorHelper        = new PaginatorHelper(new View(null));
            $records                = $this->paginate();
            $paginateParams         = $paginatorHelper->params();

            $jsonData = array();

            $arrStatus = $this->getStatus();

            foreach ($records as $key => $data) {

                switch($data['AcompanharAtendimento']['DESLOCAMENTO_APP']){
                    case '1' : 
                        $deslocamento = "Veículo"; 
                        break;
                    case '2' : 
                        $deslocamento = "T. Público/Privado"; 
                        break;
                    case '0' : 
                        $deslocamento = "Sem deslocamento"; 
                        break;
                    default:
                        $deslocamento = "-";
                }

                $jsonData[] = array(
                    "id"          => $data['AcompanharAtendimento']['id'],
                    "agendamento"   => "--",
                    "tecnico"       => $data['AcompanharAtendimento']['NMATENDENTE'],
                    "cliente"       => $data['Cliente']['FANTASIA'],
                    "idChamado"     => $data['AcompanharAtendimento']['SEQOS'] . " / " . $data['AcompanharAtendimento']['chamado_id'],
                    "seqos"         => $data['AcompanharAtendimento']['SEQOS'],
                    "status"        => $arrStatus[$data['AcompanharAtendimento']['ANDAMENTO_CHAMADO_APP']],
                    "deslocamento"  => $deslocamento,
                    "inicio"        => CakeTime::format($data['AcompanharAtendimento']['DTATENDIMENTO'] . " " . $data['AcompanharAtendimento']['HRATENDIMENTO'], "%d/%m/%y %H:%M"),
                    "prazo"         => "--",
                    "regiao"        => "--",
                    "tempo"         => "--",
                    "hash"          => Security::hash($data['AcompanharAtendimento']['id'] . $this->empresa)
                );
            }

            return json_encode(
                array(
                    "current"   => $paginateParams['page'],
                    "rowCount"  => $paginateParams['current'],
                    "rows"      => $jsonData,
                    "total"     => $paginateParams['count']
                )
            );
        } else {

            // instancia classe
            $acompanharAtendimento = new AcompanharAtendimento();
            $arrTecnico = array();
            $arrCliente = array();

            // consulta os técnicos
            $queryTecnico = $acompanharAtendimento->getTecnico($this->getActiveCompany(), $this->matriz);

            foreach ($queryTecnico as $key => $data) {
                $name = $data['tecnicos']['NMSUPORTE'];
                // monta o combo com o nome da empresa quando o usuário está visualizando todas as empresas
                $arrTecnico[$name] = $this->AllActiveCompany() == -1 ? $name . " [" . $this->getInfoCompany($data['tecnicos']['empresa_id'])['empresa_fantasia'] . "]" : $name;
            }

            // consulta os clientes
            $queryCliente = $acompanharAtendimento->getCliente($this->getActiveCompany(), $this->matriz);

            foreach ($queryCliente as $key => $data) {
                $name = $data['clientes']['FANTASIA'];

                // monta o combo com o nome da empresa quando o usuário está visualizando todas as empresas
                $arrCliente[$data['clientes']['CDCLIENTE']] = $this->AllActiveCompany() == -1 ? $name . " [" . $this->getInfoCompany($this->getActiveCompany())['empresa_fantasia'] . "]" : $name;
            }

            $this->set('arrCliente', $arrCliente);
            $this->set('arrTecnico', $arrTecnico);

            // remove alguns status para a primeira versão
            $arrStatus = $this->getStatus();
            unset($arrStatus[0]);
            unset($arrStatus[20]);
            unset($arrStatus[23]);
            unset($arrStatus[24]);


            $this->set('arrStatus', $arrStatus);
        }
    }

    public function maps (){

        // $this->autoRender   = false;
        // $this->layout       = false;

    }

    /**
     * Monta a time line com o maps
     * 
     * @autor Gustavo Silva
     * @since 16/07/2019
     */
    public function timeline()
    {

        $this->autoRender   = false;
        $this->layout       = false;

        $id   = $this->request->query['id'];
        $hash = $this->request->query['hash'];

        // classe de retorno para ajax
        $jsonResult = new JsonResult();

        if (Security::hash($id . $this->empresa) == $hash) {

            $timeline = new AcompanharAtendimento();

            //instancia o template de view
            $view = new View($this);

            $arrTimeline = $timeline->timeline($id);
            $arrStatus = $this->getStatus();
            $arrPausa = array(1 => 'Café', 2 => 'Trânsito', 3 => 'Almoço');
            $arrData = array();
            $progress = 0;

            foreach($arrTimeline as $key => $result){

                $data = $result['app_atendimento_timeline'];

                // define a data;
                $dt =  new DateTime($data['create_at']);
                $pausa = '';

                if($data['andamento_chamado_snapshot'] >= $progress){

                    $pausa = isset($arrPausa[(int)$data['motivo']]) ? ' - ' . $arrPausa[(int)$data['motivo']] : '';
                    $pausa = (int) $data['motivo'] == 100 ?  'Pausa - ' . $data['motivo_outros'] : $pausa;

                    $label = $arrStatus[$data['andamento_chamado_snapshot']];

                }else{
                    $label = 'Retorno pausa';
                }

                $arrData[] = array('dtFormat' => $dt->format("d/m/y"), 'dt' => $data['create_at'], 'hour' => $dt->format('H:i'), 'label' => $label, 'pausa' => $pausa);

                $progress = $data['andamento_chamado_snapshot'];

            }

            // $view->set('records', $timeline->timeline($id));
            $view->set('records', $arrData);
            $view->set('arrStatus', $this->getStatus());
            $view->set('idTimeline', $id);

            // monta a tela
            $jsonResult->setContent($view->render('timeline'));
        }

        return $jsonResult->result();
    }

    /**
     * Pega as localizaçõs do mapa
     * 
     * @autor Gustavo Silva
     * @since 15/08/2019
     */
    public function getLocations()
    {

        $this->autoRender   = false;
        $this->layout       = false;

        $id                 = $this->request->query['id'];
        $dataAddress        = array();
        $waypoints          = array();
        $markers            = array();
        $dateCreate         = 0;

        // instancia o model
        $timeline = new AcompanharAtendimento();

        $status = $this->getStatus();

        // consulta os registros de localização
        $dataTimeline = $timeline->locations($id);

        $refLat = 0;
        $refLong = 0;
        $calcDist = -1;

        $origin = array();
        $destination = array();

        // verifica se possui registros
        if(count($dataTimeline) > 0){

            $dateCreate = date('Ymd', strtotime($dataTimeline[0]['app_atendimento_timeline']['create_at']));

            // seta a origem
            $data = $dataTimeline[0]['app_atendimento_timeline'];
            $origin = array('latitude' => $data['latitute'], 'longitude' => $data['longitute']);

            $refLat = $data['latitute'];
            $refLong = $data['longitute'];

            $destination = $origin;

            if(count($dataTimeline) > 1){

                // seta o destino
                $data = $dataTimeline[count($dataTimeline) - 1]['app_atendimento_timeline'];
                $destination = array('latitude' => $data['latitute'], 'longitude' => $data['longitute']);

            }

            // unset($dataTimeline[0]);
            // unset($dataTimeline[count($dataTimeline) - 1]);

        }

        // tamanho do grupo
        $groupSize = 50;

        // define quanto grupos serão criados
        $amountGroup = ceil(locations.waypoints.length / groupSize);
            
        // conta o tamanho do grupo
        $countGroup = 1;

        // índice do grupo
        $group = 0;
        $latOld = 0;
        $lngOld = 0;

        $amontDist = 0;
        $amountDistance = 0;

        foreach ($dataTimeline as $key => $data) {

            // $address = $data['app_atendimento_timeline']['address'];
            $latitude = $data['app_atendimento_timeline']['latitute'];
            $longitude = $data['app_atendimento_timeline']['longitute'];

            if(($latitude+$longitude) != ($latOld+$lngOld)){

                if($latOld != 0){
                    $calcDistance = $this->calculateDistance($latOld, $latitude, $lngOld, $longitude);
                }
                
                if(($calcDistance > 0) || $latOld == 0){
                    // _tst($calcDistance);
                    $amontDist += $calcDistance;
                    $dataAddress[$group][] = array('latitude' => $latitude, 'longitude' => $longitude);

                }

                if($countGroup >= $groupSize){
                    $countGroup = 0;
                    $group++;
                }else{
                    $countGroup++;
                }

            }

            $latOld = $latitude;
            $lngOld = $longitude;

        }
        
        return json_encode(array(
            'origin'       => $origin,
            'destination'  => $destination,
            'waypoints'    => $dataAddress,
            'markers'      => $markers,
            'calc'         => number_format($amontDist, 2),
            'date'         => $dateCreate
        ));
    }

    private function calculateDistance($lat1, $lat2, $lon1, $lon2){

        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);
        $lon1 = deg2rad($lon1);
        $lon2 = deg2rad($lon2);

        $latD = $lat2 - $lat1;
        $lonD = $lon2 - $lon1;

        $dist = 2 * asin(sqrt(pow(sin($latD / 2), 2) +
        cos($lat1) * cos($lat2) * pow(sin($lonD / 2), 2)));
        $dist = $dist * 6371;

        return number_format($dist, 2, '.', '');
    }

    /**
     * Monta as imagens do atendimento
     * 
     * @autor Gustavo Silva
     * @since 16/07/2019
     */
    public function image()
    {

        $this->autoRender   = false;
        $this->layout       = false;

        $id             = $this->request->query['id'];
        $pictureType    = $this->request->query['pictureType'];
        $hash           = $this->request->query['hash'];

        // classe de retorno para ajax
        $jsonResult = new JsonResult();

        if (Security::hash($id . $this->empresa) == $hash) {

            $timeline = new AcompanharAtendimento();

            // consulta as imagens referente ao chamado
            $imagesResult = $timeline->image($id, $pictureType);

            $arrImage = array();

            foreach ($imagesResult as $key => $data) {

                $arrImage[] = "?id={$data['app_atendimento_photos']['id']}&idAtendimento={$id}&hash={$hash}";
            }

            //instancia o template de view
            $view = new View($this);

            // TIPO DE IMAGEM : IMAGENS DOS EQUIPAMENTOS O ASSINATURA DO CLIENTE
            $view->set('records', $arrImage);

            // monta a tela
            $jsonResult->setContent($view->render('image'));
        }

        return $jsonResult->result();
    }

    public function renderImage()
    {

        $this->autoRender   = false;
        $this->layout       = false;

        $id = $this->request->query['id'];
        $idAtendimento  = $this->request->query['idAtendimento'];
        $hash           = $this->request->query['hash'];

        if (Security::hash($idAtendimento . $this->empresa) == $hash) {
            //
            $model = new AcompanharAtendimento();

            // // consulta os dados da imagem
            $data = $model->getImage($id);
            $data = $data[0]['app_atendimento_photos'];

            header("Content-Type: image/jpeg");

            $imgContents = file_get_contents("/var/www/html/files" . $data['path'] . $data['filename']);

            $image = @imagecreatefromstring($imgContents);

            imagejpeg($image);
        }else{
            echo 'inválido';
        }
    }

    public function getStatus()
    { 
        return  array(
            0  => 'Atividade retomada',
            1  => 'Atendimento selecionado',
            2  => 'Viagem iniciada',
            3  => 'Pausa',
            4  => 'Chegada no cliente',
            5  => 'Pausa',
            6  => 'Início do atendimento',
            7  => 'Pausa',
            8  => 'Fim do atendimento',
            10 => 'Formulário preenchido',
            11 => 'Atendimento concluído',
            15 => 'Atendimento cancelado',
            20 => 'Deslocando para atendimento',
            23 => 'Retornando para empresa',
            24 => 'Retornando para casa',
            30 => 'Concluído',
        );
    }

    /**
     * Pega os dados para montar o header
     * 
     * @autor Gustavo Silva
     * @since 24/02/2020
     * 
     * @return json
     */
    public function getDataHeader()
    {

        $this->autoRender   = false;
        $this->layout       = false;

        $idBase    = $this->matriz;
        $idEmpresa = is_array($this->empresa) ? implode(",", $this->empresa) : $this->empresa;

        $arrStatus = array(
            'rota'        => array('amount' => 0, 'atendente' => array()),
            'cliente'     => array('amount' => 0, 'atendente' => array()),
            'atendimento' => array('amount' => 0, 'atendente' => array()),
            'finalizado'  => array('amount' => 0, 'atendente' => array()),
        );

        $date = date("Y-m-d");

        $query = $this->AcompanharAtendimento->query("SELECT ANDAMENTO_CHAMADO_APP, NMATENDENTE 
                                                            FROM atendimentos 
                                                            WHERE ID_BASE = {$idBase}
                                                            AND NMATENDENTE <> ''
                                                            AND empresa_id in ({$idEmpresa})
                                                            AND DTATENDIMENTO = '{$date}'
                                                            ");

        foreach ($query as $key => $data) {

            $status = $data['atendimentos']['ANDAMENTO_CHAMADO_APP'];
            $nmatendente = $data['atendimentos']['NMATENDENTE'];

            if ($status == 2 || $status == 3) {
                $arrStatus['rota']['amount'] += 1;
                $arrStatus['rota']['atendente'][] = $nmatendente;
            } elseif ($status == 4 || $status == 5) {
                $arrStatus['cliente']['amount'] += 1;
                $arrStatus['cliente']['atendente'][] = $nmatendente;
            } elseif ($status == 6 || $status == 7) {
                $arrStatus['atendimento']['amount'] += 1;
                $arrStatus['atendimento']['atendente'][] = $nmatendente;
            } elseif ($status >= 8 && $status <= 11) {
                $arrStatus['finalizado']['amount'] += 1;
                $arrStatus['finalizado']['atendente'][] = $nmatendente;
            }
        }

        // classe de retorno para ajax
        $jsonResult = new JsonResult();

        $jsonResult->setContent($arrStatus);

        return $jsonResult->result();
    }

    /**
     * Mostra os detalhes do formulário preenchido 
     * 
     * @autor Gustavo Silva
     * @since 15/05/2020
     */
    public function detail()
    {
        $this->autoRender   = false;
        $this->layout       = false;

        $id             = $this->request->query['id'];
        $hash           = $this->request->query['hash'];

        // classe de retorno para ajax
        $jsonResult = new JsonResult();

        $this->AcompanharAtendimento->id = $id;

        $data = $this->AcompanharAtendimento->find('first', array('conditions' => array(
            'AcompanharAtendimento.id' => $id,
            'AcompanharAtendimento.TFVISITA' => 'S'
        )));

        // if (Security::hash($id . $this->empresa) == $hash) {

        // //instancia o template de view
        $view = new View($this);

        $view->set('data', $data);

        // monta a tela
        $jsonResult->setContent($view->render('detail'));
        // }

        return $jsonResult->result();
    }

    public function getItemChamado(){

        $this->autoRender   = false;
        $this->layout       = false;

        $id = $this->request->query['id'];
        $seqOS = $this->request->query['seqos'];
        $idAtendimento  = $this->request->query['idAtendimento'];
        $hash           = $this->request->query['hash'];

        $idBase    = $this->matriz;
        $idEmpresa = is_array($this->empresa) ? implode(",", $this->empresa) : $this->empresa;

        if (Security::hash($id . $this->empresa) == $hash) {
            
            // consulta os itens do chamado
            $data = $this->AcompanharAtendimento->query("SELECT ci.QUANTIDADE, ci.CDPRODUTO, ci.CDMEDIDOR, ci.MEDIDOR, p.NMPRODUTO, el.NMLOCESTOQUE
                                                            FROM chamados_itens ci
                                                            INNER JOIN produtos p ON (p.CDPRODUTO = ci.CDPRODUTO and p.ID_BASE = ci.ID_BASE)
                                                            INNER JOIN estoque_local el ON (el.CDLOCESTOQUE = ci.CDLOCESTOQUE and el.ID_BASE = ci.ID_BASE)
                                                            WHERE ci.seqos = {$seqOS}
                                                            AND ci.ID_BASE = {$idBase}
                                                            AND ci.empresa_id IN ({$idEmpresa})");

            $view = new View($this);

            // classe de retorno para ajax
            $jsonResult = new JsonResult();

            $view->set('data', $data);

            // monta a tela
            $jsonResult->setContent($view->render('itemchamado'));

            return $jsonResult->result();

        }else{
            echo 'inválido';
        }

    }

    public function getServiceTechnician(){
        $this->autoRender   = false;
        $this->layout       = false;

        $response= array();

        $idBaseAtendimento = '';
        $idBaseTimeline = '';

        if($this->matriz != 1){
            $idBaseAtendimento = "AND a.ID_BASE = {$this->matriz}";
            $idBaseTimeline = "AND aat.ID_BASE = {$this->matriz}";
        }

        // consulta os itens do chamado
        $data = $this->AcompanharAtendimento->query("SELECT aat.id_atendimento, aat.id_transaction, aat.andamento_chamado_snapshot, aat.latitute, aat.longitute, a.NMATENDENTE,
                                                            c.NMCLIENTE, c.ENDERECO, c.BAIRRO, c.LOCALINSTAL, c.id, c.SEQOS, c.OBSDEFEITOATS, c.DEPARTAMENTO, c.CONTATO,
                                                            e.CDPRODUTO, e.SERIE, e.MODELO, e.FABRICANTE, a.DTATENDIMENTO, a.HRATENDIMENTO, a.HRATENDIMENTOFIN,
                                                            em.id, em.empresa_fantasia
                                                            FROM app_atendimento_timeline aat
                                                            INNER JOIN atendimentos a ON a.id = aat.id_atendimento
                                                            INNER JOIN chamados c ON c.id = a.chamado_id
                                                            INNER JOIN equipamentos e ON e.CDEQUIPAMENTO = c.CDEQUIPAMENTO AND e.empresa_id = c.empresa_id AND e.ID_BASE = c.ID_BASE
                                                            INNER JOIN empresas em ON em.id = a.empresa_id  
                                                            WHERE aat.id_atendimento in (SELECT id
                                                                                                FROM atendimentos a
                                                                                                WHERE a.ORIGEM_CADASTRO = 'APP' 
                                                                                                {$idBaseAtendimento}
                                                                                                AND (a.ANDAMENTO_CHAMADO_APP <> 15 AND a.ANDAMENTO_CHAMADO_APP <> 30 AND a.ANDAMENTO_CHAMADO_APP <> 31) 
                                                                                                AND a.DTATENDIMENTO = '" . date('Y-m-d') . "')
                                                            {$idBaseTimeline}
                                                            group by aat.id_atendimento, aat.andamento_chamado_snapshot
                                                            ORDER BY aat.id_atendimento, id_transaction  DESC");
    
        
        $status = $this->getStatus();
        $check = array();

        foreach($data as $value){

            $timeline = $value['aat'];
            $atendimento = $value['a'];
            $chamado = $value['c'];
            $equipamento = $value['e'];
            $empresa = $value['em'];

            if(!in_array($timeline['id_atendimento'], $check)){
                $response[] = array(    'atendimentoId' => $timeline['id_atendimento'],
                                        'atualizacao' => date('H:i'),
                                        'chamadoId' => $chamado['id'],
                                        'seqos' => $chamado['SEQOS'],
                                        'lat' => $timeline['latitute'], 
                                        'lng' => $timeline['longitute'],
                                        'andamento' => $timeline['andamento_chamado_snapshot'],
                                        'status' => $status[$timeline['andamento_chamado_snapshot']],
                                        'tecnico' => $atendimento['NMATENDENTE'],
                                        'DTATENDIMENTO' => $atendimento['DTATENDIMENTO'],
                                        'HRATENDIMENTO' => $atendimento['HRATENDIMENTO'],
                                        'HRATENDIMENTOFIN' => $atendimento['HRATENDIMENTOFIN'],
                                        'cliente' => array( 'NMCLIENTE' => $chamado['NMCLIENTE'],
                                                            'ENDERECO' => $chamado['ENDERECO'],
                                                            'BAIRRO' => $chamado['BAIRRO'],
                                                            'LOCALINSTAL' => $chamado['LOCALINSTAL']),
                                        'chamado' => array('OBSDEFEITOATS' => $chamado['OBSDEFEITOATS'],
                                                           'DEPARTAMENTO' => $chamado['DEPARTAMENTO'],
                                                           'CONTATO'=> $chamado['CONTATO']),
                                        'equipamento' => array('CDPRODUTO' => $equipamento['CDPRODUTO'], 
                                                               'SERIE' => $equipamento['SERIE'], 
                                                               'MODELO' => $equipamento['MODELO'], 
                                                               'FABRICANTE' => $equipamento['FABRICANTE']),
                                        'empresa'=> array('id' => $empresa['id'],
                                                          'empresa_fantasia'=> $empresa['empresa_fantasia'])
                                                            
                                        );

                array_push($check, $timeline['id_atendimento']);
            }

        }

        return json_encode($response);

    }
}
