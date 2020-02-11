<?php
use App\Config;
?>
<div class="alert alert-success" role="alert">
    <h3 class="alert-heading">Заказ от <?=$data['customer']['email']?></h3>
    <p><b><?=$data['customer']['fio']?></b> совершил заказ книги <b>"<?=$data['book']['title']?>"</b> в колличестве <b><?=$data['customer']['count']?> штук</b>
    </p>
    <p><h3>Краткое описание книги:</h3><?=$data['book']['desc_short']?></p>
    <hr>
    <p class="mb-0">Вернуться на <a href="<?=Config::SITE_URL?>">GFL.TEST</a>.</p>
</div>
