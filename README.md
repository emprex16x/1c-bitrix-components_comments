# 1c-bitrix-components_comments
1C-Bitrix comments component with rating and submit form 


<p>List comments on any page</p>

``` php
<? $APPLICATION->IncludeComponent(
	"bitrix:comments.list",
	".default",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"ELEMENT_ID" => "2",
		"ELEMENT_LIST_CONT" => "1",
		"ELEMENT_SORT_FIELD" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"IBLOCK_ID" => "4"
	)
); ?>
```

<p>Get comments total rating</p>

``` php
<? $APPLICATION->IncludeComponent(
	"bitrix:comments.rating",
	".default",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"ELEMENT_ID" => "2",
		"IBLOCK_ID" => "4"
	)
); ?>
```

<p>Comments form submit for authorized users</p>

``` php
<? $APPLICATION->IncludeComponent(
	"bitrix:comments.add",
	".default",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"ELEMENT_ID" => "2",
		"IBLOCK_ID" => "4"
	)
); ?>
```
