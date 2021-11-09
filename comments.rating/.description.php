<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("IBLOCK_NAME"),
	"DESCRIPTION" => GetMessage("IBLOCK_DESCRIPTION"),
	"ICON" => "/images/like_buttons.gif",
	"COMPLEX" => "Y",
	"SORT" => 10,
	"PATH" => array(
		"ID" => "content",
		"CHILD" => array(
			"ID" => "contacts-rating",
			"NAME" => GetMessage("IBLOCK_NAME"),
			"SORT" => 30,
		)
	)
);