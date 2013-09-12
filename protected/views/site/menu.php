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
        <?php
        $lang = Yii::app()->languageManager->languages;
        end($lang);
        $last = key($lang);
        foreach ($lang as $key=>$language): ?>

            <a>
                <?php echo CHtml::link(
                    CHtml::encode($language),
                    '#',
                    array('submit' => array('/admin/default/changeLanguage', 'language'=>$key, 'currentLanguageTitle'=>$language, Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken)));
                ?>
            </a>

            <?php
            if($key != $last): ?>
                <div class="grey_line"></div>
            <?php endif;?>

        <?php endForeach ?>
    </div><div style="clear:both;"></div>
    <a href="#">
        <div class="magic_button animated">
        </div>
    </a>

</div>