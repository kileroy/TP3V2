<?php
App::uses('AppController', 'Controller');
 
class AvecController extends AppController {
 
    public function getByPrivacy() {
        $privacy_id = $this->request->data['Events']['privacy_id'];

        $avec = $this->Avec->find('list', array(
        'conditions' => array('Avec.privacy_id' => $privacy_id),
        'recursive' => -1
        ));

        $this->set('avec',$avec);
        $this->layout = 'ajax';
    }
}