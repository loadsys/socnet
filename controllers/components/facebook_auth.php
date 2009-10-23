<?php

App::import('Vendor', 'socnet.facebook/facebook');

class FacebookAuthComponent extends Object {
	var $__Facebook = null;

	var $logoutRedirect = '/';

	/**
	 *  actions that require login 
	 */
	var $requiresLogin = array();

	var $__enabled = false;

	function initialize(&$controller) {
		ClassRegistry::addObject('FacebookAuthComponent', $this);
		$this->__enabled = Configure::read('Socnet.Facebook.enabled');
		if ( $this->__enabled ) {
			$this->__Facebook =& Facebook::create(Configure::read('Socnet.Facebook.api_key'), Configure::read('Socnet.Facebook.app_secret'));
		}
	}

	function startup(&$controller) {
		if ( $this->__enabled ) {
			if ( $this->requiresLogin == array('*') || in_array($controller->action, $this->requiresLogin) ) {
				$this->__Facebook->require_login();
			}
		}
	}

	function getUserId() {
		if ( $this->__enabled ) {
			return $this->__Facebook->get_loggedin_user();	
		}
		else {
			return null;
		}
	}

	function logout() {
		if ( $this->__enabled ) {
			$this->__Facebook->logout(Router::url($this->logoutRedirect, true));
		}
	}

	function requireLogin() {
		$args = func_get_args();
		if (empty($args) || $args == array('*')) {
			$this->allowedActions = $this->_methods;
		} else {
			if (isset($args[0]) && is_array($args[0])) {
				$args = $args[0];
			}
			$this->requiresLogin = array_merge($this->requiresLogin, $args);
		}
	}

	function &getFacebookObj() {
		return $this->__Facebook;
	}

	function isEnabled() {
		if ( $this->__enabled && $this->__Facebook ) {
			return true;
		}
		else {
			return false;
		}
	}

	function post($message) {
		if ( $this->__enabled && $this->__Facebook ) {
			$this->__Facebook->api_client->stream_post($message);
			return true;
		}
		else {
			return false;
		}
	}

}

class FacebookAuth {

	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& ClassRegistry::getObject('FacebookAuthComponent');
		}
		return $instance[0];
	}

	function getUserId() {
		$_this =& FacebookAuth::getInstance();
		return $_this->getUserId();
	}

	function isLoggedIn() {
		$_this =& FacebookAuth::getInstance();
		$userId = $_this->getUserId();
		return !empty($userId);
	}

	function &getFacebookObj() {
		$_this =& FacebookAuth::getInstance();
		return $_this->getFacebookObj();
	}

	function isEnabled() {
		$_this =& FacebookAuth::getInstance();
		return $_this->isEnabled();
	}

	function post($message) {
		$_this =& FacebookAuth::getInstance();
		return $_this->post($message);
	}

}

?>
