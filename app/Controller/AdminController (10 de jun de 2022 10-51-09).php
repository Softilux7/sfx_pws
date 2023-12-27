<?php

class AdminController extends AppController
{

    var $empresa = '';
    var $matriz = '';
    var $cliente = '';
    var $cdCliente = '';
    var $conect = '';
    var $className = '';

    public $components = array(
        'Acl',
        'Auth' => array(
            'authorize' => 'Controller',
            'authenticate' => array(
                'Form' => array(
                    'fields' => array(
                        'username' => 'user_email',
                        'password' => 'user_password'
                    ),
                    'scope' => array(
                        '`User`.`user_status`' => 1
                    )
                )
            )
        ),
        'Session',
        'Cookie',
        'EmpresaPermission',
        'FilterResults.Filter' => array(
            'auto' => array(
                'paginate' => false,
                'explode' => true  // recommended
            ),
            'explode' => array(
                'character' => ' ',
                'concatenate' => 'AND'
            )
        )
    );
    var $layout = 'admin';
    public $helpers = array(
        'Html',
        'Form',
        'Session',
        'AuthAcl.Acl',
        'FilterResults.Search' => array(
            'operators' => array(
                'LIKE' => 'Contem',
                'NOT LIKE' => 'Não Contem',
                'LIKE BEGIN' => 'Iniciando com',
                'LIKE END' => 'Termina com',
                '=' => 'Igual a',
                '!=' => 'Diferente',
                '>' => 'Maior que',
                '>=' => 'Maior ou igual a',
                '<' => 'Menor que',
                '<=' => 'Menor ou igual a'
            )
        )
    );


    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->loginAction = array(
            'controller' => 'users',
            'action' => 'login',
            'plugin' => 'auth_acl'
        );
        $this->Auth->loginRedirect = array(
            'controller' => 'auth_acl',
            'action' => 'index',
            'plugin' => 'auth_acl'
        );
        $this->Auth->logoutRedirect = array(
            'controller' => 'users',
            'action' => 'login',
            'plugin' => 'auth_acl'
        );

        $user = $this->Auth->user();

        $this->set('user', $user);

        if (empty($user)) {
            $user = $this->Cookie->read('AutoLoginUser');
            if (!empty($user)) {
                $this->Auth->login($user);
            }
        }

        $this->Acl->Aco->recursive = 0;
        $acoTree = $this->Acl->Aco->find('threaded');

        $acoPlugin = array();
        $acoController = array();
        $plugins = CakePlugin::loaded();

        if (!empty($acoTree) && !empty($acoTree[0]['children'])) {
            foreach ($acoTree[0]['children'] as $obj) {
                if (in_array($obj['Aco']['alias'], $plugins)) {
                    $acoPlugin[$obj['Aco']['alias']]['Aco'] = $obj['Aco'];
                    $acoPlugin[$obj['Aco']['alias']]['children'] = array();
                    if (!empty($obj['children'])) {
                        foreach ($obj['children'] as $k => $controller) {
                            $acoPlugin[$obj['Aco']['alias']]['children'][$k]['Aco'] = $controller['Aco'];
                            $acoPlugin[$obj['Aco']['alias']]['children'][$k]['children'] = $controller['children'];
                        }
                    }
                } else {
                    $acoController[$obj['Aco']['alias']] = $obj;
                }
            }
        }

        $acos = array();

        foreach ($acoController as $controller) {
            foreach ($controller['children'] as $action) {
                if ($action['Aco']['alias'] == 'isAuthorized')
                    continue;
                $strAction = 'controllers/' . $controller['Aco']['alias'] . '/' . $action['Aco']['alias'];
                $acos[$strAction] = $action['Aco']['id'];
            }
        }

        foreach ($acoPlugin as $plugin) {
            foreach ($plugin['children'] as $controller) {
                if ($controller['Aco']['alias'] == 'AccessDenied')
                    continue;
                foreach ($controller['children'] as $action) {
                    if ($action['Aco']['alias'] == 'isAuthorized')
                        continue;
                    if ($action['Aco']['alias'] == 'login')
                        continue;
                    if ($action['Aco']['alias'] == 'logout')
                        continue;
                    if ($action['Aco']['alias'] == 'signup')
                        continue;
                    if ($action['Aco']['alias'] == 'activate')
                        continue;
                    if ($action['Aco']['alias'] == 'editAccount')
                        continue;
                    if ($action['Aco']['alias'] == 'resetPassword')
                        continue;
                    $strAction = 'controllers/' . $plugin['Aco']['alias'] . '/' . $controller['Aco']['alias'] . '/' . $action['Aco']['alias'];
                    $acos[$strAction] = $action['Aco']['id'];
                }
            }
        }

