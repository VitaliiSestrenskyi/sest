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




///////////////////////////
$сacheObj = Bitrix\Main\Data\Cache::createInstance();
        $cacheTimeSm = 3600;
        $cacheIdSm = 'arrFilterrr';
        $cacheDirSm = '/'.$cacheIdSm;
        $arrFilterrr = [];
        global $arSimilarItems;
        if ($сacheObj->InitCache($cacheTimeSm, $cacheIdSm, $cacheDirSm))
        {
            $arrFilterrr = $сacheObj->GetVars();
        }
        elseif ($сacheObj->StartDataCache())
        {
            function GetPreLinkProducts( $iblockId, $elementId, $showCountElBySides, $sectionId )
            {
                if(CModule::IncludeModule("iblock"))
                {
                    $resdb = CIBlockElement::GetList(array('ID' => 'DESC'), array(
                        'IBLOCK_ID' => $iblockId,
                        'SECTION_ID'=>$sectionId,
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

            $arSectionEl = CIBlockElement::GetByID($ElementID)->fetch();
            $arrFilterrr   = GetPreLinkProducts( 2, (int)$ElementID, 4, (int)$arSectionEl['IBLOCK_SECTION_ID'] );

            if ($isInvalid)
            {
                $сacheObj->abortDataCache();
            }
            $сacheObj->EndDataCache($arrFilterrr);
        }
