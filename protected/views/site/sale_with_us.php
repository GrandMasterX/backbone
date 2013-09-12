<div class="main_form_all">
    <div class="main_form_top"></div>
    <div class="main_form_wrapper">
        <div class="select_form">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a href="#home" data-toggle="tab"><?php echo Yii::t('promo', 'Продавайте с Astrafit'); ?></a></li>
                <li class=""><a href="#profile" data-toggle="tab"><?php echo Yii::t('promo', 'Посоветовать магазин'); ?></a></li>
            </ul>
            <div class="tab-content">
                <div class="first_tab tab-pane active" id="home"><p><span><?php echo Yii::t('promo', '3 бесплатных месяца'); ?></span><br><?php echo Yii::t('promo', 'для оценки преимуществ сервиса'); ?></p>
                <a href="#Modal_invite" role="button" class="blue_repeat_btn" data-toggle="modal" onclick="document.getElementById('wrapper_hide').style.display='none';"><?php echo Yii::t('promo', 'Присоединиться'); ?></a>
                <a href="#" type="submit" class="grey_repeat_btn">
                    <i class="icon-play-circle"></i><?php echo Yii::t('promo', 'Видео'); ?></a>
                </div>
                <div class="tab-pane" id="profile">
                    <div class="tab-pane" id="home"><p><?php echo Yii::t('promo', 'Хотите видеть Astrofit в своем любимом магазине?'); ?></p>
                        <form class="form-inline">
                            <input type="text" name='magazine_url' class="input-small first_input" placeholder="http:// ссылка магазина">
                            <input type="text" name='magazine_email' class="input-small" placeholder="ваш e-mail">
                            <div class="wy_mail">
                                <p>
                                    <a id="example2" data-toggle="popover" data-placement="bottom" data-content="Мы сообщим вам как только Astrafit появится в этом магазине." title="" data-original-title="Зачем e-mail?"><?php echo Yii::t('promo', 'Зачем e-mail?'); ?></a>
                                </p>
                            </div>
                            <a href="#" type="submit" class="proposition blue_repeat_btn send_magazine"><?php echo Yii::t('promo', 'Предложить'); ?></a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <a name="make_shure"></a>
        <div class="main_form_bottom"></div>
    </div>
</div>