        $privilege = array();

        $privilege['Privilege']['acos'] = $acos;

        $this->Acl->Aro->recursive = 1;
        $groupAro = $this->Acl->Aro->find('all', array(
            'conditions' => array(
                'model' => 'Group'
            )
        ));

        $permissions = array();
        foreach ($groupAro as $aro) {
            if (!empty($aro['Aco'])) {
                foreach ($aro['Aco'] as $aco) {
                    if ($aco['Permission']['_create'] == 1 && $aco['Permission']['_read'] == 1 && $aco['Permission']['_update'] == 1 && $aco['Permission']['_delete'] == 1) {
                        $permissions[$aro['Aro']['foreign_key']][$aco['id']] = 1;
                    }
                }
            }
        }
        $privilege['Privilege']['permissions']['group'] = $permissions;

        $userAro = Cache::read('user_aros', 'cake_acl_aros_model_user');
        if (!$userAro) {
            $this->Acl->Aro->recursive = 1;
            $userAro = $this->Acl->Aro->find('all', array(
                'conditions' => array(
                    'model' => 'User'
                )
            ));
            Cache::write('user_aros', $userAro, 'cake_acl_aros_model_user');
        }

        $permissions = array();
        foreach ($userAro as $aro) {
            if (!empty($aro['Aco'])) {
                foreach ($aro['Aco'] as $aco) {
                    if ($aco['Permission']['_create'] == 1 && $aco['Permission']['_read'] == 1 && $aco['Permission']['_update'] == 1 && $aco['Permission']['_delete'] == 1) {
                        $permissions[$aro['Aro']['foreign_key']][$aco['id']] = 1;
                    }
                }
            }
        }

