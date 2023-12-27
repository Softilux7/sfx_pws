<?php

 
class EventType extends FullCalendarAppModel {
	var $name = 'EventType';
	var $displayField = 'name';
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
	);

	var $hasMany = array(
		'Event' => array(
			'className' => 'FullCalendar.Event',
			'foreignKey' => 'event_type_id',
			'dependent' => false,
		)
	);

}
?>
