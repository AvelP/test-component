<?php
use Bitrix\Main\Loader;
use Bitrix\Crm\DealTable;
use Bitrix\Main\Application;

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";

$request = Application::getInstance()->getContext()->getRequest();
$sortKey = $request->get("sortKey") ?: "TITLE";
$sortOrder = strtoupper($request->get("sortOrder")) === "DESC" ? "DESC" : "ASC";
$currentPage = max(1, (int) $request->get("currentPage"));
$itemsPerPage = max(1, (int) $request->get("itemsPerPage"));

if (!Loader::includeModule("crm")) {
    echo json_encode(["status" => "error", "message" => "Модуль CRM не найден"]);
    die();
}

// Подсчет количества сделок
$totalCount = DealTable::getCount();

// Получение сделок с учетом пагинации
$deals = [];
$result = DealTable::getList([
    "select" => ["ID", "TITLE"],
    "order" => [$sortKey => $sortOrder],
    "limit" => $itemsPerPage,
    "offset" => ($currentPage - 1) * $itemsPerPage
]);

while ($deal = $result->fetch()) {
    $deals[] = $deal;
}

// Отправляем JSON-ответ
echo json_encode([
    "status" => "success",
    "data" => [
        "deals" => $deals,
        "totalCount" => $totalCount
    ],
    "getparam" => [
        "select" => ["ID", "TITLE"],
        "order" => [$sortKey => $sortOrder],
        "limit" => $itemsPerPage,
        "offset" => ($currentPage - 1) * $itemsPerPage
    ]
]);
die();
