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
if($USER->IsAuthorized()){
	$arParams['IBLOCK_ID'] = intval($arParams['IBLOCK_ID']);
	$arParams['ELEMENT_ID'] = trim($arParams["ELEMENT_ID"]);

	if ($this->StartResultCache(false, $USER->GetGroups())) {	
		if(!CModule::IncludeModule("iblock")) {
			$this->abortResultCache();
			ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
			return;
		}
		if ($arParams["ELEMENT_ID"] != '') {
				
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				if($_POST != $_SESSION['oldPOST']){
					$comment_author = htmlentities($_REQUEST["author"]);
					$comment_text = htmlentities($_REQUEST["comment"]);
					$comment_rating = $_REQUEST["rating"] <= 5 ? intval($_REQUEST["rating"]) : 0;
					$comment_parentID = intval($_REQUEST["parent"]);
				
					$arResult['ERRORS'] = [];

					if(trim($comment_author) == '')
						$arResult['ERRORS'][] = GetMessage('ERROR_COMENT_AUTHOR');
					if(trim($comment_text) == '')
						$arResult['ERRORS'][] = GetMessage('ERROR_COMENT_TEXT');
					if(empty($arResult['ERRORS'])){

						$el = new CIBlockElement;

						$arComment_props = [];
						$arComment_props['ELEMENT_ID'] = $arParams["ELEMENT_ID"];
						$arComment_props['PARENT_ID'] = $comment_parentID;
						$arComment_props['RATING'] = $comment_rating;

						$arComment = Array(
						"MODIFIED_BY"    => $USER->GetID(),
						"IBLOCK_SECTION_ID" => false, 
						"IBLOCK_ID"      => $arParams['IBLOCK_ID'],
						"PROPERTY_VALUES"=> $arComment_props,
						"NAME"           => $comment_author,
						"ACTIVE"         => "N",
						"PREVIEW_TEXT"   => $comment_text,
						);

						if($comment_ID = $el->Add($arComment)){
							$arResult['SENT'] = GetMessage('SENT');
							$_SESSION['oldPOST'] = $_POST;
						}else{
							$arResult['ERRORS'][] = $el->LAST_ERROR;
						}
					}	
				}
			}

			$this->IncludeComponentTemplate();
		}else{
			$this->AbortResultCache();
			ShowError(GetMessage('ELEMENT_ID_NOT_SET'));
			return;
		}
	}
};