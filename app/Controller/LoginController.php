<?php

App::uses('AppController', 'Controller');

class LoginController extends AppController {
	public $components = array ('Session');
	public function index() {
		$this->loadModel('User');
		// request data
		$data = $this->request->data;
		// check user invalid
		$email = isset($data['email']) ? $data['email'] : null;
		$pass = isset($data['pass']) ? $data['pass'] : null;
		$pass = md5($pass);
		$err['error'] = '';

		$arrData = $this->User->AccountValidate($email, $pass);
		if(count($arrData) != 1){
			$err['error'] = 'error';
		} else {
			//write session
			$account['user_id'] = $arrData['0']['User']['id'];
			$this->Session->write('AccountInfo', $account);
		}
		echo json_encode($err);
		$this->autoRender = false;
	}

	public function logout(){
		
	}
}

?>