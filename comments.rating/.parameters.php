<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */
/** @global CUserTypeManager $USER_FIELD_MANAGER */
use Bitrix\Main\Config\Option,
	Bitrix\Main\Loader,
	Bitrix\Main\ModuleManager;

global $USER_FIELD_MANAGER;

if (!Loader::includeModule('iblock'))
	return;

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock = array();
$iblockFilter = (
	!empty($arCurrentValues['IBLOCK_TYPE'])
	? array('TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE' => 'Y')
	: array('ACTIVE' => 'Y')
);
$rsIBlock = CIBlock::GetList(array('SORT' => 'ASC'), $iblockFilter);
while ($arr = $rsIBlock->Fetch())
{
	$id = (int)$arr['ID'];
	if (isset($offersIblock[$id]))
		continue;
	$arIBlock[$id] = '['.$id.'] '.$arr['NAME'];
}
unset($id, $arr, $rsIBlock, $iblockFilter);

$arComponentParameters = array(
	"PARAMETERS" => array(
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
		),
		"ELEMENT_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("ELEMENT_ID"),
			"TYPE" => "STRING"
		)	
	),
);