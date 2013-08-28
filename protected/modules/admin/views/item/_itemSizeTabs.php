      <?php if($model->sizeCount==0): ?>
          <div style="margin-left:315px">
              <blockquote>
                <p class="text-info"><?php echo Yii::t('item', 'Размеры не были еще добавлены.');?><p>
              </blockquote>
          </div>
      <?php elseif(isset($showEmptyTab) && $showEmptyTab): ?>
          <div class="size-tab-holder-item">
            <?php $this->widget('bootstrap.widgets.TbTabs', array(
                'type'=>'tabs',
                'tabs'=>$tabs,
            )); ?>
          </div>  
      <?php else: ?>
          <div class="size-tab-holder-item">
            <?php $this->widget('bootstrap.widgets.TbTabs', array(
                'type'=>'tabs',
                'tabs'=>$this->generateAListOfItemSizeTabs($model->id, 
                    (isset($form)) ? $form : null, 
                    (isset($lastModifiedItemSizeModel)) ? $lastModifiedItemSizeModel : null,
                    (isset($newModel)) ? $newModel : null
                ),
            )); ?>
          </div>  
      <?php endIf; ?>
