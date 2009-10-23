<?php

class FacebookController extends SocnetAppController {
	var $uses = array();
	var $layout = false;
	var $components = array('socnet.FacebookAuth');
	var $helpers = array('socnet.Facebook');

	function beforeFilter() {
                parent::beforeFilter();
		$this->FacebookAuth->requireLogin('friends');
        }

	function xd_receiver() {
		$this->layout = false;
		Configure::write('debug', 0);
	}
	
	function logout() {
		$this->FacebookAuth->logout();
	}

	function friends() {
		$this->layout = 'facebook';
		$friends = array();
		if ( $this->FacebookAuth->getUserId() ) {
			$friends = $this->FacebookAuth->__Facebook->api_client->friends_get();
		}

		$this->set('friends', $friends);

		return $friends;
	}

}

?>
