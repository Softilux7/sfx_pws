<?php
App::uses('PwsAppController', 'Pws.Controller');
App::uses('Relatorio', 'Pws.Model');

/**
 * Equipamentos Controller
 *
 * @property Equipamento $Equipamento
 */
class RelatoriosController extends PwsAppController
{
    public $components = array(
        'HorasDiasUteis'
    );


    /**
     * index method
     *
     * @return void
     */
    public function index()
    {

        $this->loadModel('Pws.Equipamento');
        //$this->setarDB($this->conect);
        if ($this->request->isAjax()) {
            $this->layout = null;
        }

        $auth_user_group = $this->Session->read('auth_user_group');
        $auth_user = $this->Session->read('auth_user');

        // AJUSTADO PARA EMPRESA DATA VOICE
        // Clientes não podem visualizar chamados concluídos
        if($auth_user['User']['empresa_id'] == 15 and $auth_user_group['id'] == 3){
            echo '<h3 style="margin-top:50px;margin-left:40px;color:#cc0000">Atenção, você não tem permissão para acessar essa informação</h3>';
        }

        //$this->set('relatorios', $relatorios);
    }

    /**
     * index method
     *
     * @return void
     */
    public function chamado_periodo()
    {

        $this->loadModel('Pws.Equipamento');
        $this->loadModel('Pws.Cliente');

        //$this->setarDB($this->conect);

        if ($this->request->isAjax()) {
            $this->layout = null;
        }

        $this->set('arrTecnicos', $this->getAllTecnicos());
        $this->set('checkStatusAtendido', $this->checkStatusAtendido());

        //$this->set('relatorios', $relatorios);
    }

    /**
     * index method
     *
     * @return void
     */
    public function chamado_at()
    {

        $this->loadModel('Pws.Equipamento');
        $this->loadModel('Pws.Cliente');

        //$this->setarDB($this->conect);

        if ($this->request->isAjax()) {
            $this->layout = null;
        }

        $this->set('arrTecnicos', $this->getAllTecnicos());
        $this->set('checkStatusAtendido', $this->checkStatusAtendido());

        //$this->set('relatorios', $relatorios);
    }

    private function checkStatusAtendido(){

        $auth_user = $this->Session->read('auth_user');

        return $auth_user['EmpresaSelected']['Empresa']['versao'] == 1 ? true : false;

    }

    /**
     * index method
     *
     * @return void
     */
    public function chamado_c()
    {
        $this->loadModel('Pws.Equipamento');
        $this->loadModel('Pws.Cliente');

        if ($this->request->isAjax()) {
            $this->layout = null;
        }

        $this->set('arrTecnicos', $this->getAllTecnicos());
    }

    /**
     * @autor Gustavo Silva
     */
    private function conditionForTecnicoTerceirizado($conditions){

        $auth_user_group = $this->Session->read('auth_user_group');
        $auth_user = $this->Session->read('auth_user');

        // verifica se é perfil de tecnico e terceirizado
        if($auth_user_group['id'] == 2 && $auth_user['User']['tecnico_terceirizado'] == true){

            // adiciona a condição para buscar somente os chamados relacionados ao técnico
            $conditions['Chamado.NMSUPORTET'] = $auth_user['User']['tecnico_id'];

        }

        return $conditions;

    }

    /**
     * @autor Gustavo Silva
     */
    private function getAllTecnicos(){

        $this->loadModel('Pws.Tecnico');

        $tecnicoModel = new Tecnico();
        $return = array();

        $query = $tecnicoModel->query("SELECT id, NMSUPORTE FROM tecnicos WHERE ID_BASE = {$this->matriz} ORDER BY NMSUPORTE");

        if(count($query)){
            foreach($query as $key => $data){
                $return[$data['tecnicos']['NMSUPORTE']] = $data['tecnicos']['NMSUPORTE'];
            }
        }

        return $return;
    }

