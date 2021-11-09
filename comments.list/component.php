<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

$arParams['IBLOCK_ID'] = intval($arParams['IBLOCK_ID']);
$arParams['ELEMENT_ID'] = trim($arParams["ELEMENT_ID"]);
$arParams["ELEMENT_LIST_CONT"] = intval($arParams["ELEMENT_LIST_CONT"]);

if ($this->StartResultCache(false, $USER->GetGroups())) {	
	if(!CModule::IncludeModule("iblock")) {
		$this->abortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	if ($arParams["ELEMENT_ID"] != '') {
		$arOrder = [
			$arParams['ELEMENT_SORT_FIELD'] => $arParams['ELEMENT_SORT_ORDER']
		];
		$arFilter = [
			"ACTIVE" => "Y",
			"IBLOCK_ID" => $arParams['IBLOCK_ID'], 
			"PROPERTY_ELEMENT_ID" => $arParams['ELEMENT_ID'],
			"PROPERTY_PARENT_ID" => 0,
		];
		$arSelect = [
			"NAME", "ID", "DATE_CREATE", "PREVIEW_TEXT", 
			"PROPERTY_PARENT_ID", "PROPERTY_RATING",
		];
		
		$arNavParams = [
			"nPageSize" => $arParams["ELEMENT_LIST_CONT"],
			"bDescPageNumbering" => false,
			"bShowAll" => 'Y',
		];

		if($arParams["ELEMENT_LIST_CONT"] <= 0)
			$arNavParams = false;

		$result = CIBlockElement::GetList($arOrder, $arFilter, false, $arNavParams, $arSelect);
		if($arNavParams)
			$arResult['NAV_STRING'] = $result->GetPageNavStringEx($navComponentObject, '', '', 'Y');
		while($rows = $result->GetNext()){
			$arResult['COMMENTS'][] = $rows;
		}

		/* Getting sub comments */
		if(!empty($arResult['COMMENTS'])){
			
			unset($arFilter['PROPERTY_PARENT_ID']);
			$arFilter['>PROPERTY_PARENT_ID'] = 0;
			$result = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
			while($rows = $result->GetNext()){
				$subComments[] = $rows;
			}
			if(!empty($subComments)){
				if(!function_exists('subComments_filter')) {
					function subComments_filter($arResult,$parentID, $parentKey){
						foreach($arResult as $comment){
							if($parentID != $comment[$parentKey]) continue;
								$subComments_relatedIds .= $comment['ID'].',';
								$subComments_relatedIds .= subComments_filter($arResult,$comment['ID'],$parentKey);
						}
						return $subComments_relatedIds;
					}
				}
				foreach($arResult['COMMENTS'] as $comment){
					$parentKey = 'PROPERTY_PARENT_ID_VALUE';
					if($comment[$parentKey] == 0)
						$subComments_relatedIds .= subComments_filter($subComments,$comment['ID'],$parentKey);
				}

				$subComments = array_filter($subComments, function($k) use ($subComments_relatedIds){
					return strpos($subComments_relatedIds, $k['ID']) !== false;
				});

				$arResult['COMMENTS'] = array_merge($arResult['COMMENTS'], $subComments);
				unset($subComments);
			}
		}
		
		$arResult['COMMENTS_COUNT'] = count($arResult['COMMENTS']);

		if(!empty($this->__parent)) return $arResult;
		
		$this->IncludeComponentTemplate();
		
	}else{
		$this->AbortResultCache();
		ShowError(GetMessage('ELEMENT_ID_NOT_SET'));
		return;
	}
}

if($USER->IsAuthorized()){
	$arButtons = CIBlock::GetPanelButtons($arParams['IBLOCK_ID'], 0, $arParams['SECTION_ID']);
	if($APPLICATION->GetShowIncludeAreas())
		$this->AddIncludeAreaIcons(CIBlock::GetComponentMenu("configure", $arButtons));
	CIBlock::AddPanelButtons($APPLICATION->GetPublicShowMode(), $this->GetName(), array("intranet"=>$arButtons["intranet"]));
}