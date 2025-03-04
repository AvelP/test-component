<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div id="deal-list"></div>

<script>
    BX.ready(function() {
        BX.Vue3.init({
            el: '#deal-list',
            components: {
                DealList: 'local.deal.list'
            }
        });
    });
</script>

<?php
$this->addExternalJs($templateFolder . "/script.js");
?>