<?php

App::uses('AppController', 'Controller');


class TopController extends AppController {
	public function index() {
		//get user online in list friend
		$this->loadModel('User');
		$accountInfo = $this->Session->read('AccountInfo');
		$user_id = $accountInfo['user_id'];
		$arrUserOnline = $this->User->getUserOnline($user_id);
		//set data to template
		$this->set('arrUserOnline', $arrUserOnline);
	}

	public function getMsg(){
		$data = $this->request->data;
		// get message
		$this->loadModel('Chat');
		$accountInfo = $this->Session->read('AccountInfo');
		$user_id = $accountInfo['user_id'];
		$friend_id = $data['id'];
		$data = $this->Chat->getDataChat($user_id, $friend_id);
		//get last message id
		$bottom_message_id = isset($data['0']['Chat']['id']) ? $data['0']['Chat']['id'] : null;
		asort($data); // sort by key of array

		//get the first id
		$top_message_id = reset($data);
		$top_message_id = isset($top_message_id['Chat']['id']) ? $top_message_id['Chat']['id'] : null;
		//set params to template
		$this->set('top_message_id', $top_message_id);
		$this->set('bottom_message_id', $bottom_message_id);
		$this->set('userID', $user_id);
		$this->set('arrChat', $data);
		$this->layout = false;
		$this->render('get_msg');
	}

	public function insertMsg(){
		$data = $this->request->data;
		$accountInfo = $this->Session->read('AccountInfo');
		$user_id = $accountInfo['user_id'];
		$friend_id = isset($data['friend_id']) ? $data['friend_id'] : null;
		$bottom_message_id = isset($data['bottom_message_id']) ? $data['bottom_message_id'] : null;
		$this->loadModel('Chat');
		// insert message

		$this->Chat->set(array(
		    'from' => $user_id,
		    'to' => $friend_id,
		    'message' => $data['message'],
		    'send_time' => date('Y-m-d H:i:s')
		));
		$this->Chat->save();
		// get message
		$data = $this->Chat->getNewDataChat($user_id, $friend_id , (int)$bottom_message_id);
		$bottom_message_id = isset($data['0']['Chat']['id']) ? $data['0']['Chat']['id'] : null;
		asort($data); // sort by key of array

		$this->set('bottom_message_id', $bottom_message_id);
		$this->set('userID', $user_id);
		$this->set('arrChat', $data);
		$this->layout = false;
		$this->render('insert_msg');
	}

	public function autoloadMsg(){
		$data = $this->request->data;
		$accountInfo = $this->Session->read('AccountInfo');
		$user_id = $accountInfo['user_id'];
		$friend_id = isset($data['friend_id']) ? $data['friend_id'] : null;
		$bottom_message_id = isset($data['bottom_message_id']) ? $data['bottom_message_id'] : null;
		
		// get message
		$this->loadModel('Chat');
		$data = $this->Chat->getNewDataChat($user_id, $friend_id , (int)$bottom_message_id);
		if(count($data) > 0){
			$bottom_message_id = isset($data['0']['Chat']['id']) ? $data['0']['Chat']['id'] : null;
			asort($data); // sort by key of array

			$this->set('bottom_message_id', $bottom_message_id);
			$this->set('userID', $user_id);
			$this->set('arrChat', $data);
			$this->layout = false;
			$this->render('autoload_msg');
		} else {
			$this->autoRender = false;
		}
	}

	public function loadOldMsg(){
		$data = $this->request->data;
		$accountInfo = $this->Session->read('AccountInfo');
		$user_id = $accountInfo['user_id'];
		$friend_id = isset($data['friend_id']) ? $data['friend_id'] : null;
		$top_message_id = isset($data['top_message_id']) ? $data['top_message_id'] : null;
		// get message
		$this->loadModel('Chat');
		$data = $this->Chat->getOldDataChat($user_id, $friend_id , (int)$top_message_id);
		if(count($data) > 0){
			// sort by key of array
			asort($data); 
			// get new the first id
			$top_message_id = reset($data);
			$top_message_id = isset($top_message_id['Chat']['id']) ? $top_message_id['Chat']['id'] : null;

			// set params to template
			$this->set('top_message_id', $top_message_id);
			$this->set('userID', $user_id);
			$this->set('arrChat', $data);
			$this->layout = false;
			$this->render('get_old_msg');
		} else {
			$this->autoRender = false;
		}
	}
}
?>