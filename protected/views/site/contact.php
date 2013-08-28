<?php
$this->pageTitle=Yii::t('contact', 'Контакты');

$this->breadcrumbs=array(
    $this->pageTitle,
);
?>
<div class="inner-container">  
    <?php echo Yii::t('contact', '
        <address>
          <strong>AstraFit</strong><br>
          Бориславская 54,<br>
          Киев, Украина<br>
          <abbr title="Phone">Тел:</abbr> (123) 456-7890
        </address>
         
        <address>
          <strong>Никита Добрынин</strong><br>
          <a href="mailto:#">first.last@example.com</a>
        </address>
    ');?>
</div>
