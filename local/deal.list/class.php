<?php
namespace Local\Components;

use Bitrix\Main\Loader;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Crm\DealTable;
use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class DealListComponent extends \CBitrixComponent implements Controllerable, \Bitrix\Main\Errorable
{
    /** @var ErrorCollection */
    protected $errorCollection;

    public function __construct($component = null)
    {
        parent::__construct($component);
        $this->errorCollection = new ErrorCollection();
    }

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
            $this->errorCollection[] = new Error("Модуль CRM не найден");
            return null;
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

    public function getErrors()
    {
        return $this->errorCollection->toArray();
    }

    public function getErrorByCode($code)
    {
        return $this->errorCollection->getErrorByCode($code);
    }

    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }
}
