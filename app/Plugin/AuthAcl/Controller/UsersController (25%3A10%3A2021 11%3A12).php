<?php
App::uses('AuthAclAppController', 'AuthAcl.Controller');

/**
 * Users Controller
 */
class UsersController extends AuthAclAppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('logout');
        $this->Auth->allow('signup');
        $this->Auth->allow('activate');
        $this->Auth->allow('resetPassword');
        $this->Auth->allow('app');
        $this->Auth->allow('signupcomplete');
        $this->Auth->allow('activecomplete');
        $this->Auth->allow('loginApp');
    }

    public function index()
    {
        $auth_user = $this->Session->read('auth_user');

        if ($this->request->isAjax()) {
            $this->layout = null;
        }
        $this->User->recursive = 1;
        $this->Filter->addFilters('filter1');

        $paginate = array();
        $paginate['limit'] = 15;
        $this->paginate = $paginate;

        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        if ($auth_user['User']['empresa_id'] == 1) { // se for usuario administrador da flix = 1
            $this->set('users', $this->paginate());
        } else {
            $this->set('users', $this->paginate(array(
                'User.empresa_id = ' => $this->matriz
            )));
        }
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {
        $auth_user = $this->Session->read('auth_user');
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }

        $user = $this->set('user', $this->User->read(null, $id));

        if ($auth_user['User']['empresa_id'] == 1) { // se for usuario administrador da flix = 1
            $this->set('user', $user);
        } else {
            $user = $this->User->read(null, $id);
            if ($user['User']['empresa_id'] == $this->matriz) {
                $this->set('user', $user);
            } else {
                throw new NotFoundException(__('Usuário nao encontrado'));
            }
        }
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $this->loadModel('Empresa');
        $this->loadModel('Tecnico');
        $this->loadModel('Pws.Cliente');
        $this->loadModel('Pws.Entregadore');
        $auth_user_group = $this->Session->read('auth_user_group');

        $this->set('tpemail', $this->User->Tpemail->find('list', array('fields' => array('Tpemail.id', 'Tpemail.tipo'), 'order' => array('Tpemail.tipo' => 'ASC'))));
        //$this->Entregadore->setDataSource($this->conect);
        $this->set('entregadores', $this->Entregadore->find('list', array(
            'fields' => array('Entregadore.ID_ENTREGADOR', 'Entregadore.NM_ENTREGADOR'),
            'conditions' => array(
                'empresa_id' => $this->matriz
            ),
            'order' => array('Entregadore.NM_ENTREGADOR' => 'ASC')
        )));

        $errors = array();
        if ($this->request->is('post')) {
            $this->User->create();
            if (isset($this->request->data['User']['id'])) {
                unset($this->request->data['User']['id']);
            }

            $this->request->data['User']['filial_id'] = $this->request->data['Empresa']['Empresa'][0];

            $cliente = $this->Cliente->read(null, $this->request->data['Cliente']['Cliente'][0]);
            $this->request->data['User']['cliente_id'] = $cliente['Cliente']['CDCLIENTE'];

            if ($this->User->save($this->request->data)) {
                $this->Cookie->delete('srcPassArg');
                $strAction = "controllers/AuthAcl/users/editAccount";
                $this->Acl->allow($this->User, $strAction);

                $strAction = "controllers/AuthAcl/AuthAcl/index";
                $this->Acl->allow($this->User, $strAction);

                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $errors = $this->User->validationErrors;
            }
        }
        $this->set('errors', $errors);

        // $this->Tecnico->setDataSource($this->conect);
        $this->set('tecnicos', $this->Tecnico->find('list', array(
            'fields' => array(
                'Tecnico.NMSUPORTE',
                'Tecnico.NMSUPORTE'
            ),
            'conditions' => array(
                'Tecnico.TIPO = ' => 'S',
                'Tecnico.empresa_id' => $this->matriz,
                'Tecnico.TFATIVO = ' => 'S',
            )
        )));
        $this->set(compact("tecnicos"));

        if ($auth_user_group['id'] == 6) {
            $groups = $this->User->Group->find('list', array('conditions' => array('id !=' => 1)));
        } else {
            $groups = $this->User->Group->find('list');
        }

        $this->set(compact('groups'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {
        if ($this->request->isAjax()) {
            $this->autoRender = false;
            $this->layout = null;
        }
        $this->loadModel('Empresa');
        $this->loadModel('Tecnico');
        $this->loadModel('Pws.Entregadore');
        $auth_user_group = $this->Session->read('auth_user_group');
        $auth_user = $this->Session->read('auth_user');
        $this->User->id = $id;

        if ($this->request->is('get')) {
            $this->Session->write('update_user_id', $id);
            unset($this->User->validate['user_confirm_password']['checkPassword']);
        }
        $this->set('tpemail', $this->User->Tpemail->find('list', array('fields' => array('Tpemail.id', 'Tpemail.tipo'), 'order' => array('Tpemail.tipo' => 'ASC'))));
        $this->set('entregadores', $this->Entregadore->find('list', array(
            'fields' => array('Entregadore.ID_ENTREGADOR', 'Entregadore.NM_ENTREGADOR'),
            'conditions' => array(
                'empresa_id' => $this->matriz
            ),
            'order' => array('Entregadore.NM_ENTREGADOR' => 'ASC')
        )));

        $errors = array();
        unset($this->User->validate['user_password']['required']);
        unset($this->User->validate['user_confirm_password']['required']);

        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Session->read('update_user_id') != $id) {
                throw new NotFoundException(__("Don't hack me"));
            }

            if (empty($this->request->data['User']['user_password'])) {
                unset($this->request->data['User']['user_password']);
                unset($this->User->validate['user_confirm_password']['checkPassword']);
            }

            $user_email = $this->request->data['User']['user_email'];

            unset($this->request->data['User']['user_email']);
            unset($this->User->validate['user_email']);

            if ($auth_user['User']['id'] == $id) {
                unset($this->request->data['User']['user_status']);
            }

            if (isset($this->request->data['User']['id'])) {
                unset($this->request->data['User']['id']);
            }

            //Se cliente nao vem informado no ajax, então desvincula do usuario
            if (!isset($this->request->data['Cliente']))
                $this->request->data['Cliente'] = array();

            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash("Usuário atualizado com sucesso");
            } else {
                $this->request->data['User']['user_email'] = $user_email;
                $errors = $this->User->validationErrors;
            }
        } else {
            $this->request->data = am($this->request->data, $this->User->read(null, $id));
            unset($this->request->data['User']['user_password']);
        }

        $var = array();
        if (count($errors) > 0) {
            $strError = '';
            foreach ($errors as $error) {
                if (is_array($error)) {
                    $strError .= "<div>" . implode(" <br />", $error) . " </div>";
                } else {
                    $strError .= "<div>" . $error . "</div>";
                }
            }
            $var['error'] = 1;
            $var['error_message'] = $strError;
        } else {
            $var['error'] = 0;
        }

        $this->set('tecnicos', $this->Tecnico->find('list', array(
            'fields' => array(
                'Tecnico.NMSUPORTE',
                'Tecnico.NMSUPORTE'
            ),
            'conditions' => array(
                'Tecnico.TIPO = ' => 'S',
                'Tecnico.empresa_id' => $this->matriz,
                'Tecnico.TFATIVO = ' => 'S',
            )
        )));

        $this->set(compact("tecnicos"));

        if ($auth_user_group['id'] == 6) {
            $groups = $this->User->Group->find('list', array('conditions' => array('id !=' => 1)));
        } else {
            $groups = $this->User->Group->find('list');
        }

        $this->set(compact('groups'));
        $this->set('errors', $errors);
        $this->set('auth_user', $auth_user);
        $this->set('id_user_update', $id);

        if ($this->request->isAjax()) {
            echo json_encode($var);
        }
    }

    /**
     * delete method
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        $this->autoRender = false;
        $authUser = $this->Auth->user();
        if ($this->request->is('post') && $this->request->isAjax() && $authUser['id'] != $id) {
            $this->User->id = $id;
            if ($this->User->exists()) {
                $this->User->query("DELETE u FROM users u WHERE u.id = $id");
                $this->User->query("DELETE FROM users_empresas WHERE user_id = $id");
                $this->User->query("DELETE FROM users_clientes WHERE user_id = $id");
                $this->User->query("DELETE FROM users_groups WHERE user_id = $id");
                $this->User->query("DELETE FROM users_tpemails WHERE user_id = $id");
            }
        }
    }

    public function editAccount()
    {
        if ($this->request->isAjax()) {
            $this->autoRender = false;
            $this->layout = null;
        }
        $id = $this->Auth->user('id');
        $this->User->id = $id;
        $errors = array();
        unset($this->User->validate['user_password']['required']);
        unset($this->User->validate['user_confirm_password']['required']);
        unset($this->request->data['Group']);
        unset($this->request->data['User']['user_status']);

        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if (empty($this->request->data['User']['user_password'])) {
                unset($this->request->data['User']['user_password']);
                unset($this->User->validate['user_confirm_password']['checkPassword']);
            }

            $user_email = $this->request->data['User']['user_email'];
            unset($this->request->data['User']['user_email']);
            unset($this->User->validate['user_email']);

            if (isset($this->request->data['User']['id'])) {
                unset($this->request->data['User']['id']);
            }

            if ($this->User->save($this->request->data)) {
                // $this->redirect(array('action' => 'editAccount'));
            } else {
                $this->request->data['User']['user_email'] = $user_email;
                $errors = $this->User->validationErrors;
            }
        } else {
            $this->request->data = am($this->request->data, $this->User->read(null, $id));
            
            // dados do usuário
            $data           = $this->request->data;
            $this->set('changePassword', $data['User']['change_password']);
            $this->set('groupId', $data['Group'][0]['id']);

            unset($this->request->data['User']['user_password']);
        }
        $var = array();
        if (count($errors) > 0) {
            $strError = '';
            foreach ($errors as $error) {
                if (is_array($error)) {
                    $strError .= "<div>" . implode(" <br />", $error) . " </div>";
                } else {
                    $strError .= "<div>" . $error . "</div>";
                }
            }
            $var['error'] = 1;
            $var['error_message'] = $strError;
        } else {
            $var['error'] = 0;
        }
        $this->set('errors', $errors);
        if ($this->request->isAjax()) {
            echo json_encode($var);
        }
    }

    public function login()
    {
        $this->layout = 'admin_login';
        $this->Session->delete('auth_user');
        $this->Session->delete('auth_user_group');
        App::uses('Setting', 'AuthAcl.Model');
        $this->loadModel('Pws.Versao');

        $versao = $this->Versao->find('first', array(
            'order' => array(
                'Versao.id' => 'DESC'
            )
        ));

        $this->set('versao', $versao);
        $Setting = new Setting();
        $error = null;

        $general = $Setting->find('first', array(
            'conditions' => array(
                'setting_key' => sha1('general')
            )
        ));
        if (!empty($general)) {
            $general = unserialize($general['Setting']['setting_value']);
        }

        $this->set('general', $general);

        $user = $this->Auth->user();
        if (!empty($user)) {
            $this->redirect($this->Auth->redirect());
        }

        if ($this->request->is('post')) {

            if ($this->Auth->login()) {

                // seta a opção de empresa e filial para todos
                $this->User->read(null, $this->Auth->User('id'));
                $this->User->saveField('filial_id', 0);
                $this->User->saveField('cliente_id', -1);

                if ((int) $this->request->data['User']['remember_me'] == 0) {
                    $this->Cookie->delete('AutoLoginUser');
                } else {
                    $this->Cookie->write('AutoLoginUser', $this->Auth->user(), true, '+2 weeks');
                }
                //$this->redirect($this->Auth->redirect());
                // TODO:: provisóriamente para não dar erro
                $this->redirect("/pws");
            } else {
                $error = __('Seu usuario e senha estão incorretos.');
            }
        }
        $this->set('error', $error);
    }

    public function logout()
    {
        $this->autoRender = false;
        // $this->Session->setFlash('Good-Bye');
        $this->Session->delete('auth_user');
        $this->Session->delete('auth_user_group');
        $this->Cookie->delete('AutoLoginUser');
        $this->redirect($this->Auth->logout());
    }

    public function changeStatus()
    {
        $this->autoRender = false;
        $authUser = $this->Auth->user();
        if ($this->request->isAjax() && $authUser['id'] != $this->request->data['User']['id']) {
            $user = $this->User->read(null, $this->request->data['User']['id']);
            $this->request->data['User'] = am($user['User'], $this->request->data['User']);
            unset($this->request->data['User']['user_password']);
            $this->request->data['User']['user_code'] = '';
            $this->User->data = $this->request->data;
            $this->User->save($this->request->data, false);
        }
    }

    public function resetPassword($code = null)
    {
        $this->layout = 'admin_login';

        App::uses('Setting', 'AuthAcl.Model');
        $Setting = new Setting();

        $general = $Setting->find('first', array(
            'conditions' => array(
                'setting_key' => sha1('general')
            )
        ));

        if (!empty($general)) {
            $general = unserialize($general['Setting']['setting_value']);
        }
        if (isset($general['Setting']) && (int) $general['Setting']['disable_reset_password'] == 1) {
            exit();
        }

        App::uses('CakeEmail', 'Network/Email');
        App::import('Vendor', 'AuthAcl.functions');
        $this->autoRender = false;
        if ($this->request->isAjax() && $code == null) {
            $var = array();
            $sendLink = true;
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'user_email' => $this->request->data['User']['user_email'],
                    'user_status' => 1
                )
            ));

            $permissionChangePassword = false;

            if (!empty($user)) {
                if (!empty($user['User']['user_code'])) {
                    
                    // verifica se possui permissão para alterar senha
                    if($user['User']['change_password'] == 1){
                        $aryCode = explode('-', $user['User']['user_code']);
                        if ($user['User']['user_code'] != sha1('reset_password' . $user['User']['user_email'] . $aryCode[1]) . '-' . $aryCode[1]) {
                            $sendLink = false;
                        }else{
                            $permissionChangePassword = true;
                        }
                    }else{
                        // sem permissão para alterar senha
                        $sendLink = false;
                        $permissionChangePassword = false;
                    }
                }
            } else {
                $sendLink = false;
            }

            if ($sendLink == true) {
                $time = time();
                $code = sha1('reset_password' . $user['User']['user_email'] . $time) . '-' . $time;

                $user['User']['user_code'] = $code;

                unset($user['User']['user_password']);
                unset($user['User']['modified']);

                //                if (isset ($user ['Group'])) {
                //                    unset ($user ['Group']);
                //                }

                //$this->User->id = $user['User']['id'];
                //                unset ($this->User->validate['user_email']);
                //                unset ($this->User->validate['user_password']);
                //                unset ($this->User->validate['user_confirm_password']);

                $data = array('id' => $user['User']['id'], 'user_password' => null, 'modified' => null, 'user_code' => $code);

                if ($this->User->save($data, false)) {

                    $resetPasswordEmail = $Setting->find('first', array(
                        'conditions' => array(
                            'setting_key' => sha1('reset_password')
                        )
                    ));
                    if (!empty($resetPasswordEmail)) {
                        $resetPasswordEmail = unserialize($resetPasswordEmail['Setting']['setting_value']);
                    }

                    $email = new CakeEmail();
                    $email->config('default');
                    $email->from(array(
                        $general['Setting']['email_address'] => __('Por Favor Não Responda')
                    ));
                    $email->to($user['User']['user_email']);
                    $email->subject($resetPasswordEmail['Setting']['request_subject']);

                    $body = $resetPasswordEmail['Setting']['request_body'];

                    $siteAddress = siteURL();
                    $resetLink = siteURL() . "auth_acl/users/resetPassword/" . $code;

                    $body = str_replace('{site_address}', $siteAddress, $body);
                    $body = str_replace('{user_name}', $user['User']['user_name'], $body);
                    $body = str_replace('{user_email}', $user['User']['user_email'], $body);
                    $body = str_replace('{reset_link}', $resetLink, $body);

                    $email->send($body);
                } else {
                    $sendLink = false;
                }
            }

            if($permissionChangePassword == true){
                if ($sendLink == true) {
                    $var['send_link'] = 1;
                } else {
                    $var['send_link'] = 0;
                }
            }else{
                $var['send_link'] = -1;
            }

            echo json_encode($var);
        } else {
            if ($this->request->isPost()) {
                $errors = array();
                $resetFlag = false;
                $this->User->recursive = 0;
                $user = $this->User->find('first', array(
                    'conditions' => array(
                        'user_code' => $this->request->data['User']['code'],
                        'user_status' => 1
                    )
                ));

                if (!empty($user)) {
                    if (!empty($user['User']['user_code'])) {
                        $aryCode = explode('-', $user['User']['user_code']);
                        if ($user['User']['user_code'] == sha1('reset_password' . $user['User']['user_email'] . $aryCode[1]) . '-' . $aryCode[1]) {
                            if (time() - $aryCode[1] < 24 * 60 * 60) {
                                $user['User']['user_code'] = null;
                                $user['User']['user_password'] = $this->request->data['User']['user_password'];
                                $user['User']['user_confirm_password'] = $this->request->data['User']['user_confirm_password'];
                                unset($user['User']['modified']);

                                $this->User->validate = $this->User->reset_password_validate;
                                if ($this->User->save($user)) {

                                    $resetPasswordEmail = $Setting->find('first', array(
                                        'conditions' => array(
                                            'setting_key' => sha1('reset_password')
                                        )
                                    ));
                                    if (!empty($resetPasswordEmail)) {
                                        $resetPasswordEmail = unserialize($resetPasswordEmail['Setting']['setting_value']);
                                    }

                                    $email = new CakeEmail();
                                    $email->config('default');
                                    $email->from(array(
                                        $general['Setting']['email_address'] => __('Por Favor Não Responda')
                                    ));
                                    $email->to($user['User']['user_email']);
                                    $email->subject($resetPasswordEmail['Setting']['success_subject']);

                                    $body = $resetPasswordEmail['Setting']['success_body'];

                                    $siteAddress = siteURL();

                                    $body = str_replace('{site_address}', $siteAddress, $body);
                                    $body = str_replace('{user_name}', $user['User']['user_name'], $body);
                                    $body = str_replace('{user_email}', $user['User']['user_email'], $body);

                                    $email->send($body);
                                    $resetFlag = true;
                                } else {
                                    $errors = $this->User->validationErrors;
                                }
                            } else {
                                $errors['user_code'][] = __('Your reset password code is expired');
                            }
                        }
                    }
                } else {
                    $errors['user_code'][] = __('Your reset password code is not existed');
                }

                if ($resetFlag == true) {
                    $this->set('general', $general);
                    $this->render('reset_password_success');
                } else {
                    $this->set('code', $code);
                    $this->set('errors', $errors);
                    $this->render('reset_password');
                }
            } else {
                $this->set('code', $code);
                $this->set('errors', array());
                $this->render('reset_password');
            }
        }
    }

    public function signup()
    {
        $this->layout = 'admin_login';
        App::uses('Setting', 'AuthAcl.Model');
        $Setting = new Setting();

        App::import('Vendor', 'AuthAcl.recaptcha/recaptchalib');
        $errors = array();

        $general = $Setting->find('first', array(
            'conditions' => array(
                'setting_key' => sha1('general')
            )
        ));
        if (!empty($general)) {
            $general = unserialize($general['Setting']['setting_value']);
        }

        if (isset($general['Setting']) && (int) $general['Setting']['disable_registration'] == 1) {
            exit();
        }

        $this->set('general', $general);

        $groupDefault = (int) $general['Setting']['default_group'];

        $this->User->validate = $this->User->signup_validate;
        if ($this->request->is('post')) {
            $this->User->create();

            if (isset($general['Setting']) && (int) $general['Setting']['require_email_activation'] == 1) {
                $time = time();
                $code = sha1('activate' . $this->request->data['User']['user_email'] . $time) . '-' . $time;
                $this->request->data['User']['user_code'] = $code;
            } else {
                $this->request->data['User']['user_status'] = 1;
            }

            $group = $this->User->Group->find('first', array(
                'conditions' => array(
                    'id' => $groupDefault
                )
            ));

            if (!empty($group)) {
                $this->request->data['Group'] = $group['Group'];
            }

            if ($this->User->saveAssociated($this->request->data)) {

                if (isset($general['Setting']) && (int) $general['Setting']['require_email_activation'] == 1) {
                    $newUserEmail = $Setting->find('first', array(
                        'conditions' => array(
                            'setting_key' => sha1('new_user')
                        )
                    ));
                    if (!empty($newUserEmail)) {
                        $newUserEmail = unserialize($newUserEmail['Setting']['setting_value']);
                    }

                    App::uses('CakeEmail', 'Network/Email');
                    App::import('Vendor', 'AuthAcl.functions');

                    $email = new CakeEmail();
                    $email->config('default');
                    $email->from(array(
                        $general['Setting']['email_address'] => __('Por Favor Não Responda')
                    ));
                    $email->to($this->request->data['User']['user_email']);
                    $email->subject($newUserEmail['Setting']['send_link_subject']);

                    $body = $newUserEmail['Setting']['send_link_body'];

                    $siteAddress = siteURL();
                    $activationLink = siteURL() . "auth_acl/users/activate/" . $code;

                    $body = str_replace('{site_address}', $siteAddress, $body);
                    $body = str_replace('{user_name}', $this->request->data['User']['user_name'], $body);
                    $body = str_replace('{user_email}', $this->request->data['User']['user_email'], $body);
                    $body = str_replace('{activation_link}', $activationLink, $body);

                    $email->send($body);
                }

                $strAction = "controllers/AuthAcl/users/editAccount";
                $this->Acl->allow($this->User, $strAction);

                $strAction = "controllers/AuthAcl/AuthAcl/index";
                $this->Acl->allow($this->User, $strAction);

                $this->Session->write('signup_complete', 1);

                $this->redirect(array(
                    'action' => 'signupcomplete'
                ));
            } else {
                $errors = $this->User->validationErrors;
            }
        }
        $this->set('errors', $errors);
    }

    public function signupcomplete()
    {
        $this->layout = 'admin_login';
        if (!$this->Session->check('signup_complete')) {
            $this->redirect(array(
                'action' => 'login'
            ));
        }
        $this->Session->delete('signup_complete');

        App::uses('Setting', 'AuthAcl.Model');
        $Setting = new Setting();

        $general = $Setting->find('first', array(
            'conditions' => array(
                'setting_key' => sha1('general')
            )
        ));
        if (!empty($general)) {
            $general = unserialize($general['Setting']['setting_value']);
        }

        if (isset($general['Setting']) && (int) $general['Setting']['disable_registration'] == 1) {
            exit();
        }
        $this->set('general', $general);
    }

    public function activate($code = '')
    {
        App::uses('Setting', 'AuthAcl.Model');
        $Setting = new Setting();
        $this->autoRender = false;
        if ($code != '') {
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'user_code' => $code
                )
            ));
            if (!empty($user)) {
                $ary = explode('-', $code);
                if ($code == sha1('activate' . $user['User']['user_email'] . $ary[1]) . '-' . $ary[1]) {
                    $user['User']['user_code'] = null;
                    $user['User']['user_status'] = 1;
                    unset($user['User']['user_password']);
                    unset($user['User']['modified']);
                    if (isset($user['Group'])) {
                        unset($user['Group']);
                    }
                    if ($this->User->save($user, false)) {
                        App::uses('CakeEmail', 'Network/Email');
                        App::import('Vendor', 'AuthAcl.functions');

                        $general = $Setting->find('first', array(
                            'conditions' => array(
                                'setting_key' => sha1('general')
                            )
                        ));
                        if (!empty($general)) {
                            $general = unserialize($general['Setting']['setting_value']);
                        }
                        $newUserEmail = $Setting->find('first', array(
                            'conditions' => array(
                                'setting_key' => sha1('new_user')
                            )
                        ));
                        if (!empty($newUserEmail)) {
                            $newUserEmail = unserialize($newUserEmail['Setting']['setting_value']);
                        }

                        $email = new CakeEmail();
                        $email->config('default');
                        $email->from(array(
                            $general['Setting']['email_address'] => __('Por Favor Não Responda')
                        ));
                        $email->to($user['User']['user_email']);
                        $email->subject($newUserEmail['Setting']['activated_subject']);

                        $body = $newUserEmail['Setting']['activated_body'];
                        $siteAddress = siteURL();

                        $body = str_replace('{site_address}', $siteAddress, $body);
                        $body = str_replace('{user_name}', $user['User']['user_name'], $body);
                        $body = str_replace('{user_email}', $user['User']['user_email'], $body);

                        $email->send($body);

                        $this->Session->write('active_complete', 1);
                    }
                }
            }
        }

        $this->redirect(array(
            'action' => 'activecomplete'
        ));
    }

    public function activecomplete()
    {
        $this->layout = 'admin_login';
        if (!$this->Session->check('active_complete')) {
            $this->redirect(array(
                'action' => 'login'
            ));
        }
        $this->Session->delete('active_complete');
    }

    public function editCli($id = null)
    {
        $this->layout = null;
        $this->autoRender = false;
        $authUser = $this->Auth->user();
        if ($this->request->is('post')) {
            $this->User->read(null, $authUser['id']);
            $this->User->saveField('cliente_id', $this->request->data('id'));
        }
    }


    public function editEmp($id = null)
    { 
        $this->layout = null;
        $this->autoRender = false;
        $authUser = $this->Auth->user();
        
        if ($this->request->is('post')) {
            if ((int) $authUser['id'] > 0) {
                $this->User->read(null, $authUser['id']);
                $this->User->saveField('filial_id', $this->request->data('id'));
            }
        }
    }


    public function listar_clientes_json()
    {
        $this->loadModel('Pws.Cliente');
        $auth_user = $this->Session->read('auth_user');
        $auth_user_group = $this->Session->read('auth_user_group');
        //$this->Cliente->setDataSource($this->conect);
        $this->layout = null;
        if ($this->request->is('ajax')) {

            switch ($auth_user_group['id']) {
                case 1:
                    $this->set('clientes', $this->Cliente->find('list', array(
                        'fields' => array('Cliente.id', 'Cliente.FANTASIA'), 'conditions' =>
                        array("Cliente.FANTASIA LIKE '%" . $this->request['url']['q'] . "%'"),
                        'recursive' => -1
                    )));
                    break;
                case 6:
                    $this->set('clientes', $this->Cliente->find('list', array(
                        'fields' => array('Cliente.id', 'Cliente.FANTASIA'), 'conditions' =>
                        array("Cliente.ID_BASE" => $this->matriz, "Cliente.FANTASIA LIKE '%" . $this->request['url']['q'] . "%'"),
                        'recursive' => -1
                    )));
                    break;
                case 2:
                    $this->set('clientes', $this->Cliente->find('list', array(
                        'fields' => array('Cliente.id', 'Cliente.FANTASIA'), 'conditions' =>
                        array("Cliente.ID_BASE" => $this->matriz, "Cliente.FANTASIA LIKE '%" . $this->request['url']['q'] . "%'"),
                        'recursive' => -1
                    )));
                    break;
            }
        }
    }

    public function listar_empresas_json()
    {
        $this->loadModel('Empresa');
        $auth_user = $this->Session->read('auth_user');
        $auth_user_group = $this->Session->read('auth_user_group');
        $this->layout = null;
        if ($this->request->is('ajax')) {

            switch ($auth_user_group['id']) {
                case 1:
                    $this->set('empresas', $this->Empresa->find('list', array(
                        'fields' => array('Empresa.id', 'Empresa.empresa_fantasia'), 'conditions' =>
                        array("Empresa.empresa_fantasia LIKE '%" . $this->request['url']['q'] . "%'"),
                        'recursive' => -1
                    )));
                    break;
                case 6:
                    $this->set('empresas', $this->Empresa->find('list', array(
                        'fields' => array('Empresa.id', 'Empresa.empresa_fantasia'), 'conditions' =>
                        array("Empresa.ch" => $auth_user['EmpresaSelected']['Empresa']['ch'], "Empresa.empresa_fantasia LIKE '%" . $this->request['url']['q'] . "%'"),
                        'recursive' => -1
                    )));
                    break;
            }
        }
    }

    public function app()
    {
        App::uses('User', 'AuthAcl.Model');
        // Delete autentication, for not cookie the session
        $this->deleteAuth();
        // Get complete user
        $userModel = new User();

        // Render json
        $this->layout = null;
        $this->autoRender = false;

        // Default message if methods is diff to post
        $response = array('status' => 'failed', 'message' => 'HTTP method not allowed');
        $this->response->statusCode(404);

        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                // Load complete user
                $completeUser = $userModel->find('first', array(
                    'conditions' => array(
                        'User.id' => $this->Auth->user('id')
                    )
                ));

                //Verificar grupo do usuario que está sendo autenticado
                $_is_valid_group = $this->isUsuarioTecnico($completeUser['Group']);

                if ($_is_valid_group) {
                    $response = array(
                        'task_completed' => true,
                        'status_code' => 200,
                        'message' => 'Autenticado com sucesso',
                        'data' => $this->Auth->user()
                    );
                    $this->response->statusCode(200);
                } else {
                    $response = array(
                        'task_completed' => false,
                        'status_code' => 401,
                        'message' => 'Usuario não é um Técnico'
                    );
                    $this->response->statusCode(401);
                }
            } else {
                $response = array(
                    'task_completed' => false,
                    'status_code' => 401,
                    'message' => 'Usuário ou senha inválidos',
                );
                $this->response->statusCode(401);
            }
        }

        $this->response->type('application/json');
        $this->response->body(json_encode($response));
    }

    private function isUsuarioTecnico($_group)
    {
        if (!$_group) return false;

        return $_group[0]['id'] == 2;
    }

    /**
     * Delete auth method
     * @author Vinícius Kreusch da Cunha
     */
    private function deleteAuth()
    {
        $this->Session->delete('auth_user');
        $this->Session->delete('auth_user_group');
        $this->Cookie->delete('AutoLoginUser');
        // Disallow CAKEPHP Cookie
        $this->Auth->logout();
    }

    /**
     * Autenticação de usuário para App Softilux
     * 
     * @author Gustavo Silva
     * @since 27/01/2020
     * 
     * @return json
     */
    public function loginApp()
    {

        $this->layout       = null;
        $this->autoRender   = false;
        $jsonResult         = array();

        $success            = false;
        $message            = "";
        $data               = "";

        if ($this->request->isPost()) {

            $login    = $this->request->query['login'];
            $password = AuthComponent::password($this->request->query['password']);
            $userType = array(2, 3); // técnico / cliente
            $version  = isset($this->request->query['version']) ? $this->request->query['version'] : ''; // versão api app
            $android  = isset($this->request->query['android']) ? $this->request->query['android'] : ''; // versão do android

            $query = $this->User->query("SELECT u.id, u.cliente_id,  tecnico_id, u.user_name, user_status, empresa_id, filial_id, filial, g.group_id, e.logo "
                . " FROM users u, users_groups g, empresas e "
                . " WHERE user_email = '{$login}' AND user_password = '{$password}'"
                . " AND g.user_id = u.id "
		        . " AND u.empresa_id = e.id "
                . " LIMIT 1");
            
            if (count($query) > 0) {

                // refine a variável query
                $query = $query[0];

                // verifica tipo de usuário
                if ($query["g"]["group_id"] ==  2 || $query["g"]["group_id"] == 3) {

                    // verifica se está com status ativo
                    if ($query["u"]["user_status"] == 1) {

                        // consulta as empresas relacionados para o usuário
                        $queryEmpresas = $this->User->query("SELECT * FROM users_empresas WHERE user_id = {$query['u']['id']}");

                        $arrEmpresas = array();

                        foreach($queryEmpresas as $key => $data){
                            $arrEmpresas[] = $data['users_empresas']['empresa_id'];
                        }

                        // seta as empresas do usuário
                        $query['u']['empresas'] = $arrEmpresas;

                        $query['u']['logo'] = $query['e']['logo'];

                        // consulta o CDFORNECEDOR para indentificar se é técnico terceirizado ou não
                        $sql = $this->User->query("SELECT id, CDFORNECEDOR FROM tecnicos WHERE NMSUPORTE = '{$query['u']['tecnico_id']}' AND empresa_id = {$query['u']['empresa_id']}");

                        $query['u']['terceirizado'] = $sql[0]['tecnicos']['CDFORNECEDOR'] > 0 ? true : false;

                        $success = true;
                        $data    = $query["u"];

                        // verifica se possui e adiciona as versões da api e versão do android
                        if($version != '' && $android != ''){
                            // seta o usuário
                            $this->User->id = $query['u']['id'];

                            // $this->request->data['User']['app_version_api'] = $version;
                            // $this->request->data['User']['android_version'] = $android;

                            // atualiza as informação de versão do usuário
                            $this->User->query("UPDATE users SET app_version_api = '{$version}',  android_version = '{$android}' WHERE id = {$query['u']['id']}");

                            // $this->User->save($this->request->data);
                        }

                    } else {
                        $message = "Usuário sem permissão";
                    }
                } else {
                    $message = "Usuário não é um Técnico";
                }
            } else {
                $message = "Usuário ou senha incorretos";
                $data = '';
            }
        } else {

            $success = false;
            $message = "Permissão negada";
        }

        // define o json
        $jsonResult   = array("success" => $success, "message" => $message, "data" => $data);

        $this->response->type('application/json');
        $this->response->body(json_encode($jsonResult));
    }
}
