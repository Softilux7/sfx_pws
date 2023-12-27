<?php
App::uses('PwsAppController', 'Pws.Controller');

class OportunidadesController extends PwsAppController
{
    public $uses = null;

    public function add($id = null)
    {

        $this->loadModel('Pws.Oportunidade');
        $this->loadModel('Pws.Chamado');
        $this->loadModel('Pws.User');
        $auth_user = $this->Session->read('auth_user');
        $errors = array();

        $tpemails = $this->User->query("SELECT c.user_name, c.user_email FROM tpemails a
                                        INNER JOIN users_tpemails b on (b.tpemail_id = a.id)
                                        INNER JOIN users c on (c.id= b.user_id)
                                        where a.id = 5 and c.empresa_id={$this->matriz}");

        $chamado = $this->Chamado->find('first', array(
            'conditions' => array(
                'Chamado.id' => $id,
                'Chamado.ID_BASE'=>$this->matriz)));

        $this->set('chamado', $chamado);

        $this->request->data('Oportunidade.ATUALIZADO', 1);
        if ($auth_user['User']['filial_id'] == 0) {

            $this->request->data('Oportunidade.empresa_id', $auth_user['User']['empresa_id']);
        } else {

            $this->request->data('Oportunidade.empresa_id', $auth_user['User']['filial_id']);
        }


        $this->request->data('Oportunidade.ID_BASE', $this->matriz);

        $this->request->data('Oportunidade.DTINDICACAO', date('Y-m-d'));

        if ($this->request->is('post')) {

            if ($this->request->data['Oportunidade']['CONTATO'] == '') {
                $errors[] = 'ERRO! Campo Contato não preenchido!';
            }
            if ($this->request->data['Oportunidade']['DSOPORTUNIDADE'] == '') {
                $errors[] = 'ERRO! Campo Descrição da Oportunidade não preenchido!';
            }
            if ($this->request->data['Oportunidade']['TELEFONE'] == '') {
                $errors[] = 'ERRO! Campo Fone não preenchido!';
            }



            if (count($errors) == 0) {
                $this->Oportunidade->create();
                $this->Oportunidade->save($this->request->data);

                $enviado = 0;
                //forech usuários
                if (count($tpemails) > 0) {
                    foreach ($tpemails as $tpemail) {
                        if (self::enviaEmail($tpemail['c']['user_email'], 'Oportunidade Comercial Identificada', $this->request->data)) {
                            $enviado++;
                        }
                    }
                    // envio de email copia do cliente
                    if ($enviado > 0) {
                        self::enviaEmail($auth_user['User']['user_email'], 'Oportunidade Comercial Identificada', $this->request->data);
                        //$this->Session->setFlash('Email Enviado com Sucesso!');
                        $this->Session->setFlash('Oportunidade foi incluida com sucesso!');
                    } else {
                        $errors[] = 'Erro ao enviar email';
                    }
                } else {
                    $errors[] = $this->Session->setFlash('Oportunidade foi incluida com sucesso!');
                    $errors[] = $this->Session->setFlash('Não foi possivel enviar o email com a oportunidade');
                }

                $this->redirect(array(
                    'controller' => 'Chamados',
                    'action' => 'index',
                ));

            }
        }

        $this->set('errors', $errors);

    }

    /**
     * Enviar email
     */

    private function enviaEmail($to = null, $subject = null, $dados, $edit = null)
    {

        App::uses('CakeEmail', 'Network/Email');
        App::uses('Setting', 'AuthAcl.Model');

        $Setting = new Setting ();
        $auth_user = $this->Session->read('auth_user');
        $general = $Setting->find('first', array(
            'conditions' => array(
                'setting_key' => sha1('general')
            )
        ));
        if (!empty ($general)) {
            $general = unserialize($general ['Setting'] ['setting_value']);
        }

        $email = new CakeEmail ();

        $email->addTo($to);
        $email->config('default');
        $email->emailFormat('html');
        if ($edit == 1) {
            $email->template('oportunidade', 'oportunidade');
        } else {
            $email->template('oportunidade', 'oportunidade');
        }

        $email->from(array(
            $general ['Setting'] ['email_address'] => 'PWS - Portal '.$auth_user['EmpresaSelected']['Empresa']['empresa_nome']
        ));
        $email->subject($subject);

        if ($edit == 1) {
            $email->viewVars(array('oportunidade' => $dados, 'auth_user' => $auth_user));
        } else {
            $email->viewVars(array('oportunidade' => $dados, 'auth_user' => $auth_user));
        }
        return $email->send();

    }


}


