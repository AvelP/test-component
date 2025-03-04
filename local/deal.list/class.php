<?php
namespace Local\Components;

use Bitrix\Main\Loader;
use Bitrix\Main\Engine\Controllerable;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Crm\DealTable;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class DealListComponent extends \CBitrixComponent implements Controllerable
{
    public function configureActions()
    {
        return [
            "getDeals" => [ // Действие API
                "prefilters" => [
                    new ActionFilter\HttpMethod([ActionFilter\HttpMethod::METHOD_GET]), // Разрешаем только GET-запросы
                    new ActionFilter\Csrf() // Защита от CSRF
                ],
            ],
        ];
    }

    public function getDealsAction()
    {
        if (!Loader::includeModule("crm")) {
            return ["status" => "error", "message" => "Модуль CRM не найден"];
        }

        $deals = [];
        $result = DealTable::getList([
            "select" => ["ID", "TITLE"],
            "order" => ["TITLE" => "ASC"],
            "limit" => 10
        ]);

        while ($deal = $result->fetch()) {
            $deals[] = $deal;
        }

        return ["status" => "success", "data" => $deals];
    }

    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }
}
