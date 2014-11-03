<?php
App::uses('AppController', 'Controller');
/**
 * MyEvents Controller
 *
 * @property MyEvent $MyEvent
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MyEventsController extends AppController {

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
		$this->MyEvent->recursive = 0;
		$this->set('myEvents', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->MyEvent->exists($id)) {
			throw new NotFoundException(__('Invalid my event'));
		}
		$options = array('conditions' => array('MyEvent.' . $this->MyEvent->primaryKey => $id));
		$this->set('myEvent', $this->MyEvent->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MyEvent->create();
			if ($this->MyEvent->save($this->request->data)) {
				$this->Session->setFlash(__('The my event has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The my event could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$mes = $this->MyEvent->Me->find('list');
		$events = $this->MyEvent->Event->find('list');
		$users = $this->MyEvent->User->find('list');
		$this->set(compact('mes', 'events', 'users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->MyEvent->id = $id;
		if (!$this->MyEvent->exists($id)) {
			throw new NotFoundException(__('Invalid my event'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->MyEvent->save($this->request->data)) {
				$this->Session->setFlash(__('The my event has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The my event could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('MyEvent.' . $this->MyEvent->primaryKey => $id));
			$this->request->data = $this->MyEvent->find('first', $options);
		}
		$mes = $this->MyEvent->Me->find('list');
		$events = $this->MyEvent->Event->find('list');
		$users = $this->MyEvent->User->find('list');
		$this->set(compact('mes', 'events', 'users'));
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
		$this->MyEvent->id = $id;
		if (!$this->MyEvent->exists()) {
			throw new NotFoundException(__('Invalid my event'));
		}
		if ($this->MyEvent->delete()) {
			$this->Session->setFlash(__('My event deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('My event was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
}
