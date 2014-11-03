<?php
App::uses('AppController', 'Controller');
/**
 * Teenagers Controller
 *
 * @property Teenager $Teenager
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TeenagersController extends AppController {

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
		$this->Teenager->recursive = 0;
		$this->set('teenagers', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Teenager->exists($id)) {
			throw new NotFoundException(__('Invalid teenager'));
		}
		$options = array('conditions' => array('Teenager.' . $this->Teenager->primaryKey => $id));
		$this->set('teenager', $this->Teenager->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Teenager->create();
			if ($this->Teenager->save($this->request->data)) {
				$this->Session->setFlash(__('The teenager has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The teenager could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$mes = $this->Teenager->Me->find('list');
		$this->set(compact('mes'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->Teenager->id = $id;
		if (!$this->Teenager->exists($id)) {
			throw new NotFoundException(__('Invalid teenager'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Teenager->save($this->request->data)) {
				$this->Session->setFlash(__('The teenager has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The teenager could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('Teenager.' . $this->Teenager->primaryKey => $id));
			$this->request->data = $this->Teenager->find('first', $options);
		}
		$mes = $this->Teenager->Me->find('list');
		$this->set(compact('mes'));
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
		$this->Teenager->id = $id;
		if (!$this->Teenager->exists()) {
			throw new NotFoundException(__('Invalid teenager'));
		}
		if ($this->Teenager->delete()) {
			$this->Session->setFlash(__('Teenager deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Teenager was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
}
