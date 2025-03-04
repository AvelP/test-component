<?php
namespace Local\Components;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Crm\DealTable;
use CBitrixComponent;

class DealsListComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        if (!Loader::includeModule("crm")) {
            ShowError("CRM module is not installed");
            return;
        }

        $this->arResult['DEALS'] = $this->getDeals();
        $this->includeComponentTemplate();
    }

    private function getDeals()
    {
        $deals = [];
        $result = DealTable::getList([
            'select' => ['ID', 'TITLE', 'STAGE_ID', 'OPPORTUNITY'],
            'order' => ['TITLE' => 'ASC']
        ]);

        while ($deal = $result->fetch()) {
            $deals[] = $deal;
        }
        return $deals;
    }
}
