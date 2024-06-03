<?php
App::uses('AuthAclAppController', 'AuthAcl.Controller');

/**
 * Users Controller
 */
class NotificationsController extends AuthAclAppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();
    }

    public function add(){

        $auth_user = $this->Session->read('auth_user');
        $auth_user_group = $this->Session->read('auth_user_group');

        switch($auth_user_group['id']){
            case 1 :
            case 6 :
                break;
            default :
                $this->redirect(array(
                    'controller' => 'auth_acl',
                    'action' => 'index',
                ));
        }

        // 1 - consulta os técnicos que já possuem o fcm_token_device
        // 2 - valida os dados
        // 3 - Verifica o tipo de envio, mensagem única ou grupo
        // 4 - envia a mensagem - API 

        $tecnicos = $this->Notification->getTecnicosFCM();
        $arrTecnicos = array();
        
        foreach($tecnicos as $key => $data){
            $arrTecnicos[$data['users']['fcm_token_device']] = $data['users']['user_name'] . " ->> (" . $data['users']['user_email'] . ")";
        }
        
        $this->set('arrTecnicos', $arrTecnicos);

    }

}