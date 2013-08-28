<?php if(isset($data)):?>
<div id="range-wrapper">
<?php foreach($data as $key=>$item):?>
    <table id="<?php echo $key; ?>" valign="MIDDLE" class="<?php echo ($key>0) ? 'top-margin':'' ?>">
    <tr id="<?php echo $key; ?>" class="<?php echo ($key>0) ? 'no-top-borer':'' ?>">
      <td>
        <span class="size-abr-holder">
             <a href=”#” title=”<?php echo str_replace(" ","&#32;", Yii::t('range', 'Минимально допустимое значение').' ('.$item['min'].')'); ?>”><?php echo '{'.$item['title'].'--}'; ?></a>
        </span>
      </td>
      <td>
        <span class="size-abr-holder">
             <a href=”#” title=”<?php echo str_replace(" ","&#32;", Yii::t('range', 'Минимально допустимое Рекомендованное значение').' ('.$item['minr'].')'); ?>”><?php echo '{'.$item['title'].'_R-}'; ?></a>
        </span>
      </td>
      <td>
        <span class="size-abr-holder">
             <a href=”#” title=”<?php echo str_replace(" ","&#32;", Yii::t('range', 'Максимально допустимое Рекомендованное значение').' ('.$item['maxr'].')'); ?>”><?php echo '{'.$item['title'].'_R+}'; ?></a>
        </span>             
      </td>
      <td>
        <span class="size-abr-holder">
             <a href=”#” title=”<?php echo str_replace(" ","&#32;", Yii::t('range', 'Максимально допустимое значение').' ('.$item['max'].')'); ?>”><?php echo '{'.$item['title'].'++}'; ?></a>
        </span>             
      </td>      
      <td>
         <a id="<?php echo $key; ?>" href="#" class="range-edit" title='<?php echo Yii::t('range', 'Редактировать')?>'></a>
      </td>
    </tr>
    </table>
<?php endForeach; ?>       
</div>
<?php elseIf(isset($model)): ?>
    <table id="<?php echo $model->key; ?>" valign="MIDDLE" class="<?php echo ($model->key>0) ? 'top-margin':'' ?>">
    <tr id="<?php echo $model->key; ?>" class="<?php echo ($model->key>0) ? 'no-top-borer':'' ?>">
      <td>
        <span class="size-abr-holder">
             <a href=”#” title=”<?php echo str_replace(" ","&#32;", Yii::t('range', 'Минимально допустимое значение').' ('.$model->min.')'); ?>”><?php echo '{'.$model->title.'--}'; ?></a>
        </span>
      </td>
      <td>
        <span class="size-abr-holder">
             <a href=”#” title=”<?php echo str_replace(" ","&#32;", Yii::t('range', 'Минимально допустимое Рекомендованное значение').' ('.$model->minr.')'); ?>”><?php echo '{'.$model->title.'_R-}'; ?></a>
        </span>
      </td>
      <td>
        <span class="size-abr-holder">
             <a href=”#” title=”<?php echo str_replace(" ","&#32;", Yii::t('range', 'Максимально допустимое Рекомендованное значение').' ('.$model->maxr.')'); ?>”><?php echo '{'.$model->title.'_R+}'; ?></a>
        </span>             
      </td>
      <td>
        <span class="size-abr-holder">
             <a href=”#” title=”<?php echo str_replace(" ","&#32;", Yii::t('range', 'Максимально допустимое значение').' ('.$model->max.')'); ?>”><?php echo '{'.$model->title.'++}'; ?></a>
        </span>             
      </td>      
      <td>
         <a id="<?php echo $model->key; ?>" href="#" class="range-edit" title='<?php echo Yii::t('range', 'Редактировать')?>'></a>
      </td>
    </tr>
    </table>
<?php else: ?>
    <span id="range-info">
        <?php echo Yii::t('formula', 'Нет диапазонов'); ?>
    </span>    
<?php endIf;?>
