<?php
use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Crm\DealTable;

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";

if (!Loader::includeModule("crm")) {
    echo json_encode(["status" => "error", "message" => "Модуль CRM не найден"]);
    die();
}

$request = Application::getInstance()->getContext()->getRequest();
$action = $request->getQuery("action");

if ($action === "getDeals") {
    $deals = [];
    $result = DealTable::getList([
        "select" => ["ID", "TITLE"],
        "order" => ["TITLE" => "ASC"],
        "limit" => 10
    ]);

    while ($deal = $result->fetch()) {
        $deals[] = $deal;
    }

    echo json_encode(["status" => "success", "data" => $deals]);
}

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php";
