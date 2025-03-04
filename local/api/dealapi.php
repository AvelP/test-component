<?php
use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;
use \Bitrix\Crm\DealTable;

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";

if (!Loader::includeModule("crm")) {
    echo json_encode(["error" => "Модуль CRM не установлен"]);
    die();
}

$request = Application::getInstance()->getContext()->getRequest();
$action = $request->getQuery("action");

if ($action === "getDeals") {
    $deals = DealTable::getList([
        "select" => ["ID", "TITLE"],
        "order" => ["TITLE" => "ASC"]
    ])->fetchAll();

    echo json_encode($deals);
}
