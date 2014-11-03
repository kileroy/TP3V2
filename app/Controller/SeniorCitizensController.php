<?php
App::uses('AppController', 'Controller');
/**
 * SeniorCitizens Controller
 *
 * @property SeniorCitizen $SeniorCitizen
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SeniorCitizensController extends AppController {

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
		$this->SeniorCitizen->recursive = 0;
		$this->set('seniorCitizens', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SeniorCitizen->exists($id)) {
			throw new NotFoundException(__('Invalid senior citizen'));
		}
		$options = array('conditions' => array('SeniorCitizen.' . $this->SeniorCitizen->primaryKey => $id));
		$this->set('seniorCitizen', $this->SeniorCitizen->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SeniorCitizen->create();
			if ($this->SeniorCitizen->save($this->request->data)) {
				$this->Session->setFlash(__('The senior citizen has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The senior citizen could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$mes = $this->SeniorCitizen->Me->find('list');
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
        $this->SeniorCitizen->id = $id;
		if (!$this->SeniorCitizen->exists($id)) {
			throw new NotFoundException(__('Invalid senior citizen'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->SeniorCitizen->save($this->request->data)) {
				$this->Session->setFlash(__('The senior citizen has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The senior citizen could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('SeniorCitizen.' . $this->SeniorCitizen->primaryKey => $id));
			$this->request->data = $this->SeniorCitizen->find('first', $options);
		}
		$mes = $this->SeniorCitizen->Me->find('list');
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
		$this->SeniorCitizen->id = $id;
		if (!$this->SeniorCitizen->exists()) {
			throw new NotFoundException(__('Invalid senior citizen'));
		}
		if ($this->SeniorCitizen->delete()) {
			$this->Session->setFlash(__('Senior citizen deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Senior citizen was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
}