        $privilege['Privilege']['permissions']['user'] = $permissions;
        ClassRegistry::addObject('Privilege', $privilege);
    }

    public function isAuthorized($user = null)
    {
        App::uses('User', 'AuthAcl.Model');
        App::uses('Group', 'AuthAcl.Model');
        App::uses('Empresa', 'AuthAcl.Model');
        App::uses('Tecnico', 'AuthAcl.Model');
        $this->loadModel('Pws.Versao');
        $this->loadModel('Pws.Cliente');

        // seta a classe que será chamado pelo javascript
        $this->set('className', strtolower($this->modelClass));

        $authFlag = false;
        $this->set('login_user', $user);

        $versao = $this->Versao->find('first', array(
            'order' => array(
                'Versao.id' => 'DESC'
            )
        ));

        $this->set('versao', $versao);

        $userModel = new User();
        $group = new Group();
        $empresa = new Empresa(); // Empresa que o usu�rio pertence

        $rs = $userModel->find('first', array(
            'conditions' => array(
                'User.id' => $user['id']
            )
        ));

        $action = 'controllers';
        if (!empty($this->plugin)) {
            $action .= '/' . $this->plugin;
        }
        $action .= '/' . $this->name;
        $action .= '/' . $this->action;

        if (!empty($rs['Group'])) {
            foreach ($rs['Group'] as $group) {
                $authFlag = $this->Acl->check(array(
                    'Group' => array(
                        'id' => $group['id']
                    )
                ), $action);
                if ($authFlag == true) {
                    break;
                }
            }
        }

        if ($authFlag == false && !empty($user)) {
            $authFlag = $this->Acl->check(array(
                'User' => array(
                    'id' => $user['id']
                )
            ), $action);
        }

        if ($authFlag == false && !empty($user)) {
            $this->redirect(array(
                'plugin' => 'auth_acl',
                'controller' => 'AccessDenied',
                'action' => 'index',
            ));
        }

        if (!empty($user)) {
            $user = $userModel->find('first', array(
                'conditions' => array(
                    'User.id' => $user['id']
                )
            ));

            $user['User']['tecnico_terceirizado'] = false;

            // verifica feita para validar se o técnico é ou não terceirizado
            if(count($user['Group']) >= 1){
                // verifica se é do tipo técnico
                if($user['Group'][0]['id'] == 2){
                    
                    $tecnico = new Tecnico();

                    $tecnicoId = $user['User']['tecnico_id'];
                    $empresaId = $user['User']['empresa_id'];

                    // consulta o CDFORNECEDOR para indentificar se é técnico terceirizado ou não
                    $query = $tecnico->query("SELECT * FROM tecnicos WHERE NMSUPORTE = '{$tecnicoId}' AND empresa_id = {$empresaId}");

                    // para CDFORNECEDOR maior que zero é defindo Técnico terceirizado
                    $user['User']['tecnico_terceirizado'] = (count($query) > 0 && $query[0]['tecnicos']['CDFORNECEDOR'] > 0) ? true : false;

                }
            }

            if ($user['User']['filial_id'] != 0) {
                $rsEmpresa['EmpresaSelected'] = $empresa->find('first', array(
                    'conditions' => array(
                        'Empresa.id = ' => $user['User']['filial_id']
                    )
                ));
            } else {
                $rsEmpresa['EmpresaSelected'] = $empresa->find('first', array(
                    'conditions' => array(
                        'Empresa.id = ' => $user['User']['empresa_id']
                    )
                ));
            }

            if (!empty($rsEmpresa['EmpresaSelected'])) {
                $user = array_merge($user, $rsEmpresa);
            }
            
            define('FUSO_HORARIO', $rsEmpresa['EmpresaSelected']['Empresa']['fuso_horario']);
            
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
            //$clienteS ='';
            switch ($group['id']) {
                case 9:
                case 3:
                case 12:
                    if ($user['User']['cliente_id'] == -1) {
                        
                        foreach ($user['Cliente'] as $clienteS) {
                            $clientesS[] = $clienteS['CDCLIENTE'];
                        }
                    } else {
                        
                        $clientesS = $user['User']['cliente_id'];
                    }
                    $this->clienteId($clientesS);
            }

            // define o CDCLIENTE dos clientes
            $arrCdCliente = array();

            // verifica se está selecionado todos os clientes
            if($user['User']['cliente_id'] == -1 || $user['User']['cliente_id'] == ''){
                foreach ($user['Cliente'] as $clienteS) {
                    $arrCdCliente[] = $clienteS['CDCLIENTE'];
                }
            }else{
                // define o
                $arrCdCliente[] = $user['User']['cliente_id'];
            }

            $this->cdCliente($arrCdCliente);

            $this->matrizId($user['User']['empresa_id']);
            $this->set('auth_user', $user);

            $this->Session->write('auth_user_group', $group);
            $this->set('auth_user_group', $group);
            $this->request->data['auth_plugin'] = $this->plugin;
            $this->request->data['auth_controller'] = $this->name;
            $this->request->data['auth_action'] = $this->action;

            $clienteSelected = $this->Cliente->find('first', array(
                'conditions' => array(
                    'Cliente.CDCLIENTE = ' => $user['User']['cliente_id'],
                    'Cliente.empresa_id = ' => $user['User']['filial_id'],
                    'Cliente.ID_BASE = ' => $user['User']['empresa_id']
                ),
            ));

            $this->set('clienteSelected', $clienteSelected);

            // verifica alguma pendência com os clientes
            $tfcredbloq = false;

            // verifica se possui algum cliente bloqueado
            if($group['id'] == 3){
                foreach($user['Cliente'] as $data){
                    if($tfcredbloq == false){
                        $tfcredbloq = strtoupper($data['TFCREDBLOQ']) == 'S' ? true : false;
                    }
                }
            }

            $this->set('TFCREDBLOQ', $tfcredbloq);

            // se veio do login e estiver bloqueado redireciona para a página de bloqueio
            // caso esteja bloqueado não remove o is_login
            if($this->Session->read('is_login') && $tfcredbloq == true){
                $this->redirect("/auth_acl/users/loginBloqueado");
            }

            $this->Session->write('is_login', false);
        
            
        }

        return $authFlag;
    }

    /**
     * @param $empresa_id
     * @return string
     */

    public function empresaId($empresa_id)
    {
        $this->empresa = $empresa_id;
        return $this->empresa;
    }

    /**
     * @param $cliente_id
     * @return string
     */

    public function clienteId($cliente_id)
    {
        $this->cliente = $cliente_id;
        return $this->cliente;
    }

    /**
     * @param $cdCliente
     * @return string
     */

    public function cdCliente($cdCliente)
    {
        $this->cdCliente = $cdCliente;
        return $this->cdCliente;
    }


    /**
     * @param $matriz_id
     * @return string
     */

    public function matrizId($matriz_id)
    {
        $this->matriz = $matriz_id;
        return $this->matriz;
    }
}