    /**
     * index method
     *
     * @return void
     */
    public function chamado_periodo_result()
    {
        $this->loadModel('Pws.Chamado');
        $this->loadModel('Pws.Cliente');
        $auth_user_group = $this->Session->read('auth_user_group');
        $auth_user = $this->Session->read('auth_user');


        if ($this->request->is('post') || $this->request->is('put')) {

            if ($this->request->data['PERIODOINI'] =='' || $this->request->data['PERIODOFIM'] =='' ){
                $this->Session->setFlash('ERRO: Periodo inicial e final precisa estar preenchido!!');
                $this->redirect(array(
                    'action' => 'chamado_periodo'
                ));
            }
            
            if($this->request->data['Cliente'] != ''){
                if ($auth_user_group['id'] != 3) {
                    $cliente = $this->Cliente->find('first', array(
                        'conditions' => array(
                            'Cliente.id' => $this->request->data['Cliente'],
                            'Cliente.ID_BASE' => $this->matriz
                        )
                    ));
                } else {
                    $cliente = $this->Cliente->find('first', array(
                        'conditions' => array(
                            'Cliente.CDCLIENTE' => $this->request->data['Cliente'],
                            'Cliente.ID_BASE' => $this->matriz
                        )
                    ));
                }
            }

            $conditions = array();

            // Cliente
            if ($this->request->data['Cliente']!=''){
                $conditions['Chamado.CDCLIENTE'] = $cliente['Cliente']['CDCLIENTE'];
            }

            // Serie
            if ($this->request->data['SERIE']!=''){
                $conditions['Equipamento.SERIE'] = $this->request->data['SERIE'];
            }
           // Status
            if ($this->request->data['STATUS']!=''){
                // para status P adiciona os status L e S
                $status = $this->request->data['STATUS'] == 'P' ? array('P', 'L', 'S') : $this->request->data['STATUS'];

                $conditions['Chamado.STATUS'] = $this->request->data['STATUS'];
            }

            if ($auth_user_group['id']!=1){
                $conditions['Chamado.ID_BASE'] = $this->matriz;
            }

            // Periodo
            if ($this->request->data['PERIODOINI'] !='' || $this->request->data['PERIODOFIM'] !=''){

                $periodoIni = date('Y-m-d',strtotime($this->request->data['PERIODOINI']));
                $periodoFim =  date('Y-m-d',strtotime($this->request->data['PERIODOFIM']));

                $dateFilter = $this->request->data['DATEFILTER'];
                
                $conditions["Chamado.{$dateFilter} >= "] = $periodoIni;
                $conditions["Chamado.{$dateFilter} <= "] =  $periodoFim;
                
            }

            // adiciona a condição para técnicos terceirizados
            $conditions = $this->conditionForTecnicoTerceirizado($conditions);

            //  adiciona a restrição caso não seja selecionado um cliente (perfil admin visualiza todos os clientes)
            if(($this->request->data['Cliente'] == '' or $this->request->data['Cliente'] == -1) && $auth_user_group['id'] != 1){

                if(count($this->cdCliente) > 0){
                    // adiciona quais clientes que são permitidos
                    $conditions['Chamado.CDCLIENTE'] = $this->cdCliente;
                }

            }

            // adicona condição para quando for selecionado um tecnico específico no relatório (Admin revenda e Administrador)
            if(isset($this->request->data['NMSUPORTET']) && ($auth_user_group['id'] == 1 || $auth_user_group['id'] == 6)){

                if($this->request->data['NMSUPORTET'] != ''){
                    $conditions['Chamado.NMSUPORTET'] = $this->request->data['NMSUPORTET'];
                }

            }

            $chamados = $this->Chamado->find('all',array(
                'conditions' => $conditions,
                'order'=> array('Chamado.DTINCLUSAO'=>'ASC')
            ));

            // calcula os valores de atendimento para técnicos terceirizados e admin revenda
            // if($auth_user['User']['tecnico_terceirizado'] == true || $auth_user_group['id'] == 6 || $auth_user_group['id'] == 1){

                $model = new Relatorio();

                // consulta os atendimento dos chamados
                $this->set('arrAtendimento', $model->getAtendimentos($chamados));

            // }

            $nmcliente = $cliente['Cliente']['NMCLIENTE'];

            $totalChamados = count($chamados);

            $this->set('totalChamados', $totalChamados);
            $this->set('nmcliente', $nmcliente);
            $this->set('cdcliente', $cliente['Cliente']['CDCLIENTE']);
            $this->set('chamados', $chamados);
            $this->set('periodoini', $this->request->data['PERIODOINI']);
            $this->set('periodofim', $this->request->data['PERIODOFIM']);
        }

    }

