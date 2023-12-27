<?php
App::uses('PwsAppController', 'Pws.Controller');

class UsersLgpdController extends PwsAppController
{
    public function index(){

        $this->loadModel('Pws.UsersLgpd');

        $this->Filter->addFilters('filter1');

        $conditions = array();
        $paginate = array();
        $paginate ['conditions'] = $conditions;
        $paginate ['order'] = 'UsersLgpd.negado DESC, UsersLgpd.id DESC';
        // $paginate ['limit'] = 15;

        $this->paginate = $paginate;

        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->set('usersLgpd', $this->paginate(array(
            // 'UsersLgpd.motivo <>' => '',
        )));

    }
}