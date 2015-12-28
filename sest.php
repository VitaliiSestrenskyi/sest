<?php
class sest{	
		
	function __construct($argument) {
		//self::$site = $_SERVER['SERVER_NAME'];
		//self::$fullUrl = $_SERVER['SERVER_NAME'] . $this->url();
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
		}else{
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
	 * getFullUrl() - get full site url
	 */
	public static function getFullUrl(){		
		return  $_SERVER['SERVER_NAME'].self::url();
	}	
	
	
	/**
	 * getHost() - get host of site
	 */
	public static function getHost(){		
		return  $_SERVER['SERVER_NAME'];
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
	
	/**
	 * checkReq() - check REQUEST params 
	 */
	public static function checkReq( $arg ){
		if ( isset($_REQUEST[$arg]) && !empty($_REQUEST[$arg]) )
			return true;
		else
			return false;	
	}
	
	
	
	/**
	 * getPropIDs() - get IDs by property code
	 * 
	 * $propertyCode - property code TYPE OF PROPERTY = LIST
	 * $iblockId - id info block
	 * $propVal - value of property
	 */
	public static function getPropIDs( $propertyCode, $iblockId, $propVal ){
		$propName = 'PROPERTY_' . $propertyCode .'_VALUE';
		$resDB = CIBlockElement::GetList( Array("SORT"=>"ASC"), Array('IBLOCK_ID'=>$iblockId, $propName => $propVal), false, false, Array() );		
		$arrIDs = array();		
		while ($arRes = $resDB->fetch()) {
			$arrIDs[] = $arRes['ID'];
		}	
		
		return $arrIDs;
	}
	
	
	/**
	 * getPropIDsByID() - get IDs by property code for TYPE OF PROPERTY = binding to the information block elements
	 * 
	 * $propertyCode - property code 
	 * $iblockId - id info block 
	 */
	public static function getPropIDsByID( $propertyCode, $iblockId, $idProduct ){
		$propName = 'PROPERTY_' . $propertyCode;
		$propNameValue = 'PROPERTY_' . $propertyCode .'_VALUE';
		$resDB = CIBlockElement::GetList( Array("SORT"=>"ASC"), Array('IBLOCK_ID'=>$iblockId, 'ID'=>$idProduct), false, false, Array('ID', 'NAME', 'IBLOCK_ID', $propName) );				
		$arrIDs = array();		
		while ($arRes = $resDB->fetch()) {
			$arrIDs[] = $arRes[$propNameValue];
		}	
		
		return $arrIDs;
	}	
	

	/*
	 * getCountIDsHL() - get count of ids products of current user
	 * 
	 * $idHL - id hightload block
	 */
	public static function getCountIDsHL( $idHL ){		
		global $USER;
	    CModule::IncludeModule("highloadblock"); 
			    
	    $hlbl = $idHL; 
	    $hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($hlbl)->fetch(); 
	    $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock); 
	    $entity_data_class = $entity->getDataClass();   
	    
	    $rsData = $entity_data_class::getList(array(
	       "select" => array("*"),
	       "order" => array("ID" => "ASC"),
	       "filter" => array('UF_USER' => $USER->GetID())
	    ));
	    while($arData = $rsData->Fetch())
	       $arResult['WISH_LIST'][] = $arData;   //весь мой список желаний  конкретного user
	    
	    foreach ($arResult['WISH_LIST'] as $key => $value) 
	        $arIDs[] = $value['UF_PRODUCT'];
	    		
		return $arIDs;
	}

	
}//end class sest
?>
