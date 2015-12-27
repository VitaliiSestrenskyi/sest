<?php 
//namespace SestrenskyiWorkClass;

class sest{	
	function __construct($argument) {
		
	}
		
	/**
	 * checkout of submit form
	 */
	public static function subForm( $fild ){
		if( isset($_REQUEST[$fild]) && !empty($_REQUEST[$fild]) ){
			return true;
		}else {
			return false;
		}		
	}
	
	/**
	 * get value of form input 
	 */
	public static function getFormInputVal( $fild ){
		if( isset($_REQUEST[$fild]) && !empty($_REQUEST[$fild]) ){
			return $_REQUEST[$fild];
		}else {
			return false;
		}		
	}
		
	/**
	 * get current url
	 */
	public static function url() {
			  if (isset($_SERVER['REQUEST_URI'])) {
			    $uri = $_SERVER['REQUEST_URI'];
			  }
			  else {
			    if (isset($_SERVER['argv'])) {
			      $uri = $_SERVER['SCRIPT_NAME'] .'?'. $_SERVER['argv'][0];
			    }
			    elseif (isset($_SERVER['QUERY_STRING'])) {
			      $uri = $_SERVER['SCRIPT_NAME'] .'?'. $_SERVER['QUERY_STRING'];
			    }
			    else {
			      $uri = $_SERVER['SCRIPT_NAME'];
			    }
			  }
			  // Prevent multiple slashes to avoid cross site requests via the FAPI.
			  $uri = '/'. ltrim($uri, '/');
			
			  return $uri;
	}
	
	/**
	 * check params
	 */
	public static function checkPar( $arg ){
		if ( isset($arg) && !empty($arg) ){
			return true;
		}else{
			return false;
		}
	}
	
	
}//end class sest



?>

