<?php
App::uses ( 'PwsAppModel', 'Pws.Model' );
/**
 * Status Model
 */
class UsersLgpd extends PwsAppModel {

    var $useTable = 'users_lgpd';

    /**
	 * belongsTo associations
	 *
	 * @var array
	 */

	public $belongsTo = array (
        'User' => array (
                'className' => 'AuthAcl.User',
                'foreignKey' => 'user_id',
                'conditions' => '',
                'fields' => '',
                'order' => '' 
        ) 
);

}
