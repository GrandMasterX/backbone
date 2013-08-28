<?php
$this->pageTitle=Yii::t('shopList', 'Список партнеров');

$this->breadcrumbs=array(
    $this->pageTitle,
);
?>
<h4 class="text-center">
    <?php echo Yii::t('shopList', 'Список магазинов,<br/> которые уже используют сервис подбора подходящих размеров одежды Astrafit</h4>
    <div class="well well-small">
    <span class="label label-info">Info</span>
    Нижеприведенные ссылки ведут на страницы с изделиями (тип: платья), по которым доступен подбор размеров. Кликнув на "изображение кнопки" возле интересующего вас изделия, система запросит у вас необходимые мерки и подберет подходящие размер.   
    '); ?>
</div>

<ul>
    <li><a href="http://musthave.ua/catalog/dress" target="_blank"><?php echo Yii::t('shopList', 'MustHave.ua - магазин любимой одежды.'); ?></a></li>
</ul>