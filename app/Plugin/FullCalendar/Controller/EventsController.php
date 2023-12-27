<?php

//App::uses('FullCalendarAppController', 'FullCalendar.Controller');


class EventsController extends FullCalendarAppController
{

    var $name = 'Events';
    var $paginate = array(
        'limit' => 15
    );

    function index()
    {
        $this->Event->recursive = 0;
        $this->set('events', $this->paginate());
    }

    function view($id = null)
    {
        if (!$id) {
            $this->Session->setFlash(__('Invalid event', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('event', $this->Event->read(null, $id));
    }

    function add($id = null)
    {
        if ($this->request->is('ajax')) {
            $this->layout = null;
        }

        if (!$id) {

            $this->set('clientes', $this->Event->Cliente->find('list'));
            $this->set('eventTypes', $this->Event->EventType->find('list'));
            $this->set('versaos', $this->Event->Versao->find('list', array('order' => 'Versao.id Desc')));


        } else {
            //$this->Event->Cliente->id = $id;
            $clientes = $this->Event->Cliente->find('list', array(
                'conditions' => array('Cliente.id' => $id)));
            $this->set('clientes', $clientes);
            $versao = $this->Event->Versao->find('list', array('order' => 'Versao.id Desc', 'limit' => 1));
            $this->set('versaos', $versao);
            $this->set('eventTypes', $this->Event->EventType->find('list'));
        }

        if ($this->request->is('post')) {

            $versao = $this->Event->Versao->read(null, $this->request->data['Event']['versao_id']);
            $cliente = $this->Event->Cliente->read(null, $id);
            $this->request->data['Event']['title'] = 'Atualizar ' . $cliente['Cliente']['ds_nome'] . ' - ' . $versao['Versao']['versao'];
            $this->request->data['Event']['end'] = $this->request->data['Event']['start'];
            $this->request->data['Event']['details'] = $this->request->data['Event']['title'];
            if ($this->Event->save($this->request->data)) {
                $this->Session->setFlash('Evento Salvo com Sucesso!!', 'default');

                $this->redirect(array('plugin' => 'full_calendar', 'controller' => 'events'));


            }
        }
    }


    function edit($id = null)
    {

        $this->set('eventTypes', $this->Event->EventType->find('list'));

        $this->Event->id = $id;
        if ($this->request->is('get')) {
            $this->request->data = $this->Event->read();
        } else {
            if ($this->Event->save($this->request->data)) {
                $this->Session->setFlash('Your post has been updated.');
                $this->redirect(array('action' => 'index'));
            }
        }

    }


    function delete($id = null)
    {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for event', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Event->delete($id)) {
            $this->Session->setFlash(__('Event deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Event was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

    // The feed action is called from "webroot/js/ready.js" to get the list of events (JSON)
    function feed($id = null)
    {
        $this->layout = "ajax";
        $vars = $this->params['url'];
        $conditions = array('conditions' => array('UNIX_TIMESTAMP(start) >=' => $vars['start'], 'UNIX_TIMESTAMP(start) <=' => $vars['end']));
        $events = $this->Event->find('all', $conditions);
        foreach ($events as $event) {
            if ($event['Event']['all_day'] == 1) {
                $allday = true;
                $end = $event['Event']['start'];
            } else {
                $allday = false;
                $end = $event['Event']['end'];
            }
            $data[] = array(
                'id' => $event['Event']['id'],
                'title' => $event['Event']['title'],
                'start' => $event['Event']['start'],
                'end' => $end,
                'allDay' => $allday,
                'url' => Router::url('/') . 'full_calendar/events/view/' . $event['Event']['id'],
                'details' => $event['Event']['details'],
                'className' => $event['EventType']['color']
            );
        }
        $this->set("json", json_encode($data));
    }

    // The update action is called from "webroot/js/ready.js" to update date/time when an event is dragged or resized
    function update()
    {
        $vars = $this->params['url'];
        $this->Event->id = $vars['id'];
        $this->Event->saveField('start', $vars['start']);
        $this->Event->saveField('end', $vars['end']);
        $this->Event->saveField('all_day', $vars['allday']);
    }

}

?>