    /**
     * index method
     *
     * @return void
     */
    public function chamado_at_result()
    {
        $this->loadModel('Pws.Chamado');
        $this->loadModel('Pws.Cliente');
        $auth_user_group = $this->Session->read('auth_user_group');
        $auth_user = $this->Session->read('auth_user');

        if ($this->matriz==4) {
            date_default_timezone_set('America/Bahia');
        } else {
            date_default_timezone_set('America/Sao_Paulo');
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            if ($this->request->data['PERIODOINI'] =='' || $this->request->data['PERIODOFIM'] =='' ){
                $this->Session->setFlash('ERRO: Periodo inicial e final precisa estar preenchido!!');
                $this->redirect(array(
                    'action' => 'chamado_periodo'
                ));
            }


            if ($auth_user_group['id']!=3){

                if (empty($this->request->data['Cliente'])){
                    $this->request->data['Cliente'] = 0;
                }

                $cliente = $this->Cliente->find('first', array(
                    'conditions' => array(
                       'Cliente.id' => $this->request->data['Cliente'],
                        'Cliente.ID_BASE' => $this->matriz
                    )));

            } else {
                $cliente = $this->Cliente->find('first', array(
                    'conditions' => array(
                        'Cliente.CDCLIENTE' => $this->request->data['Cliente'],
                        'Cliente.ID_BASE' => $this->matriz
                    )));
            }
            $conditions = array();

            // Cliente
            if ($this->request->data['Cliente']!=0){
                $conditions['Chamado.CDCLIENTE'] = $cliente['Cliente']['CDCLIENTE'];
            }

            // Serie
            if ($this->request->data['SERIE']!=''){
                $conditions['Equipamento.SERIE'] = $this->request->data['SERIE'];
            }

            // if ($auth_user_group['id']!=1){
                $conditions['Chamado.ID_BASE'] = $this->matriz;
            // }
            // Status
            if ($this->request->data['STATUS']!=''){
                // para status P adiciona os status L e S
                $status = $this->request->data['STATUS'] == 'P' ? array('P', 'L', 'S') : $this->request->data['STATUS'];
                
                $conditions['Chamado.STATUS'] = $this->request->data['STATUS'];
            }

            // Periodo
            if ($this->request->data['PERIODOINI'] !='' || $this->request->data['PERIODOFIM'] !=''){

                $periodoIni = date('Y-m-d',strtotime($this->request->data['PERIODOINI']));
                $periodoFim =  date('Y-m-d',strtotime($this->request->data['PERIODOFIM']));

                $dateFilter = $this->request->data['DATEFILTER'];
                
                $conditions["Chamado.{$dateFilter} >= "] = $periodoIni;
                $conditions["Chamado.{$dateFilter} <= "] =  $periodoFim;
            }

            // adiciona a condição para técnicos terceirizados
            $conditions = $this->conditionForTecnicoTerceirizado($conditions);

            //  adiciona a restrição caso não seja selecionado um cliente (perfil admin visualiza todos os clientes)
            if(($this->request->data['Cliente'] == '' or $this->request->data['Cliente'] == -1) && $auth_user_group['id'] != 1){

                if(count($this->cdCliente) > 0){
                    // adiciona quais clientes que são permitidos
                    $conditions['Chamado.CDCLIENTE'] = $this->cdCliente;
                }

            }

            // adicona condição para quando for selecionado um tecnico específico no relatório (Admin revenda e Administrador)
            if(isset($this->request->data['NMSUPORTET']) && ($auth_user_group['id'] == 1 || $auth_user_group['id'] == 6)){

                if($this->request->data['NMSUPORTET'] != ''){
                    $conditions['Chamado.NMSUPORTET'] = $this->request->data['NMSUPORTET'];
                }

            }

            $chamados = $this->Chamado->find('all',array(
                'conditions' => $conditions,
                'order'=> array('Chamado.DTINCLUSAO'=>'ASC')
            ));

            // calcula os valores de atendimento para técnicos terceirizados e admin revenda
            if($auth_user['User']['tecnico_terceirizado'] == true || $auth_user_group['id'] == 6 || $auth_user_group['id'] == 1){

                $model = new Relatorio();

                $arrAtendimentos = $model->getAtendimentos($chamados, array(" AND (DTATENDIMENTO >= '{$periodoIni}' AND DTATENDIMENTO <= '{$periodoFim}')"));

                // consulta os atendimento dos chamados
                $this->set('arrAtendimento', $arrAtendimentos);

            }

            // monstra as imagens no relatório
            $arrImage = array();

            if($this->request->data['imagens'] == 1){

                $arrImagesAtendimento = $model->getImagesAtendimento($arrAtendimentos);

                foreach ($arrImagesAtendimento as $key => $data) {

                    $dataPhotos = $data['app_atendimento_photos'];

                    // gera o hash da imagem
                    $hash = Security::hash($dataPhotos['id_atendimento'] . $this->empresa);
                    
                    $arrImage[$dataPhotos['id_atendimento']][] = "?id={$dataPhotos['id']}&idAtendimento={$dataPhotos['id_atendimento']}&hash={$hash}";

                }
            }

            // busca as imagens dos atendimentos
            $this->set('arrImagesAtendimento', $arrImage);

            $nmcliente = $cliente['Cliente']['NMCLIENTE'];

            $totalChamados = count($chamados);

            $this->set('totalChamados', $totalChamados);
            $this->set('NMSUPORTET', $this->request->data['NMSUPORTET']);
            $this->set('nmcliente', $nmcliente);
            $this->set('atendimento', $this->request->data['ATENDIMENTO']);
            $this->set('periodoini', $this->request->data['PERIODOINI']);
            $this->set('periodofim', $this->request->data['PERIODOFIM']);
            $this->set('cdcliente', $cliente['Cliente']['CDCLIENTE']);
            $this->set('chamados', $chamados);

        }

    }

