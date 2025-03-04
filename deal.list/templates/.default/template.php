<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="my-component">
    <h2>Список сделок</h2>
    <ul>
        <?php foreach ($arResult['DEALS'] as $deal): ?>
            <li><?= htmlspecialchars($deal['TITLE']) ?> (ID: <?= $deal['ID'] ?>)</li>
        <?php endforeach; ?>
    </ul>
</div>