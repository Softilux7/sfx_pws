<?php
/**
 * Created by PhpStorm.
 * User: Vinicius
 * Date: 10/01/2019
 * Time: 22:00
 */

App::uses('PwsAppController', 'Pws.Controller');
App::uses('JsonResult', 'Pws.Model');

/**
 * Chamados Controller
 *
 * @property ConfiguracoesChamado $ConfiguracoesChamado
 *
 */
class ConfiguracoesChamadoController extends PwsAppController
{
    public $components = array(
        'EmpresaPermission',
    );

    /**
     * Solicita que não seja pedido autenticação para o método avaliação
     *
     * @autor Vinícius Kreusch
     * @since 13/03/2019
     */
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index()
    {
        $errors = array();

        // -- Load usuario
        $auth_user = $this->Session->read('auth_user');

        $this->request->data['ConfiguracoesChamado']['update_at'] = date('Y-m-d H:i');
        $this->request->data['ConfiguracoesChamado']['usuario_alteracao_id'] = $auth_user['User']['id'];
        $this->request->data['ConfiguracoesChamado']['ID_BASE'] = $this->matriz;

        $_configuracao = $this->ConfiguracoesChamado->find('first', array(
            'conditions' => array(
                'ConfiguracoesChamado.ID_BASE' => $this->matriz,
            ),
            'order' => array(
                'ConfiguracoesChamado.id' => 'DESC'
            )
        ));

        if (!empty($_configuracao)) {
            $this->ConfiguracoesChamado->id = $_configuracao['ConfiguracoesChamado']['id'];
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            
            if($this->request->data['ConfiguracoesChamado']['reset'] == 0){
                // salva um determinado status
                if ($this->ConfiguracoesChamado->save($this->request->data, false)) {
                    $this->Session->setFlash("Configuração do chamado atualizada com sucesso");
                } else {
                    $errors[] = ['Falha ao atualizar configuração!'];
                }
            }else{
                // volta para a configuração padrão
                if ($this->ConfiguracoesChamado->delete($_configuracao['ConfiguracoesChamado']->id)) {
                    $this->Session->setFlash("Configuração do chamado atualizada com sucesso");

                    $this->redirect(array('plugin' => 'pws', 'controller' => 'ConfiguracoesChamado', 'action' => 'index'));
                } else {
                    $errors[] = ['Falha ao voltar configuração padrão!'];
                }

            }
        } else {
            if(!empty($_configuracao)) {
                $this->request->data = am($this->request->data, $this->ConfiguracoesChamado->read(null, $_configuracao['ConfiguracoesChamado']['id']));
            }
        }

        // Carrega status disponiveis
        self::getStatus();
        // Preenche os cds status possiveis de chamados
        self::optionsStatusPadraoAberturaChamado();
        // Carrega current empresa
        self::loadEmpresa();

        $this->set('errors', $errors);
    }

    /**
     *
     *  Carrega opções disponiveis para padrão abertura do chamado
     *  E(Despachado), P(Pendente), M(m Manutenção)
     *
     * @return null
     */
    private function optionsStatusPadraoAberturaChamado()
    {
        $options = array(
            'E' => 'Despachado',
            'P' => 'Pendente',
            'M' => 'Em Manutenção',
        );

        $this->set('status_chamado', $options);
    }

    /**
     *
     *  Carrega os status da matriz
     *
     * @return null
     */
    private function getStatus()
    {
        $this->loadModel('Pws.Status');
        $this->set('_cd_status', $this->Status->find('list', array(
            'fields' => array(
                'Status.CDSTATUS',
                'Status.NMSTATUS'
            ),
            'conditions' => array(
                'Status.empresa_id' => $this->matriz
            )
        )));
        $this->set(compact("_cd_status"));
    }


    /**
     *
     *  Carrega empresa para apresentar o nome em tela
     *
     * @return null
     */
    private function loadEmpresa()
    {
        $this->loadModel('Empresa');

        $this->set('_empresa', $this->Empresa->find('first', array(
            'conditions' => array(
                'Empresa.id' => $this->matriz
            )
        )));
    }
}