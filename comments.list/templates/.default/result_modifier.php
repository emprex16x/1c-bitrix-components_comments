<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arResult['ELEMENT_ID'] = $arParams['ELEMENT_ID'];

if(!function_exists('comments')) {
	function comments($arResult, $ID=0){ 	
		$htmlOutPut ='';
		$depsLevel = 0;
		foreach($arResult['COMMENTS'] as $comment){
			if($ID == $comment['PROPERTY_PARENT_ID_VALUE']){
				if($comment['PROPERTY_PARENT_ID_VALUE'] > 0) 
					++$depsLevel; 
				ob_start(); ?>
					<div class="comments-list__thread">
						<div class="comments-list__comment" data-id="<?=$comment['ID'] ?>">
							<b><?=$comment['NAME'] ?></b> <span><?=$comment['DATE_CREATE'] ?></span>
							<div class="star-rating">
								<? for($i=1; $i <= 5; ++$i){
									echo '<i'.($i <= $comment['PROPERTY_RATING_VALUE'] ? ' class="checked"' : '').'></i>';
								}; ?>
							</div>
							<p><?=$comment['PREVIEW_TEXT'] ?></p>
						</div>
						<?=comments($arResult, $comment['ID']) ?>
					</div>
				<? $htmlOutPut .= ob_get_contents();
				ob_end_clean();
			}	
		}
		if(!empty($htmlOutPut))
			return '<div class="'.($depsLevel > 0 ? 'comments-list__children':'comments-list').'" data-id="'.$arResult['ELEMENT_ID'].'">'.$htmlOutPut.'</div>';
	};
}
$arResult['COMMENTS_HTML_OUTPUT'] = comments($arResult);


