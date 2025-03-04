<?php
namespace Local\Components;

use \Bitrix\Main\Loader;
use \Bitrix\Main\Engine\ComponentController;
use \Bitrix\Main\Data\Cache;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class DealList extends \CBitrixComponent
{
    public function executeComponent()
    {
        Cache::clearCache(true);

        if (!Loader::includeModule("crm")) {
            ShowError("Модуль CRM не установлен!");
            return;
        }

        $this->includeComponentTemplate();
    }
}

