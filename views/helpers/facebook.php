<?php

class FacebookHelper extends AppHelper {
	var $helpers = array('Html');

	function logoutLink($name = 'Logout', $options = array()) {
		return $this->Html->link($name, '/socnet/facebook/logout', $options);
	}

	function jsScript() {
		if ( FacebookAuth::isEnabled() ) {
			return '<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>';
		}
		else {
			return '';
		}
	}

	function jsInit() {
		if ( FacebookAuth::isEnabled() ) {
			return 'FB.init("'.Configure::read('Facebook.api_key').'", "'.Router::url('/socnet/facebook/xd_receiver.html').'");';
		}
		else {
			return '';
		}
	}

	function htmlTag($ns = 'http://www.w3.org/1999/xhtml') {
		if ( FacebookAuth::isEnabled() ) {
			return '<html xmlns="'.$ns.'" xmlns:fb="http://www.facebook.com/2008/fbml">';
		}
		else {
			return '<html xmlns="'.$ns.'">';
		}
	}
}

?>
