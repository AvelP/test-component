<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\Context;
use Bitrix\Main\Web\Json;
use Bitrix\Main\LoaderException;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$request = Context::getCurrent()->getRequest();
$action = $request->getQuery("action");

if ($action === 'getDeals') {
    try {
        if (!Loader::includeModule('crm')) {
            throw new LoaderException('Модуль CRM не установлен');
        }

        $deals = [];
        $res = \CCrmDeal::GetList([], [], ["ID", "TITLE"], false);
        while ($deal = $res->Fetch()) {
            $deals[] = $deal;
        }

        $response = ['deals' => $deals];

    } catch (\Exception $e) {
        $response = ['error' => $e->getMessage()];
    }
} else {
    $response = ['error' => 'Invalid action'];
}

header('Content-Type: application/json');
echo Json::encode($response);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