    /**
     * index method
     *
     * @return void
     */
    public function chamado_c_result()
    {
        $this->loadModel('Pws.Chamado');
        $this->loadModel('Pws.Cliente');
        $auth_user_group = $this->Session->read('auth_user_group');
        $auth_user = $this->Session->read('auth_user');

        if ($this->matriz==4) {
            date_default_timezone_set('America/Bahia');
        } else {
            date_default_timezone_set('America/Sao_Paulo');
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            if ($this->request->data['PERIODOINI'] =='' || $this->request->data['PERIODOFIM'] =='' ){
                $this->Session->setFlash('ERRO: Periodo inicial e final precisa estar preenchido!!');
                $this->redirect(array(
                    'action' => 'chamado_periodo'
                ));
            }

            if ($auth_user_group['id']!=3) {

                if (empty($this->request->data['Cliente'])){
                    $this->request->data['Cliente'] = 0;
                }

                $cliente = $this->Cliente->find('first', array(
                    'conditions' => array(
                        'Cliente.id' => $this->request->data['Cliente'],
                        'Cliente.ID_BASE' => $this->matriz
                    )));

            } else {
                $cliente = $this->Cliente->find('first', array(
                    'conditions' => array(
                        'Cliente.CDCLIENTE' => $this->request->data['Cliente'],
                        'Cliente.ID_BASE' => $this->matriz
                    )));
            }

            $conditions = array();

            // Cliente
            if ($this->request->data['Cliente']!=0) {
                $conditions['Chamado.CDCLIENTE'] = $cliente['Cliente']['CDCLIENTE'];
            }

            // Serie
            if ($this->request->data['SERIE']!='') {
                $conditions['Equipamento.SERIE'] = $this->request->data['SERIE'];
            }

            // if ($auth_user_group['id']!=1) {
                $conditions['Chamado.ID_BASE'] = $this->matriz;
            // }
            // Status
            $conditions['Chamado.STATUS'] = 'O';

            // Periodo
            if ($this->request->data['PERIODOINI'] !='' || $this->request->data['PERIODOFIM'] !='') {
                $periodoIni = date('Y-m-d',strtotime($this->request->data['PERIODOINI']));
                $periodoFim =  date('Y-m-d',strtotime($this->request->data['PERIODOFIM']));

                $conditions['OR'] = array(
                    array('Chamado.DTINCLUSAO >= ' => $periodoIni, 'Chamado.DTINCLUSAO <= ' => $periodoFim),
                    array('Chamado.DTATENDIMENTO >= ' => $periodoIni, 'Chamado.DTATENDIMENTO <= ' => $periodoFim),
                );
            }

            // adiciona a condição para técnicos terceirizados
            $conditions = $this->conditionForTecnicoTerceirizado($conditions);

            //  adiciona a restrição caso não seja selecionado um cliente (perfil admin visualiza todos os clientes)
            if(($this->request->data['Cliente'] == '' or $this->request->data['Cliente'] == -1) && $auth_user_group['id'] != 1){

                if(count($this->cdCliente) > 0){
                    // adiciona quais clientes que são permitidos
                    $conditions['Chamado.CDCLIENTE'] = $this->cdCliente;
                }

            }

            // adicona condição para quando for selecionado um tecnico específico no relatório (Admin revenda e Administrador)
            if(isset($this->request->data['NMSUPORTET']) && ($auth_user_group['id'] == 1 || $auth_user_group['id'] == 6)){

                if($this->request->data['NMSUPORTET'] != ''){
                    $conditions['Chamado.NMSUPORTET'] = $this->request->data['NMSUPORTET'];
                }

            }

            $chamados = $this->Chamado->find('all',array(
                'conditions' => $conditions,
                'order'=> array('Chamado.DTINCLUSAO'=>'ASC')
            ));

            // calcula os valores de atendimento para técnicos terceirizados e admin revenda
            // if($auth_user['User']['tecnico_terceirizado'] == true || $auth_user_group['id'] == 6 || $auth_user_group['id'] == 1){

                $model = new Relatorio();

                // consulta os atendimento dos chamados
                $this->set('arrAtendimento', $model->getAtendimentos($chamados));

            // }

            $this->set('totalChamados', count($chamados));
            $this->set('nmcliente', $cliente['Cliente']['NMCLIENTE']);
            $this->set('periodoini', $this->request->data['PERIODOINI']);
            $this->set('periodofim', $this->request->data['PERIODOFIM']);
            $this->set('cdcliente', $cliente['Cliente']['CDCLIENTE']);
            $this->set('chamados', $chamados);

        }
    }

}
