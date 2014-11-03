<?php
App::uses('AppModel', 'Model');
/**
 * Teenager Model
 *
 * @property Me $Me
 */
class Teenager extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'teenager';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'content' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Me' => array(
			'className' => 'Me',
			'foreignKey' => 'me_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
