<?php 
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
	 * checkGet() - check GET params 
	 */
	public static function checkGet( $arg ){
		if ( isset($_GET[$arg]) && !empty($_GET[$arg]) )
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
	 * get filter for catalog, type is not list
	 */
	public static function getPropertyFilter( $propertyCode, $valuePropertyCode ){
		return array('PROPERTY_'.$propertyCode => $valuePropertyCode );
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
	
	
	/*
	 * getCountIDsHL() - get count of ids products of current user
	 * 
	 * $idHL - id hightload block
	 */
	public static function getDataHLByXmlId( $idHL, $xmlId ){		
		global $USER;
	    CModule::IncludeModule("highloadblock"); 
			    
	    $hlbl = $idHL; 
	    $hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($hlbl)->fetch(); 
	    $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock); 
	    $entity_data_class = $entity->getDataClass();   
	    
	    $rsData = $entity_data_class::getList(array(
	       "select" => array("*"),
	       "order" => array("ID" => "ASC"),
	       "filter" => array('UF_XML_ID' => $xmlId)
	    ));
		$arReturn = array();
	    while($arData = $rsData->Fetch()){
	    	$arReturn[] = $arData;  
	    }
	       	
		return $arReturn;
	}
	
	
	
	/**
	 * getSection() - get  section data 
	 * $idBlock - IBLOCK_ID
	 * $sectionId - section id - parent
	 */
	public static function getSection( $idBlock, $sectionId = false ){
		$resDB = CIBlockSection::GetList( Array("SORT"=>"ASC"), Array('IBLOCK_ID'=>$idBlock, 'SECTION_ID'=>$sectionId), false, Array(), false );
		
		$rootSection = array();
		while ( $resSections = $resDB->fetch() ) {			
			$rootSection[] = $resSections;
		}
		
		return $rootSection;
	}
	
	
	/**
	 * getSection() - get  section data 
	 * $idBlock - IBLOCK_ID
	 * $sectionId - section id - parent
	 * $sectionIdCurrent - section id
	 */
	public static function getCurrSection( $idBlock, $sectionId = false, $sectionIdCurrent = false ){
		$resDB = CIBlockSection::GetList( Array("SORT"=>"ASC"), Array('IBLOCK_ID'=>$idBlock, 'SECTION_ID'=>$sectionId, 'ID'=>$sectionIdCurrent), false, Array(), false );
		
		$rootSection = array();
		while ( $resSections = $resDB->fetch() ) {			
			$rootSection[] = $resSections;
		}
		
		return $rootSection;
	}
	
	
	/**
	 * getAllDataHL() - get all data from HL
	 * $hlblock - hightload block id
	 */
	public static function getAllDataHL( $hlblock ){
		CModule::IncludeModule("highloadblock"); 			    
	    $hlbl = $hlblock; 
	    $hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($hlbl)->fetch(); 
	    $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock); 
	    $entity_data_class = $entity->getDataClass();   
	    
	    $rsData = $entity_data_class::getList(array(
	       "select" => array("*"),
	       "order" => array("ID" => "ASC")	      
	    ));
		global $arHLData;
		$arHLData = array();
		while ( $res = $rsData->fetch() ) {
			$arHLData[] = $res;			
		}
		
		return $arHLData;
	}
	
	
	/**
	 * getDataElById() - get data from info block by Id of element. this will be only one row of result
	 * $idBlock - IBLOCK_ID
	 * $idElement - ID
	 */
	public static function getDataElById ( $idBlock, $idElement ){
		if(CModule::IncludeModule("iblock")){
			return	CIBlockElement::GetList( Array("SORT"=>"ASC"), Array('ID'=>$idElement, 'IBLOCK_ID'=>$idBlock), false, false, Array() )->fetch();
		}
	}
	
	
	/**
	 * getMinPriceSearchTitle() - get min price from array of SCU by product
	 * $idBlock - IBLOCK_ID
	 * $idElement - PROPERTY_CML2_LINK (this is ID of product from iblock of product)
	 */
	public static function getMinPriceSearchTitle( $idBlock, $idElement ){
		if( CModule::IncludeModule("iblock") && CModule::IncludeModule("catalog") ){		
			$resTorgPrDB  = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array('IBLOCK_ID'=>$idBlock,'PROPERTY_CML2_LINK'=>$idElement), false,  false, Array());
								
			$arrAllScu = array();
			while ( $resTorgPr = $resTorgPrDB->fetch() ) {
				$arrAllScu[] = $resTorgPr;
			}
	
			$arrAllScuPrices = array();						
			foreach ($arrAllScu as $k => $val) {
				$resTorgPrPrice = CPrice::GetList(array(), array('IBLOCK_ID'=>$idBlock, 'PRODUCT_ID'=>$val['ID']), false, false, array())->fetch();  
				$arrAllScuPrices[ $resTorgPrPrice['PRICE'] ] = array('PRODUCT_ID'=>$resTorgPrPrice['PRODUCT_ID'], 'PRICE'=>$resTorgPrPrice['PRICE'], 'CURRENCY'=>$resTorgPrPrice['CURRENCY']);
			}	
			
			ksort($arrAllScuPrices);
			$index = 0;
			$arrResScuMinPrice = array();
			foreach ($arrAllScuPrices as $key => $value) {
				if( $index == 0 ){
					$arrResScuMinPrice[] = array('PRODUCT_ID'=>$value['PRODUCT_ID'], 'PRICE'=>$value['PRICE'], 'CURRENCY'=>$value['CURRENCY']);
					$index += 1;
				}else{
					break;
				}
			}
			
			return $arrResScuMinPrice;	
		}		
	}
	
	
	/**
	 * getBrandFilter() - get ids for brand filter
	 * $idBlock - IBLOCK_ID
	 * $code - symb code
	 * $brandXmlId - XML ID of hightload block
	 */
	public static function getBrandFilter ( $idBlock, $code, $brandXmlId ){
		$selectFiled = 'PROPERTY_' . $code;
		$selectFiledValue = 'PROPERTY_' . $code . '_VALUE';

		$resDB = CIBlockElement::GetList( Array("SORT"=>"ASC"), Array('IBLOCK_ID'=>IBLOCK_ID_PRODS), false, false, Array('ID', $selectFiled) );
		$resIDs = array();
		while ( $res = $resDB->fetch() ) {
			if( ($res[$selectFiledValue] == $brandXmlId) ){
				$resIDs[] = $res['ID'];	
			}
		}

		return $resIDs;
	}
	
	
	/**
	 * checkUrl() - fundtion of checkout of url string
	 * 
	 * $detString - symbol of seperation
	 * $includeSymbol - symbol that include in url array
	 * $countArUrl - count of element of url array
	 */
	public static function checkUrl ( $detString, $includeSymbol, $countArUrl ){
		$cUrl  = sest::url();
		$arUrl = explode($detString, $cUrl);
		$includeVal = in_array($includeSymbol, $arUrl);
		
		if( $includeVal && count($arUrl) > $countArUrl )
			return true;
		else
			return false;					
	}
	
	
	
	
	

	
	
	

	
}//end class sest
?>
