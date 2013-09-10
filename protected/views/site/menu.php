<div class="header">
    <div class="logo"><a href="<?php echo Yii::app()->controller->createUrl('/')?>"><img src="static/img/logo.png"></a></div>
    <div class="menu">
        <ul>
            <li><a href="<?php echo Yii::app()->controller->createUrl('/')?>" <?php if (Helper::getRoutePartsForModuleAndController() == 'site/index'): ?> class="active" <?php endif ?> ><?php echo Yii::t('promo', 'Главная'); ?></a></li>
            <li><a href="<?php echo Yii::app()->controller->createUrl('service')?>" <?php if (Helper::getRoutePartsForModuleAndController() == 'site/service'): ?> class="active" <?php endif ?> ><?php echo Yii::t('promo', 'О сервисе'); ?></a></li>
            <li><a href="<?php echo Yii::app()->controller->createUrl('howitworks')?>" <?php if (Helper::getRoutePartsForModuleAndController() == 'site/howitworks'): ?> class="active" <?php endif ?> ><?php echo Yii::t('promo', 'Как это работает'); ?></a></li>
            <li><a href="<?php echo Yii::app()->controller->createUrl('partners')?>" <?php if (Helper::getRoutePartsForModuleAndController() == 'site/partners'): ?> class="active" <?php endif ?> ><?php echo Yii::t('promo', 'Партнеры'); ?></a></li>
            <li><a href="<?php echo Yii::app()->controller->createUrl('contacts')?>" <?php if (Helper::getRoutePartsForModuleAndController() == 'site/contacts'): ?> class="active" <?php endif ?> ><?php echo Yii::t('promo', 'Контакты'); ?></a></li>
        </ul>
    </div>
    <div class="language_selector">
        <a href="#">ru</a>
        <div class="grey_line"></div>
        <a href="#" class="l_r_border">eng</a>
        <div class="grey_line"></div>
        <a href="#">ukr</a>
    </div><div style="clear:both;"></div>
    <div class="magic_button"></div>
</div>