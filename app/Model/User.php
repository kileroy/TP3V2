<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 *
 * @property Event $Event
 * @property MyEvent $MyEvent
 */
class User extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'username';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
            'email' => array(
		'email' => array(
		'rule' => array('email'),
		'message' => 'E-Mail Invalide',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
            'file' =>array(
            'rule' => array('extension', array('jpg','jpeg','png','gif')), 
            'message' => 'Ce format n\'est pas accepter, s\'il vous plait changer de format.'
            )
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'MyEvent' => array(
			'className' => 'MyEvent',
			'foreignKey' => 'user_id',
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
        
    public function beforeSave($options = array()) {
       if (isset($this->data[$this->alias]['password'])) {
           $passwordHasher = new SimplePasswordHasher();
           $this->data[$this->alias]['password'] = $passwordHasher->hash(
               $this->data[$this->alias]['password']
           );
       }
       return true;
    }
    //Vérification d'extention d'image
    

}
