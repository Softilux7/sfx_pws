<?php
App::uses('AuthAclAppModel', 'AuthAcl.Model');
App::uses('AuthComponent', 'Controller/Component');

/**
 * User Model
 *
 */
class Script extends AuthAclAppModel
{
    public $useTable = 'users';
}