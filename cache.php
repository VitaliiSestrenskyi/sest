<?
	$obCache 		= Bitrix\Main\Data\Cache::createInstance();
	$cacheLifetime  = 86400; 
	$cacheID 		= 'FEEDBACKS'; 
	$cachePath 		= '/'.$cacheID;
	
	if(isset($_REQUEST['PAGEN_1']))
		$obCache->CleanDir();
	
	if( $obCache->InitCache($cacheLifetime, $cacheID, $cachePath) )
	{
		$vars = $obCache->GetVars();
		$arResult = $vars['FEEDBACKS'];
	}
	elseif( $obCache->StartDataCache() )
	{
		$arResult['DATA'] = GetOniksFeedbacks( $IBLOCK_ID );	
		$arResult['PAGINATION_OBJECT'] = SetOniksFeedbacksPagination( $PAGE_ELEMENT_COUNT,GetOniksFeedbacks( $IBLOCK_ID ) );
		$obCache->EndDataCache(array('FEEDBACKS' => $arResult ));
	}
?>
