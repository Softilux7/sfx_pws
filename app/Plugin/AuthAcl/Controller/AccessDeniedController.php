<?php
App::uses('AuthAclAppController', 'AuthAcl.Controller');
class AccessDeniedController extends AuthAclAppController {
	var $layout = 'admin';

	public function beforeFilter()
    {
		parent::beforeFilter();
		$this->Auth->allow('index');
	}

	public function index()
    {
        App::uses('User', 'AuthAcl.Model');
        $this->loadModel('AuthAcl.Group');
        $this->loadModel('AuthAcl.Empresa');
        $this->loadModel('Pws.Versao');
        $this->loadModel('Pws.Cliente');

	    $userModel = new User();
        $user = $this->Auth->user();

        if (!empty($user)) {
            $user = $userModel->find('first', array('conditions' => array('User.id' => $user['id'])));

            // seta a classe que será chamado pelo javascript
            $this->set('className', strtolower($this->modelClass));

            $authFlag = false;

            $versao = $this->Versao->find('first', array(
                'order' => array(
                    'Versao.id' => 'DESC'
                )
            ));

            $this->set('versao', $versao);

            $group = new Group();
            $empresa = new Empresa(); // Empresa que o usu�rio pertence

            $action = 'controllers';
            if (!empty ($this->plugin)) {
                $action .= '/' . $this->plugin;
            }
            $action .= '/' . $this->name;
            $action .= '/' . $this->action;

            if (!empty ($user ['Group'])) {
                foreach ($user ['Group'] as $group) {
                    $authFlag = $this->Acl->check(array(
                        'Group' => array(
                            'id' => $group ['id']
                        )
                    ), $action);
                    if ($authFlag == true) {
                        break;
                    }
                }
            }

            if (!empty ($user)) {

                if ($user['User']['filial_id'] != 0) {
                    $rsEmpresa ['EmpresaSelected'] = $empresa->find('first', array(
                        'conditions' => array(
                            'Empresa.id = ' => $user ['User'] ['filial_id']
                        )
                    ));
                } else {
                    $rsEmpresa ['EmpresaSelected'] = $empresa->find('first', array(
                        'conditions' => array(
                            'Empresa.id = ' => $user ['User'] ['empresa_id']
                        )
                    ));
                }

                if (!empty ($rsEmpresa ['EmpresaSelected'])) {
                    $user = array_merge($user, $rsEmpresa);
                }
                define('FUSO_HORARIO', $rsEmpresa ['EmpresaSelected']['Empresa']['fuso_horario']);
                date_default_timezone_set(@FUSO_HORARIO);
                // Multi cliente - Acessar

                $this->Session->write('auth_user', $user);
                $this->Session->write('salvo', 0);

                // lista todas as empresas

                if ($user['User']['filial_id'] == 0) {
                    foreach ($user['Empresa'] as $empresaS) {
                        $empresasS[] = $empresaS['id'];
                    }
                } else {
                    $empresasS = $user['User']['filial_id'];
                }

                $this->empresaId($empresasS);

                // Lista todos os clientes
                switch ($group['id']) {
                    case 3:
                        if ($user['User']['cliente_id'] == -1) {

                            foreach ($user['Cliente'] as $clienteS) {
                                $clientesS[] = $clienteS['CDCLIENTE'];
                            }
                        } else {
                            $clientesS = $user['User']['cliente_id'];
                        }
                        $this->clienteId($clientesS);
                }

                $this->matrizId($user['User']['empresa_id']);
                $this->set('auth_user', $user);

                $this->Session->write('auth_user_group', $group);
                $this->set('auth_user_group', $group);
                $this->request->data ['auth_plugin'] = $this->plugin;
                $this->request->data ['auth_controller'] = $this->name;
                $this->request->data ['auth_action'] = $this->action;

                $clienteSelected = $this->Cliente->find('first', array(
                    'conditions' => array(
                        'Cliente.CDCLIENTE = ' => $user['User']['cliente_id'],
                        'Cliente.empresa_id = ' => $user['User']['filial_id'],
                        'Cliente.ID_BASE = ' => $user['User']['empresa_id']
                    ),
                ));

                $this->set('clienteSelected', $clienteSelected);
            }
        }


		$this->set('login_user',$this->Auth->user());
	}
}