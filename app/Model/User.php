<?php

App::uses('AppModel', 'Model');
App::import('model', array('Friend'));

class User extends AppModel {
	var $name = 'User';
	var $useTable = 'users';

	public function AccountValidate($email = null, $pass = null) {
		$option = array();
		$option['conditions'] = array(
				'email' => $email,
				'password' => $pass
		);
		$res = $this->find('all', $option);
		return $res;
	}

	public function getUserOnline($user_id = null) {
		//get data in friend table
		$Friend = new Friend();
		$option = $arrFriendID = $arrUser = array();
        
	    $option['fields'] = array(
	    	'Friend.friend_id'
	    );
	    $option['conditions'] = array(
	    	'Friend.user_id' => $user_id
	    );
	    $arrFriendID = $Friend->find('all', $option);
	    foreach($arrFriendID as $key => $value){
	    	$arrFriendID[$key] = $value['Friend']['friend_id'];
	    } 
	     
	    // 
		$option = array();
        $option['joins'] = array(
	        array(
	            'table' => 'online',
	            'alias' => 'Online',
	            'type' => 'LEFT',
	            'conditions' => array(
	                'User.id = Online.user_id'
	            )
	        )
	    );
	    $option['fields'] = array(
	    	'DISTINCT User.*'
	    );
	    $option['conditions'] = array(
	    	'Online.user_id' => $arrFriendID
	    );
	    $option['order'] = array(
	    	'User.id ASC'
	    );
	    $arrUser = $this->find('all', $option);
	    return $arrUser;
	}
}
