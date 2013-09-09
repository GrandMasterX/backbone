<?php


class PageController extends Controller {
    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly + block',
        );
    }

    /**
     * Actions used for admin module
     * block - block/unblock user
     * markAsDeleted sets user is_blocked db field value to '2' meaning
     * that the user is deleted but actually it remains in the database
     */
    function actions() {
        return array(
            'block' => array(
                'class' => 'application.modules.admin.components.actions.BlockAction',
                'modelClass' => 'Page',
                'message_block' => Yii::t('infoMessages', 'Контент разблокирован!'),
                'errorMessage_block' => Yii::t('infoMessages', 'Произошла ошибка при разблокировании контента!'),
                'message_unBlock' => Yii::t('infoMessages', 'Контент заблокирован!'),
                'errorMessage_unBlock' => Yii::t('infoMessages', 'Произошла ошибка при блокировании контента!'),
            ),
            'markAsDeleted' => array(
                'class' => 'application.modules.admin.components.actions.MarkAsDeletedAction',
                'modelClass' => 'Pages',
                'message_mark' => Yii::t('infoMessages', 'Страница удалена!'),
                'errorMessage_mark' => Yii::t('infoMessages', 'Произошла ошибка при удалении страницы!'),
            )
        );
    }

    public function actionIndex() {
        $search = new Page('search');
        $search->unsetAttributes();

        if (!is_null(Yii::app()->request->getQuery('Page')))
                    $search->attributes = Yii::app()->request->getQuery('Page');

        $criteria = new CDbCriteria;
        $criteria->compare('t.title', $search->name, true);
        $criteria->compare('t.is_blocked', array('0' => 0, '1' => 1));

        $dataProvider = new ActiveDataProvider('Page', array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => array('weight' => true),
                'sortVar' => 'sort',
            ),
            'pagination' => array(
                'pageVar' => 'page',
                'sizeVar' => 'size',
                'pageSize' => Yii::app()->params['defaultPageSize'],
                'sizeOptions' => Yii::app()->params['sizeOptions'],
            ),
        ));
        $this->render('index',
            array('dataProvider'=>$dataProvider,'search'=>$search)
        );
    }

    public function actionCreate() {
        $model = new Page;

        if (!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax') === 'create-user-form')
            $this->performAjaxValidation($model);

        if (!is_null(Yii::app()->request->getPost('Page'))) {

            $model->attributes = Yii::app()->request->getPost('Page');
            $model->is_blocked = 0;
            if($model->weight)
                $model->weight = 1;

            if ($model->save()) {

                //save client role for user
                $this->setFlashSuccess(Yii::t('infoMessages', 'Новая страница добавлена!'));
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model
        ));
    }

    public function actionUpdate() {
        $model = $this->loadModel();

        if (!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax') === 'update-user-form') {
            $this->performAjaxValidation($model);
        }

        if ($model === null)
            throw new CHttpException(404);

        if (!is_null(Yii::app()->request->getPost('Page'))) {
            $model->attributes = Yii::app()->request->getPost('Page');

            if ($model->save()) {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Данные обновлены!'));
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'uid' => $model->id
        ));
    }
}
