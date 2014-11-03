<?php
App::uses('AppController', 'Controller');
/**
 * Adults Controller
 *
 * @property Adult $Adult
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AdultsController extends AppController {

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
		$this->Adult->recursive = 0;
		$this->set('adults', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Adult->exists($id)) {
			throw new NotFoundException(__('Invalid adult'));
		}
		$options = array('conditions' => array('Adult.' . $this->Adult->primaryKey => $id));
		$this->set('adult', $this->Adult->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Adult->create();
			if ($this->Adult->save($this->request->data)) {
				$this->Session->setFlash(__('The adult has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The adult could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$mes = $this->Adult->Me->find('list');
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
        $this->Adult->id = $id;
		if (!$this->Adult->exists($id)) {
			throw new NotFoundException(__('Invalid adult'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Adult->save($this->request->data)) {
				$this->Session->setFlash(__('The adult has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The adult could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('Adult.' . $this->Adult->primaryKey => $id));
			$this->request->data = $this->Adult->find('first', $options);
		}
		$mes = $this->Adult->Me->find('list');
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
		$this->Adult->id = $id;
		if (!$this->Adult->exists()) {
			throw new NotFoundException(__('Invalid adult'));
		}
		if ($this->Adult->delete()) {
			$this->Session->setFlash(__('Adult deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Adult was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
}
