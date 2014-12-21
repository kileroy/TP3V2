<?php
App::uses('AppController', 'Controller', 'add');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
//
 public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add', 'logout');
    }
//
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
	
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
                            $d = $this->request->data;
                            $link = array('controller'=>'users','action'=>'active',$this->User->id.'-'.md5($d['User']['password']));
                            App::uses('CakeEmail', 'Network/Email');
                            $mail = new CakeEmail();
                        $mail->from('noreply@localhost.net')->to($d['User']['email'])
                                ->subject('Validation d\'inscription')->emailFormat('html')
                                ->template('add')->viewVars(array('username'=>$d['User']['username'], 'link'=>$link))
                                ->send();
                           // $this->send_mail($d['User']['email'], $d['User']['username'], $d['User']['password']);
				$this->Session->setFlash(__('The user has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'flash/error');
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->User->id = $id;
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

public function login() {
    if ($this->request->is('post')) {
        if ($this->Auth->login()) {
            return $this->redirect($this->Auth->redirect());
        } else {
            $this->Session->setFlash(__("Nom d'user ou mot de passe invalide, réessayer"));
        }
    }
}

public function logout() {
    return $this->redirect($this->Auth->logout());
}

 public function active ($token) {
     $token=  explode('-', $token);
     $user=$this->User->find('first',array(
         'condition'=>array('id'=>$token[0],'MD5(User.password)'=>$token[1],'active'=>0)));
 
     if(!empty($user)){
         $this->User->id = $user['User']['id'];
         $this->User->saveField('active', 1);
         $this->Session->setFlash("Votre compte est Activé, procédez...",'flash/success');
         $this->Auth->login($user['User']);
     }else{
         $this->Session->setFlash("Lien d'activation falsifié, extérmination en cours...", 'flash/error');
     }
     $this->redirect(array('action' => 'index'));
 }
}?>
