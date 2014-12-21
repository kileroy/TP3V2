<?php
App::uses('AppModel', 'Model');

class Avec extends AppModel {

	public $belongsTo = array(
		'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'privacy_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        public $hasMany = array(
		'Avec' => array(
			'className' => 'Avec',
			'foreignKey' => 'avec_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
      );
}
