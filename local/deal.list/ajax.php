<?php
use Bitrix\Main\Loader;
use Bitrix\Crm\DealTable;
use Bitrix\Main\Application;

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";

$request = Application::getInstance()->getContext()->getRequest();
$lastId = (int) $request->get("lastId"); // ID последней сделки
$itemsPerPage = max(1, (int) $request->get("itemsPerPage"), 5);
$sortOrder = strtoupper($request->get("sortOrder")) === "DESC" ? "DESC" : "ASC";

if (!Loader::includeModule("crm")) {
    echo json_encode(["status" => "error", "message" => "Модуль CRM не найден"]);
    die();
}

// Фильтруем сделки по lastId
$filter = [];
if ($lastId > 0) {
    if ($sortOrder === "ASC") {
        $filter[">ID"] = $lastId;
    } else {
        $filter["<ID"] = $lastId;
    }
}

$deals = [];
$result = DealTable::getList([
    "select" => ["ID", "TITLE"],
    "order" => ["ID" => $sortOrder],
    "filter" => $filter,
    "limit" => $itemsPerPage
]);

while ($deal = $result->fetch()) {
    $deals[] = $deal;
}

// Отправляем JSON-ответ
echo json_encode([
    "status" => "success",
    "data" => [
        "deals" => $deals
    ]
]);
die();

