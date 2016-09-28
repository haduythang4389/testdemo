<?php

App::uses('AppModel', 'Model');

class Chat extends AppModel {
	var $name = 'Chat';
	var $useTable = 'chat';
	public function getDataChat($user_id = null, $friend_id = null, $limit = 8){
		//get last time send msg
		$option['fields'] = array(
	    	'Chat.send_time'
	    );
	    $option['order'] = array(
	    	'Chat.send_time DESC'
	    );
	    $last_send_time = $this->find('first', $option);
	    $last_send_time = isset($last_send_time['Chat']['send_time']) ? $last_send_time['Chat']['send_time'] : null;

		$option['fields'] = array(
	    	'Chat.*'
	    );
	    $option['conditions'] = array(
	    	'OR' => array(
		               array('AND' => array(
		                              array('Chat.from' => $user_id),
		                              array('Chat.to' => $friend_id)
		                        )),
		               array('AND' => array(
		                              array('Chat.from' => $friend_id),
		                              array('Chat.to' => $user_id)
		                        ))
		            ),
	    	'AND' => array(
	    				'Chat.send_time' <= $last_send_time
	    			)
	    );
	    $option['order'] = array(
	    	'Chat.send_time DESC'
	    );
	    if($limit){
			$option['limit'] = (int)$limit;
		}
	    $arrChat = $this->find('all', $option);
	    return $arrChat;
	}

	public function getNewDataChat($user_id = null, $friend_id = null, $bottom_message_id = null){
		//get last time send msg
		$option['fields'] = array(
	    	'Chat.*'
	    );
	    $option['conditions'] = array(
	    	'OR' => array(
		               array('AND' => array(
		                              array('Chat.from' => $user_id),
		                              array('Chat.to' => $friend_id)
		                        )),
		               array('AND' => array(
		                              array('Chat.from' => $friend_id),
		                              array('Chat.to' => $user_id)
		                        ))
		            )
	    );
	    if($bottom_message_id){
			$option['conditions']['AND'] = array(
		    	'Chat.id >' => $bottom_message_id
		    );	
		}
	    $option['order'] = array(
	    	'Chat.send_time DESC'
	    );
	    
	    $arrChat = $this->find('all', $option);
	    return $arrChat;
	}

	public function getOldDataChat($user_id = null, $friend_id = null, $top_message_id = null , $limit = 8){
		//get last time send msg
		$option['fields'] = array(
	    	'Chat.*'
	    );
	    $option['conditions'] = array(
	    	'OR' => array(
		               array('AND' => array(
		                              array('Chat.from' => $user_id),
		                              array('Chat.to' => $friend_id)
		                        )),
		               array('AND' => array(
		                              array('Chat.from' => $friend_id),
		                              array('Chat.to' => $user_id)
		                        ))
		            )
	    );
	    if($top_message_id){
			$option['conditions']['AND'] = array(
		    	'Chat.id <' => $top_message_id
		    );	
		}
	    $option['order'] = array(
	    	'Chat.send_time DESC'
	    );
	    if($limit){
			$option['limit'] = (int)$limit;
		}
	    $arrChat = $this->find('all', $option);
	    // debug($arrChat);
	    return $arrChat;
	}
}

?>