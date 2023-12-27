<?php
 
class Event extends FullCalendarAppModel {
	var $name = 'Event';
	var $displayField = 'title';
	var $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'start' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		)
	);

	var $belongsTo = array(
		'EventType' => array(
			'className' => 'FullCalendar.EventType',
			'foreignKey' => 'event_type_id'
		),
		'Cliente' => array(
			'className' => 'Gestao.Cliente',
			'foreignKey' => 'cliente_id'
		),
		'Versao' => array(
			'className' => 'Gestao.Versao',
			'foreignKey' => 'versao_id'
		),
	);

}
?>
