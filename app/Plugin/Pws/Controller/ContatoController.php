<?php

App::uses('PwsAppController', 'Pws.Controller');

class ContatoController extends PwsAppController {

    public $uses = null;

    public function index() {

        $this->loadModel('Pws.Cliente');
        $this->loadModel('Pws.User');
        $auth_user = $this->Session->read('auth_user');
        $errors = array();
        $tpemails = $this->User->query("SELECT c.user_name, c.user_email FROM tpemails a
                                        INNER JOIN users_tpemails b on (b.tpemail_id = a.id)
                                        INNER JOIN users c on (c.id= b.user_id)
                                        where a.id = 4 and c.empresa_id={$this->matriz}");
        $cliente = $this->Cliente->find('first', array(
            'conditions' => array(
                'Cliente.CDCLIENTE' => $auth_user ['User'] ['cliente_id'],
                'Cliente.ID_BASE' => $this->matriz)));
        $this->set('cliente', $cliente);

        if ($this->request->is('post')) {

            // print_r($this->request->data);

            if ($this->request->data['Contato']['contato'] == '') {
                $errors[] = 'ERRO! Campo Contato não preenchido!';
                //$errors[] = $this->Session->setFlash('erro contato não preenchido2!');
            }
            $this->set('errors', $errors);

            if (count($errors) == 0) {


                $enviado = 0;
                //forech usuários
                if (count($tpemails) > 0) {
                    foreach ($tpemails as $tpemail) {
                        if (self::enviaEmail($tpemail['c']['user_email'], 'Contato / Duvida ou Reclamação', $this->request->data)) {
                            $enviado++;
                        }
                    }
                    // envio de email copia do cliente
                    if ($enviado > 0) {
                        self::enviaEmail($this->request->data['Contato']['email'], 'Contato / Duvida ou Reclamação', $this->request->data);
                        $this->Session->setFlash('Email Enviado com Sucesso!');
                    } else {
                        $errors[] = 'Erro ao enviar email';
                    }
                } else {
                    $errors[] = $this->Session->setFlash('Solicitação realizada com sucesso!');
                    $errors[] = $this->Session->setFlash('Não foi possivel enviar email');
                }
            }
        }
        $this->set('errors', $errors);
        //$this->set('atendimentos', $atendimento);
    }

    /**
     * Enviar email
     */
    private function enviaEmail($to = null, $subject = null, $dados, $edit = null) {

        App::uses('CakeEmail', 'Network/Email');
        App::uses('Setting', 'AuthAcl.Model');

        $Setting = new Setting ();
        $auth_user = $this->Session->read('auth_user');
        $general = $Setting->find('first', array(
            'conditions' => array(
                'setting_key' => sha1('general')
            )
        ));
        if (!empty($general)) {
            $general = unserialize($general ['Setting'] ['setting_value']);
        }

        $email = new CakeEmail ();

        $email->addTo($to);
        $email->config('default');
        $email->emailFormat('html');
        if ($edit == 1) {
            $email->template('contato', 'contato');
        } else {
            $email->template('contato', 'contato');
        }

        $email->from(array(
            $general ['Setting'] ['email_address'] => 'PWS - Portal ' . $auth_user['EmpresaSelected']['Empresa']['empresa_nome']
        ));
        $email->subject($subject);

        if ($edit == 1) {
            $email->viewVars(array('contato' => $dados, 'auth_user' => $auth_user));
        } else {
            $email->viewVars(array('contato' => $dados, 'auth_user' => $auth_user));
        }
        return $email->send();
    }

}
