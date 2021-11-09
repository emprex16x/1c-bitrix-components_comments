<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>

<form class="comments-list-submit" method="post" data-id="<?=$arParams['ELEMENT_ID']?>">
	<? if(!empty($arResult['ERRORS']) || isset($arResult['SENT'])) {
		echo '<div class="comments-list-submit__msg">';
		foreach($arResult['ERRORS'] as $error){
			echo '<p class=\'comments-list-submit__msg--error\'>* '.$error.'</p>';
		}
		if(isset($arResult['SENT'])) {
			echo '<p class=\'comments-list-submit__msg--sent\'>* '.$arResult['SENT'].'</p>';
		}
		echo '</div>';
	}; ?>
	<input type="hidden" name="parent">
	<div class="rating-select">
		<div class="rating-select__title"><?=GetMessage('FIELD_RATING')?></div>
		<div class="rating-select__list">
			<? for($i=5; $i>=1; --$i): ?>
				<input type="radio" id="rating<?=$i?>" name="rating" value="<?=$i?>">
				<label for="rating<?=$i?>"></label>
			<? endfor; ?>
		</div>
	<input type="text" name="author" placeholder="<?=GetMessage('FIELD_AUTHOR')?>">
	<textarea name="comment" cols="30" rows="10" placeholder="<?=GetMessage('FIELD_TEXT')?>"></textarea>
	<input type="submit" value="<?=GetMessage('FORM_BTN_SUBMIT')?>">
</form>

<script>
	var tasksListProps = {
		class: 'tasks-list', 
		actionSrc: '<?=$this->GetFolder().'/ajax.php'?>',
		taskHTML: '<div class="tasks-list__item">'
					+'<div class="tasks-list__item-status"></div>'
					+'<h2 class="tasks-list__item-title"></h2>'
					+'<span class="tasks-list__item-date"></span>'
					+'<div class="tasks-list__item-desc"></div></div>',
		taskBtnText_add: 'Добавить задачу',
		taskBtnText_remove: 'Удалить'

	};
</script>