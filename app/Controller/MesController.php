<?php
App::uses('AppController', 'Controller');
/**
 * Mes Controller
 *
 * @property Me $Me
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Me->recursive = 0;
		$this->set('mes', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Me->exists($id)) {
			throw new NotFoundException(__('Invalid me'));
		}
		$options = array('conditions' => array('Me.' . $this->Me->primaryKey => $id));
		$this->set('me', $this->Me->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Me->create();
			if ($this->Me->save($this->request->data)) {
				$this->Session->setFlash(__('The me has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The me could not be saved. Please, try again.'), 'flash/error');
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
        $this->Me->id = $id;
		if (!$this->Me->exists($id)) {
			throw new NotFoundException(__('Invalid me'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Me->save($this->request->data)) {
				$this->Session->setFlash(__('The me has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The me could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('Me.' . $this->Me->primaryKey => $id));
			$this->request->data = $this->Me->find('first', $options);
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
		$this->Me->id = $id;
		if (!$this->Me->exists()) {
			throw new NotFoundException(__('Invalid me'));
		}
		if ($this->Me->delete()) {
			$this->Session->setFlash(__('Me deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Me was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
}
