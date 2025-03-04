<?php
namespace Local\Components;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Engine\Controller;
use Bitrix\Crm\DealTable;
class DealListController extends Controller
{
    public function configureActions()
    {
        return [
            'getDeals' => [
                'prefilters' => []
            ]
        ];
    }

    public function getDealsAction()
    {
        Loader::includeModule("crm");

        $deals = DealTable::getList([
            "select" => ["ID", "TITLE"],
            "order" => ["TITLE" => "ASC"]
        ])->fetchAll();

        return $deals;
    }
}
?>