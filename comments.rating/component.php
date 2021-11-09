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

if ($this->StartResultCache(false, $USER->GetGroups())) {	
	if(!CModule::IncludeModule("iblock")) {
		$this->abortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	if ($arParams["ELEMENT_ID"] != '') {
		
		$arResult = $APPLICATION->IncludeComponent(
			'lv:comments.list',
			'',
			array(
				"ELEMENT_ID" => $arParams["ELEMENT_ID"],
				"IBLOCK_ID" => $arParams['IBLOCK_ID']
			),
			$this
		);

		foreach($arResult['COMMENTS'] as $comment){
			$arResult['COMMENTS_TOTAL_RATING'] += $comment['PROPERTY_RATING_VALUE'];
		}

		$arResult['COMMENTS_TOTAL_RATING'] = round(($arResult['COMMENTS_TOTAL_RATING']+31.25) / ($arResult['COMMENTS_COUNT']+10),1);

		$this->IncludeComponentTemplate();
	}else{
		$this->AbortResultCache();
		ShowError(GetMessage('ELEMENT_ID_NOT_SET'));
		return;
	}
}