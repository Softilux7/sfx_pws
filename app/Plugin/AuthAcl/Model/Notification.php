<?php
App::uses('AuthAclAppModel', 'AuthAcl.Model');
App::uses('AuthComponent', 'Controller/Component');

/**
 * User Model
 *
 */
class Notification extends AuthAclAppModel
{ 
    public function getTecnicosFCM()
    {
        $this->useTable = 'users';
        
        $data = $this->query("SELECT user_name, user_email, fcm_token_device FROM users WHERE empresa_id = 1 and tecnico_id is not null and fcm_token_device is not null");

        return $data;

    }
}