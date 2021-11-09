<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

echo '<p>'.GetMessage('COMMENTS_ON_PAGE').' '.$arResult['COMMENTS_COUNT'].'</p>';

echo $arResult['COMMENTS_HTML_OUTPUT'];

if($arResult["NAV_STRING"])
	echo $arResult["NAV_STRING"];