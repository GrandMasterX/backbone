            <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'login-form',
                        'enableAjaxValidation'=>true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        ),
                        'htmlOptions'=>array(
                            'class'=>'form-signin'
                            ),
                        )); ?>
                <h2 class="form-signin-heading"><?php echo Yii::t('login', 'Авторизация');?></h2>
                <div class="control-group">  
                    <?php echo $form->labelEx($model,'email', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'email', array('class'=>'input-block-level', 'placeholder'=>Yii::t('login', 'Email'))); ?>
                        <?php echo $form->error($model,'email'); ?>
                    </div>
                </div>

                <div class="control-group"> 
                    <?php echo $form->labelEx($model,'password', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->passwordField($model,'password', array('class'=>'input-block-level', 'placeholder'=>Yii::t('login', 'Пароль'))); ?>
                        <?php echo CHtml::hiddenField('item_id',Yii::app()->request->getQuery('item_id')); ?>
                        <?php echo $form->error($model,'password'); ?>
                    </div>
                </div>

                <div class="control-group"> 
                    <div class="controls">
                        <?php echo CHtml::link(Yii::t('loginForm', 'Восстановление пароля'),'',array('class'=>'restore-link-front'))?>
                    </div>
                </div>
                <div class="control-group"> 
                    <?php
                        if(isset($_GET['social']) && $_GET['social']==1)
                            $this->widget('ext.hoauth.widgets.HOAuth');
                    ?>
                </div>
                <div class="control-group"> 
                    <div class="controls">
                        <?php echo CHtml::submitButton(Yii::t('loginForm', 'Войти'),array('class'=>'btn')); ?>
                    </div>
                </div>
<!--                
            <div class="eauth">  
                <div class="eauth-title">
                    <h5><?php //echo Yii::t('frontLogin', 'Вход через:');?></h5>
                </div>
                <div class="eauth-icons">
                    <?php //$this->widget('ext.eauth.EAuthWidget', array('action' => 'site/login'));?>      
                </div>
            </div> -->               
                            
            <?php $this->endWidget(); ?>
            <div class="span2 center"> 
                <?php echo CHtml::link(CHtml::encode(Yii::t('register', 'Регистрация')),array('#'),array('id'=>'to-register','class'=>'','title'=>Yii::t('register', 'Вход  в кабинет'))); ?>
            </div>