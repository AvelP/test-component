<?php
namespace Local\Components;

use \Bitrix\Main\Loader;
use \Bitrix\Main\Engine\ComponentController;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class DealList extends \CBitrixComponent
{
    public function executeComponent()
    {
        if (!Loader::includeModule("crm")) {
            ShowError("Модуль CRM не установлен!");
            return;
        }

        $this->includeComponentTemplate();
    }
}

