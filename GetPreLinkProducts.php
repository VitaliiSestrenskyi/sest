<?
function GetPreLinkProducts( $iblockId, $elementId, $showCountElBySides )
{
	if(CModule::IncludeModule("iblock"))
    { 
		$resdb = CIBlockElement::GetList(array('ID' => 'DESC'), array(
		               'IBLOCK_ID' => $iblockId,
		               'ACTIVE' => 'Y',
		               'SECTION_GLOBAL_ACTIVE' => 'Y'),
		               false, array('nPageSize' => $showCountElBySides, 'nElementID' => $elementId),
		               array());
		
		$linkProds = [];
		while ( $res = $resdb->fetch() ) 
		{
			if( $res['ID'] !== $elementId )
			{
				$linkProds[] = (int)$res['ID'];	
			}
		}
		
		if( is_array($linkProds) )
			return $linkProds;	
	}
}
?>
