<?php
App::uses('AppModel', 'Model');


class Avec extends AppModel {

	public $belongsTo = array(
		'Privacy' => array(
			'className' => 'Privacy',
			'foreignKey' => 'privacy_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
      
}
