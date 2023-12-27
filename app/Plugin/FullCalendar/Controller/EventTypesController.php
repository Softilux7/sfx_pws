<?php
App::uses('FullCalendarAppController', 'FullCalendar.Controller');

 
class EventTypesController extends FullCalendarAppController {

	var $name = 'EventTypes';

        var $paginate = array(
            'limit' => 15
        );

	function index() {
		$this->EventType->recursive = 0;
		$this->set('eventTypes', $this->paginate());
	}

	function view($id = null) {
		if(!$id) {
			$this->Session->setFlash(__('Invalid event type', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('eventType', $this->EventType->read(null, $id));
	}

	function add() {

		  if ($this->request->is('post')) {
            if ($this->EventType->save($this->request->data)) {
                $this->Session->setFlash('Evento Salvo com Sucesso!!','default');
                $this->redirect(array('action' => 'index'));
            }
        }
	}


	function edit($id = null) {

        $this->EventType->id = $id;
    	if ($this->request->is('get')) {
    		$this->request->data = $this->EventType->read();
    	} else {
    		if ($this->EventType->save($this->request->data)) {
    			$this->Session->setFlash('Your post has been updated.');
    			$this->redirect(array('action' => 'index'));
    		}
    	}
		
	}


	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for event type', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EventType->delete($id)) {
			$this->Session->setFlash(__('Event type deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Event type was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
