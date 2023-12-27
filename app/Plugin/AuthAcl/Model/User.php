<?php
App::uses('AuthAclAppModel', 'AuthAcl.Model');
App::uses('AuthComponent', 'Controller/Component');

/**
 * User Model
 *
 */
class User extends AuthAclAppModel
{

    var $useDbConfig = 'default';

    public $validate = array(
        'user_email' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Por favor, informe o e-mail.'
            ),
            'email' => array(
                'rule' => array('email'),
                'message' => 'Por favor, informe um e-mail válido.'
            ),
            'isEmailExisted' => array(
                'rule' => array('isEmailExisted'),
                'message' => 'Email já cadastrado.'
            )

        ),
        'user_password' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Por favor, informe a Senha.'
            )
        ),
        'user_confirm_password' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Por favor, informe a Confirmação da Senha.'
            ),
            'checkPassword' => array(
                'rule' => array('checkPassword'),
                'message' => 'Senha e Confirmação da Senha não correspondem.',
            )
        ),
        'user_name' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Por favor, informe o Nome.'
            )
        )
    );

    public $reset_password_validate = array(
        'user_password' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Por favor, informe a Senha.'
            )
        ),
        'user_confirm_password' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Por favor, informe a Confirmação da Senha.'
            ),
            'checkPassword' => array(
                'rule' => array('checkPassword'),
                'message' => 'Senha e Confirmação da Senha não correspondem.',
            )
        )
    );

    public $signup_validate = array(
        'user_email' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Por favor, informe o e-mail.'
            ),
            'email' => array(
                'rule' => array('email'),
                'message' => 'Por favor, informe um e-mail válido.'
            ),
            'isEmailExisted' => array(
                'rule' => array('isEmailExisted'),
                'message' => 'Email já cadastrado.'
            )

        ),
        'user_password' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Por favor, informe a Senha.'
            )
        ),
        'user_confirm_password' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Por favor, informe a Confirmação da Senha.'
            ),
            'checkPassword' => array(
                'rule' => array('checkPassword'),
                'message' => 'Senha e Confirmação da Senha não correspondem.',
            )
        ),
        'user_name' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Por favor, informe o Nome.'
            )
        ),
        'recaptcha' => array(
            'required' => array(
                'rule' => array('recaptcha'),
                'message' => 'ReCaptCha Inválido'
            )
        )
    );

    public $login_recaptcha = array(
        'recaptcha' => array(
            'required' => array(
                'rule' => array('recaptcha'),
                'message' => 'ReCaptCha Inválido'
            )
        )
    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Group' => array(
            'className' => 'Group',
            'joinTable' => 'users_groups',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'group_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Tpemail' => array(
            'className' => 'Tpemail',
            'joinTable' => 'users_tpemails',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'tpemail_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Cliente' => array(
            'className' => 'Pws.Cliente',
            'joinTable' => 'users_clientes',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'cliente_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Empresa' => array(
            'className' => 'Empresa',
            'joinTable' => 'users_empresas',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'empresa_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );

    public $actsAs = array('Acl' => array('type' => 'requester'));

    public function parentNode()
    {
        return null;
    }

    public function isEmailExisted($check)
    {
        $user = $this->find('first', array('conditions' => array('`User`.`user_email`' => $check['user_email'])));
        if (!empty($user)) {
            return false;
        } else {
            return true;
        }
    }

    public function beforeSave($options = array())
    {
        if (!empty($this->data['User']['user_password'])) {
            $this->data['User']['user_password'] = AuthComponent::password($this->data['User']['user_password']);
        }
        return true;
    }

    public function checkPassword($check)
    {
        return ($this->data['User']['user_password'] == $this->data['User']['user_confirm_password']);
    }

    public function recaptcha($check)
    {
        App::uses('Setting', 'AuthAcl.Model');
        $Setting = new Setting();

        $general = $Setting->find('first', array('conditions' => array('setting_key' => sha1('general'))));
        if (!empty($general)) {
            $general = unserialize($general['Setting']['setting_value']);
        }
        $flag = false;
        $privatekey = $general['Setting']['recaptcha_private_key'];
        $resp = null;
        $captchaerror = null;

        if (isset($_POST["recaptcha_response_field"]) && $_POST["recaptcha_response_field"]) {
            $resp = recaptcha_check_answer($privatekey,
                $_SERVER["REMOTE_ADDR"],
                $_POST["recaptcha_challenge_field"],
                $_POST["recaptcha_response_field"]);

            if ($resp->is_valid) {
                $flag = true;
            }
        }

        return $flag;
    }

    /**
     * Busca as solicitações de App
     * 
     * @autor Gustavo Andrade
     * @since 10/11/2021
     */
    public function getPermissionRequestsApp()
    {
        $this->useTable = 'app_auth';
        
        $data = $this->query("SELECT a.*, u.*, e.empresa_nome
                                FROM app_auth a
                                INNER JOIN users u ON (u.id = a.user_id)
                                INNER JOIN empresas e ON (e.id = u.empresa_id)
                                WHERE a.android_version is not null
                                AND a.status = 0");

        return $data;

    }

     /**
     * Libera um app para uso
     * 
     * @autor Gustavo Andrade
     * @since 10/11/2021
     */
    public function setPermissionApp($id, $userIdAuthorization)
    {
        $this->useTable = 'app_auth';

        $authorizationDate = date('Y-m-d H:i:s');
        
        try{
            // atualiza os dados
            $this->query("UPDATE app_auth SET STATUS = 1, authorization_date = '{$authorizationDate}', user_id_authorization = {$userIdAuthorization}   WHERE id = {$id}");

            return true;
        }catch(Exception $e){
            return false;
        }
    }

}
