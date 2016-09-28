<?php

App::uses('AppController', 'Controller');

class PagesController extends AppController {
	public function display() {
		//delete session
		$this->Session->delete('AccountInfo');
		$this->layout = '';
		$this->render('home');
	}
}

?>