<?php

class ItemController extends Controller {

    public function filters() {
        return array(
            'accessControl',
            'ajaxOnly + block, markAsDeleted, ImportItems, LoadSizeList, GetListOfItems',
        );
    }

    public function behaviors() {
        return array(
            /**
             * Attach Rendering behaviors to utility methods (usefull with ajax calls)
             */
            'sweelixRendering' => array(
                'class' => 'ext.sweekit.behaviors.SwRenderBehavior',
            ),
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
                'modelClass' => 'Item',
                'message_block' => Yii::t('infoMessages', 'Изделие включено!'),
                'errorMessage_block' => Yii::t('infoMessages', 'Произошла ошибка при включении изделия!'),
                'message_unBlock' => Yii::t('infoMessages', 'Изделие выключено!'),
                'errorMessage_unBlock' => Yii::t('infoMessages', 'Произошла ошибка при выключении изделия!'),
            ),
            'markAsDeleted' => array(
                'class' => 'application.modules.admin.components.actions.MarkAsDeletedAction',
                'modelClass' => 'Item',
                'withImages' => true,
                'message_mark' => Yii::t('infoMessages', 'Изделие удалено!'),
                'errorMessage_mark' => Yii::t('infoMessages', 'Произошла ошибка при удалении изделия!'),
            ),
            'asyncUpload' => 'application.extensions.sweekit.actions.SwUploadAction',
            'asyncDelete' => 'application.extensions.sweekit.actions.SwDeleteAction',
        );
    }

    protected function beforeAction() {
        if (isset($_POST['Item']['mainImage']))
            unset($_POST['Item']['mainImage']);

        return true;
    }

    public function actionIndex() {
//        $search = new Item('search');
//        $search->unsetAttributes();
//        //$search->sizeTitleList=null;
//        if (!is_null(Yii::app()->request->getQuery('Item')))
//            $search->attributes = Yii::app()->request->getQuery('Item');
//
//        $criteria = new CDbCriteria;
//        $criteria->compare('t.title', $search->title, true);
//        $criteria->compare('t.code', $search->code, false);
//        $criteria->compare('t.price', $search->price, true);
//        $criteria->with = array('type', 'sizeList');
//        $criteria->together = true;
//        $criteria->compare('type.title', $search->type_search, true);
//        $criteria->compare('sizeList.title', $search->sizeTitleList, true);
//        $criteria->compare('t.is_blocked', array('0' => 0, '1' => 1));
//
//        $dataProvider = new ActiveDataProvider('Item', array(
//            'criteria' => $criteria,
//            'sort' => array(
//                'defaultOrder' => array('create_time' => true),
//                'sortVar' => 'sort',
//                'attributes' => array(
//                    'type_search' => array(
//                        'asc' => 'type.title',
//                        'desc' => 'type.title DESC',
//                    ),
//                    '*',
//                ),
//            ),
//            'pagination' => array(
//                'pageVar' => 'page',
//                'sizeVar' => 'size',
//                'pageSize' => Yii::app()->params['defaultPageSize'],
//                'sizeOptions' => Yii::app()->params['sizeOptions'],
//            ),
//        ));

//************************************
        $filtersForm=new FiltersForm;
        $filtersForm->fullMatch=true;

        $lang=Yii::app()->language;
        if (isset($_GET['FiltersForm']))
            $filtersForm->filters=$_GET['FiltersForm'];

        //$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM item')->queryScalar();
//        with image
//        $sql='SELECT t1.id, t1.code, t1.price, t1.is_blocked, t1.is_locked, t1.ready, t1.unavailable, t1.size_finished, t2.title, t3.company_title AS partner, t4.title AS type, t5.id AS mainItemImage
//              FROM item as t1
//              LEFT JOIN item_translation as t2 ON t1.id=t2.id AND t2.language_id=:lang
//              LEFT JOIN user as t3 ON t1.partner_id=t3.id
//              LEFT JOIN itemtype_translation as t4 ON t1.type_id=t4.id
//              LEFT JOIN item_image as t5 ON t1.id=t5.item_id AND t5.main=1
//              ORDER BY t1.create_time DESC';

        $sql='SELECT t1.id, t1.code, t1.price, t1.is_blocked, t1.is_locked, t1.ready, t1.unavailable, t1.size_finished, t2.title, t3.company_title AS partner, t4.title AS type
              FROM item as t1
              LEFT JOIN user as t3 ON t1.partner_id=t3.id
              LEFT JOIN item_translation as t2 ON t1.id=t2.id AND t2.language_id=:lang
              LEFT JOIN itemtype_translation as t4 ON t1.type_id=t4.id AND t4.language_id=:lang
              WHERE t1.is_blocked=0
              ORDER BY t1.create_time DESC';
        $command=Yii::app()->db->createCommand($sql);
        $command->bindValue(':lang', $lang);
        $data=$command->queryAll();

        $filteredData=$filtersForm->filter($data);

        $dataProvider=new ArrayDataProvider($filteredData, array(
            'totalItemCount'=>count($filteredData),
            'sort'=>array(
                'defaultOrder'=>array('create_time'=>true),
                'attributes'=>array(
                    'title', 'code', 'price', 'type', 'partner'
                ),
            ),
            'pagination' => array(
                'pageVar' => 'page',
                'sizeVar' => 'size',
                'pageSize' => Yii::app()->params['defaultPageSize'],
                'sizeOptions' => Yii::app()->params['sizeOptions'],
            ),
        ));

        //Helper::myPrint_r($dataProvider,true);

        if(!is_null(Yii::app()->request->getQuery('ajax')))
        {
            $this->renderPartial('_grid',array(
                'filtersForm' => $filtersForm,
                'dataProvider'=>$dataProvider,
            ));
        }
        else
        {
            $this->render('index',array(
                'filtersForm' => $filtersForm,
                'dataProvider'=>$dataProvider,
            ));
        }
    }

    public function actionCreate() {
        $model = new Item;
        $model->prepareTranslations();

        if (!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax') === 'create-item-form')
            $this->performMultipleModelAjaxValidation(array($model));

        if (!is_null(Yii::app()->request->getPost('Item'))) {
            $model->attributes = Yii::app()->request->getPost('Item');

            if (!is_null(Yii::app()->request->getPost('ItemTranslation')))
                $model->itemTranslation = Yii::app()->request->getPost('ItemTranslation');

            if ($model->save()) {
                if (!is_null(Yii::app()->request->getPost('movoToSize')))
                    $this->redirect(array('item/update', 'id' => $model->id, 'movoToSize' => 'size_pos'));

                $this->setFlashSuccess(Yii::t('infoMessages', 'Новое изделие добавлено!'));
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate() {
        $model = $this->loadModel();
        $model->prepareTranslations();

        if (!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax') === 'update-item-form') {
            $this->performMultipleModelAjaxValidation(array($model));
        }

        if ($model === null)
            throw new CHttpException(404);

        if (!is_null(Yii::app()->request->getPost('Item'))) {
            $model->attributes = Yii::app()->request->getPost('Item');

            if (!is_null(Yii::app()->request->getPost('ItemTranslation')))
                $model->itemTranslation = Yii::app()->request->getPost('ItemTranslation');

            if ($model->save()) {

                $this->setFlashSuccess(Yii::t('infoMessages', 'Данные изделия обновлены!'));
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'movoToSize' => 'size_pos',
        ));
    }

    /**
     * Generates fields with inputs for translations
     * 
     * @param mixed $model
     * @param mixed $form
     * @return array
     */
    public function generateTranslationFieldsForTab($model, $form) {
        $tabs = array();
        foreach ($model->translations as $language_id => $translation) {
            if ($translation->scenario == 'translation')
                $tabs[] = array('label' => $translation->label, 'content' => $this->renderPartial('_translate', array(
                        'translation' => $translation, 'form' => $form, 'language_id' => $translation->language_id), true, false),
                    'linkOptions' => array('id' => $translation->language_id, 'class' => 'langLink'), 'active' => true);
            else
                $tabs[] = array('label' => $translation->label, 'content' => $this->renderPartial('_translate', array(
                        'translation' => $translation, 'form' => $form, 'language_id' => $translation->language_id), true, false),
                    'linkOptions' => array('id' => $translation->language_id, 'class' => 'langLink'));
        }

        return $tabs;
    }

    /**
     * Generates a list of tabs with existing size models for the given Item model
     * @param mixed $id
     * @param mixed $form
     * @param $lastModifiedItemSizeModel
     * @param $newModel
     * @return array
     */
    public function generateAListOfItemSizeTabs($id, $form, $lastModifiedItemSizeModel, $newModel) {
        //$tabs = array();
        $model = Item::model()->findByPk($id);
        return $this->generateTabs($model, $form, $lastModifiedItemSizeModel, $newModel);
    }

    /**
     * Generates tabs for displaying them when model is loaded for update
     * @param mixed $model
     * @param mixed $form
     * @param $lastModifiedItemSizeModel
     * @param $newModel
     * @return array
     */
    public function generateTabs($model, $form, $lastModifiedItemSizeModel, $newModel) {
        $lastModifiedItemSizeModelID = false;
        $tabs = array();

        foreach ($model->sizeList as $i => $itemSizeModel) {
            if (isset($lastModifiedItemSizeModel) && !is_null($lastModifiedItemSizeModel))
                $lastModifiedItemSizeModelID = $lastModifiedItemSizeModel->id;

            if ($i == 0 && !$lastModifiedItemSizeModelID && is_null($newModel))
                $tabs[] = array('label' => CHtml::encode($itemSizeModel->title), 'content' => $this->renderPartial('_itemSizeForDisplay', array(
                        'itemSizeModel' => $itemSizeModel, 'item_id' => $model->id, 'form' => $form), true, false), 'active' => true);
            elseif ($itemSizeModel->id == $lastModifiedItemSizeModelID && is_null($newModel))
                $tabs[] = array('label' => CHtml::encode($itemSizeModel->title), 'content' => $this->renderPartial('_itemSizeForDisplay', array(
                        'itemSizeModel' => $itemSizeModel, 'item_id' => $model->id, 'form' => $form), true, false), 'active' => true);
            else
                $tabs[] = array('label' => CHtml::encode($itemSizeModel->title), 'content' => $this->renderPartial('_itemSizeForDisplay', array(
                        'itemSizeModel' => $itemSizeModel, 'item_id' => $model->id, 'form' => $form), true, false));
        }

        if ($newModel) {
            $itemSizeModel = new ItemSize;
            //Create random id for a new item. This id is used for buttons running ajax request
            //$itemSizeModel->id=Helper::randomNumberCode();
            $itemSizeModel->item_id = $model->id;
            $itemSizeModel->title = Yii::t('itemSize', 'Новый размер');
            $itemSizeModel->empty = 1;
            $itemSizeModel->save(false);
            $tabs[] = array('label' => CHtml::encode($itemSizeModel->title), 'content' => $this->renderPartial('_itemSize', array(
                    'itemSizeModel' => $itemSizeModel, 'item_id' => $model->id, 'form' => $form), true, true), 'active' => true);
        }

        return $tabs;
    }

    /**
     * Generates empty size form for adding new itemSize
     * Performs itemSize model validations
     */
    public function actionCreateItemSize() {
        $model = $this->loadModel();
        $model->sizeCount = 1;

//        if (!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax') === 'create-itemSize-form')
//            $this->performAjaxValidation($model);

        echo $this->renderPartial('_itemSizeTabs', array(
            'model' => $model, 'newModel' => true, 'showEmptyTab' => false), true, false);

        Yii::app()->end();
    }

    /**
     * Generates and populates the form for updating an itemSize model for a given Item model
     * Performs itemSize model validations
     * @param mixed $size_id
     */
    public function actionUpdateItemSize($size_id) {
        $itemSizeModel = ItemSize::model()->findByPk(array('id' => ':id', ':id' => $size_id));
        $model = $this->loadModel();

        if (!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax') === 'update-itemSize-form')
            $this->performAjaxValidation($itemSizeModel);

        if (!is_null(Yii::app()->request->getPost('ItemSize'))) {
            $itemSizeModel->attributes = Yii::app()->request->getPost('ItemSize');

            if ($itemSizeModel->validate() && $itemSizeModel->save()) {
                $html = $this->renderPartial('_itemSizeTabs', array(
                    'model' => $model, 'lastModifiedItemSizeModel' => $itemSizeModel, 'showEmptyTab' => false), true, true);

                $data = array(
                    'html' => $html,
                    'status' => 'success',
                );
                echo json_encode($data);
            } else {
                $error = CActiveForm::validate($itemSizeModel);
                if ($error != '[]') {
                    $data = array(
                        'error' => json_decode($error),
                        'status' => 'error',
                    );
                    echo json_encode($data);
                }
            }
            Yii::app()->end();
        }

        echo $this->renderPartial('_itemSize', array(
            'itemSizeModel' => $itemSizeModel, 'item_id' => $model->id), true, true);

        Yii::app()->end();
    }

    /**
     * Updates itmSize models attributes in auto mode on blur event
     * @param mixed $size_id
     */
    public function actionAutoUpdate($size_id) {
        $itemSizeModel = ItemSize::model()->findByPk(array('id' => ':id', ':id' => $size_id));
        $model = $this->loadModel();

        if (!is_null(Yii::app()->request->getPost('ItemSize'))) {
            $itemSizeModel->attributes = Yii::app()->request->getPost('ItemSize');

            if ($itemSizeModel->validate() && $itemSizeModel->save()) {
                $data = array(
                    'status' => 'success',
                );
                echo json_encode($data);
            } else {
                $error = CActiveForm::validate($itemSizeModel);
                if ($error != '[]') {
                    $data = array(
                        'error' => json_decode($error),
                        'status' => 'error',
                    );
                    echo json_encode($data);
                }
            }
            Yii::app()->end();
        }

        echo $this->renderPartial('_itemSize', array(
            'itemSizeModel' => $itemSizeModel, 'item_id' => $model->id), true, true);

        Yii::app()->end();
    }

    /**
     * Updates itmSize models stretch attribute in auto mode on blur event
     * @internal param mixed $size_id
     */
    public function actionAutoUpdateItemModel() {
        if (!is_null(Yii::app()->request->getPost('Item'))) {
            $model = $this->loadModel();
            $model->attributes = Yii::app()->request->getPost('Item');

            if ($model->save(false)) {
                $data = array(
                    'status' => 'success',
                );
                echo json_encode($data);
            } else {
                $data = array(
                    'status' => 'error',
                );
                echo json_encode($data);
            }
            Yii::app()->end();
        }
    }

    public function actionDeleteItemSize() {
        $itemSizeModel = $this->loadModel('ItemSize');
        $itemSizeModel->scenario = 'delete';
        $model = Item::model()->findByPk($itemSizeModel->item_id);

        $itemSizeModel->is_blocked = 2;
        $itemSizeModel->item_id = null;
        if ($itemSizeModel->save())
            echo $this->renderPartial('_itemSizeTabs', array(
                'model' => $model, 'showEmptyTab' => false), true, false);

        Yii::app()->end();
    }

    /**
     * Reloads the list of itemSize models for the given Item model
     */
    public function actionReloadTabs() {
        $model = $this->loadModel();
        echo $this->renderPartial('_itemSizeTabs', array(
            'model' => $model, 'showEmptyTab' => false), true, false);

        Yii::app()->end();
    }

    public function actionRemoveMainImage($id, $image_id) {
        if (Yii::app()->user->isGuest) {
            Yii::app()->end();
        }

        $model = $this->loadModel();
        $itemImage = ItemImage::model()->findByPk(array('id' => ':id', ':id' => $image_id));
        $itemImage->item_id = null;
        $itemImage->belongs = null;

        if ($itemImage->save())
            $this->renderPartial('_photo', array(
                'model' => $model,
                    ), false, true
            );
    }

    public function actionRemoveGalleryImage($id, $image_id) {
        if (Yii::app()->user->isGuest) {
            Yii::app()->end();
        }

        $model = $this->loadModel();
        $itemImage = ItemImage::model()->findByPk(array('id' => ':id', ':id' => $image_id));
        $itemImage->item_id = null;
        $itemImage->belongs = null;

        if ($itemImage->save())
            $this->renderPartial('_gallery', array(
                'model' => $model,
                    ), false, true
            );
    }

    public function actionLoadSizeList() {
        $item_id = Yii::app()->request->getPost('item_id');
        $item = Item::model()->findByPk($item_id);
        $models = ItemSize::model()->visible()->findAll(array(
            'condition' => 'item_id=:item_id', 'params' => array(':item_id' => $item_id)));

        $unique_prop = (!empty($item_id) && count($models) == 0) ? array('empty' => 1) : array();
        $propToJs = array();

        foreach ($models as $model) {
            $data[$model->title] = array(
                'iwcb' => array(
                    'title' => 'iwcb',
                    'abr' => Yii::t('itemSize', 'Вп'),
                    'value' => (is_null($model->iwcb) || $model->iwcb == 0) ? null : $model->iwcb,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{Вп}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Высота подреза по спинке (Вп)'))), true, false),
                ),
                'il' => array(
                    'title' => 'il',
                    'abr' => Yii::t('itemSize', 'ДИ'),
                    'value' => (is_null($model->il) || $model->il == 0) ? null : $model->il,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{ДИ}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Длина изделия по спинке (ДИ)'))), true, false),
                ),
                'iwss' => array(
                    'title' => 'iwss',
                    'abr' => Yii::t('itemSize', 'Дбш'),
                    'value' => (is_null($model->iwss) || $model->iwss == 0) ? null : $model->iwss,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{Дбш}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Длина бокового шва (Дбш)'))), true, false),
                ),
                'bw' => array(
                    'title' => 'bw',
                    'abr' => Yii::t('itemSize', 'Шс'),
                    'value' => (is_null($model->bw) || $model->bw == 0) ? null : $model->bw,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{Шс}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Ширина спинки (Шс)'))), true, false),
                ),
                'iwp' => array(
                    'title' => 'iwp',
                    'abr' => Yii::t('itemSize', 'ШГ'),
                    'value' => (is_null($model->iwp) || $model->iwp == 0) ? null : $model->iwp,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{ШГ}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Ширина полочки в узком месте (ШГ)'))), true, false),
                ),
                'iwa' => array(
                    'title' => 'iwa',
                    'abr' => Yii::t('itemSize', 'ШУГ'),
                    'value' => (is_null($model->iwa) || $model->iwa == 0) ? null : $model->iwa,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{ШУГ}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Ширина на уровне талии (ШУГ)'))), true, false),
                ),
                'iww' => array(
                    'title' => 'iww',
                    'abr' => Yii::t('itemSize', 'ШУТ'),
                    'value' => (is_null($model->iww) || $model->iww == 0) ? null : $model->iww,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{ШУТ}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Ширина на уровне талии (ШУТ)'))), true, false),
                ),
                'iwt' => array(
                    'title' => 'iwt',
                    'abr' => Yii::t('itemSize', 'ШУБ'),
                    'value' => (is_null($model->iwt) || $model->iwt == 0) ? null : $model->iwt,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{ШУБ}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Ширина на уровне бедер (ШУБ)'))), true, false),
                ),
                'ils' => array(
                    'title' => 'ils',
                    'abr' => Yii::t('itemSize', 'ДР'),
                    'value' => (is_null($model->ils) || $model->ils == 0) ? null : $model->ils,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{ДР}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Длина рукава (ДР)'))), true, false),
                ),
                'iws' => array(
                    'title' => 'iws',
                    'abr' => Yii::t('itemSize', 'ШР'),
                    'value' => (is_null($model->iws) || $model->iws == 0) ? null : $model->iws,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{ШР}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Ширина рукава вверху (ШР)'))), true, false),
                ),
                'iws2' => array(
                    'title' => 'iws2',
                    'abr' => Yii::t('itemSize', 'ШР2'),
                    'value' => (is_null($model->iws2) || $model->iws2 == 0) ? null : $model->iws2,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{ШР2}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Ширина рукава растянутая (ШР2)'))), true, false),
                ),
                'vpr' => array(
                    'title' => 'vpr',
                    'abr' => Yii::t('itemSize', 'Впр'),
                    'value' => (is_null($model->vpr) || $model->vpr == 0) ? null : $model->vpr,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{Впр}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Высота проймы (Впр)'))), true, false),
                ),
                'rpli' => array(
                    'title' => 'rpli',
                    'abr' => Yii::t('itemSize', 'РплИ'),
                    'value' => (is_null($model->rpli) || $model->rpli == 0) ? null : $model->rpli,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{РплИ}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Разлет плечевой изделия (РплИ)'))), true, false),
                ),
                'stretch' => array(
                    'title' => 'stretch',
                    'abr' => Yii::t('itemSize', 'МНТ'),
                    'value' => (is_null($item->stretch) || $item->stretch == 0) ? null : $item->stretch,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{МНТ}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Максимальное натяжение ткани в см. (МНТ)'))), true, false),
                ),
                'stretchp' => array(
                    'title' => 'stretchp',
                    'abr' => Yii::t('itemSize', 'МРП'),
                    'value' => (is_null($item->stretchp) || $item->stretchp == 0) ? null : $item->stretchp,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{МРП}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Максимальное растяжение подкладки в см. (МРП)'))), true, false),
                ),
                'iwar' => array(
                    'title' => 'iwar',
                    'abr' => Yii::t('itemSize', 'ШУГр'),
                    'value' => (is_null($model->iwar) || $model->iwar == 0) ? null : $model->iwar,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{ШУГр}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Ширина на уровне глубины проймы (ШУГр)'))), true, false),
                ),
                'iwwr' => array(
                    'title' => 'iwwr',
                    'abr' => Yii::t('itemSize', 'ШУТр'),
                    'value' => (is_null($model->iwwr) || $model->iwwr == 0) ? null : $model->iwwr,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{ШУТр}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Ширина на уровне талии (ШУТр)'))), true, false),
                ),
                'iwtp' => array(
                    'title' => 'iwtp',
                    'abr' => Yii::t('itemSize', 'ШУБп'),
                    'value' => (is_null($model->iwtp) || $model->iwtp == 0) ? null : $model->iwtp,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{ШУБп}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Ширина подкладки на уровне бедерн (ШУБп)'))), true, false),
                ),
                'iltwo' => array(
                    'title' => 'iltwo',
                    'abr' => Yii::t('itemSize', 'ДИ2'),
                    'value' => (is_null($model->iltwo) || $model->iltwo == 0) ? null : $model->iltwo,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{ДИ2}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Длина изделия 2 (ДИ2)'))), true, false),
                ),
                'iwsstwo' => array(
                    'title' => 'iwsstwo',
                    'abr' => Yii::t('itemSize', 'Дбш2'),
                    'value' => (is_null($model->iwsstwo) || $model->iwsstwo == 0) ? null : $model->iwsstwo,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{Дбш2}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Длина бокового шва 2 (Дбш2)'))), true, false),
                ),
                'vsl' => array(
                    'title' => 'vsl',
                    'abr' => Yii::t('itemSize', 'Вшл'),
                    'value' => (is_null($model->vsl) || $model->vsl == 0) ? null : $model->vsl,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{Вшл}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Высота шлейфа (Вшл)'))), true, false),
                ),
                'sup' => array(
                    'title' => 'sup',
                    'abr' => Yii::t('itemSize', 'ШУП'),
                    'value' => (is_null($model->sup) || $model->sup == 0) ? null : $model->sup,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{ШУП}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Ширина изделя на уровне подреза (ШУП)'))), true, false),
                ),
                'iwap' => array(
                    'title' => 'iwap',
                    'abr' => Yii::t('itemSize', 'ШУГп'),
                    'value' => (is_null($model->iwap) || $model->iwap == 0) ? null : $model->iwap,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{ШУГп}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Ширина подкладки на уровне глубины проймы (ШУГп)'))), true, false),
                ),
                'iwwp' => array(
                    'title' => 'iwwp',
                    'abr' => Yii::t('itemSize', 'ШУТп'),
                    'value' => (is_null($model->iwwp) || $model->iwwp == 0) ? null : $model->iwwp,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{ШУТп}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Ширина подкладки на уровне талии (ШУТп)'))), true, false),
                ),
                'fabric_type_iwa_stretch' => array(
                    'title' => 'fabric_type_iwa_stretch',
                    'abr' => Yii::t('itemSize', 'МНТг'),
                    'value' => (is_null($item->fabric_type_iwa_stretch) || $item->fabric_type_iwa_stretch == 0) ? null : $item->fabric_type_iwa_stretch,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{МНТг}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Макс.нат ткани по ШУГ (МНТг)'))), true, false),
                ),
                'fabric_type_iww_stretch' => array(
                    'title' => 'fabric_type_iww_stretch',
                    'abr' => Yii::t('itemSize', 'МНТт'),
                    'value' => (is_null($item->fabric_type_iww_stretch) || $item->fabric_type_iww_stretch == 0) ? null : $item->fabric_type_iww_stretch,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{МНТт}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Макс.нат ткани по ШУТ (МНТт)'))), true, false),
                ),
                'fabric_type_iwt_stretch' => array(
                    'title' => 'fabric_type_iwt_stretch',
                    'abr' => Yii::t('itemSize', 'МНТб'),
                    'value' => (is_null($item->fabric_type_iwt_stretch) || $item->fabric_type_iwt_stretch == 0) ? null : $item->fabric_type_iwt_stretch,
                    'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                        'title' => Yii::t('itemSize', '{МНТб}'), 'info' => str_replace(" ", "&#32;", Yii::t('itemSize', 'Макс.нат ткани по ШУБ (МНТб)'))), true, false),
                ),
            );
        }

        if (isset($data)) {
            foreach ($data as $key => $sizeItems) {
                foreach ($sizeItems as $key_s => $sizeItem) {
                    if ($sizeItem['value'] == null) {
                        unset($data[$key][$key_s]);
                    } else {
                        $unique_prop[$key_s] = $sizeItem['link'];
                        $propToJs['prop']['{' . $key . '_' . $sizeItem['abr'] . '}'] = $sizeItem['value'];
                        $propToJs['size'][$key] = $key;
                    }
                }
            }
        }

        $res = array(
            'html' => $this->renderPartial('/formula/_itemProperty', array('data' => $unique_prop), true, false),
            'propToJs' => $propToJs,
        );

        echo json_encode($res);
        Yii::app()->end();
    }

    public function actionGetListOfItemsWithTranslationByItemTypeId() {
        $type_id = Yii::app()->request->getQuery('type_id');
        $lang = Yii::app()->language;
        if (!($type_id) || $type_id == 0) {
            $where = 'item_translation.language_id=:lang';
            $where_cond = array(':lang' => $lang);
        } else {
            $where = 'item.type_id=:type_id AND item_translation.language_id=:lang';
            $where_cond = array(':type_id' => $type_id, ':lang' => $lang);
        }
        $data = Yii::app()->db->createCommand()
                ->select('
                     item.id as id,
                     item.code,
                     item_translation.title as title
                 ')
                ->from(Item::tableName())
                ->leftJoin(ItemTranslation::tableName(), "item.id = item_translation.id")
                ->where($where, $where_cond)
                ->order('item.id ASC')
                ->queryAll();

        if (empty($data)) {
            echo CHtml::tag('option', array('value' => 0), CHtml::encode(Yii::t('item', 'У выбранной модели нет изделий')), true);
            Yii::app()->end();
        }

        echo CHtml::tag('option', array('value' => 0), CHtml::encode(Yii::t('item', 'Выберите изделие')), true);

        foreach ($data as $item) {
            $item['title']=$item['code'] . ' ' . $item['title'];
            echo CHtml::tag('option', array('value' => $item['id']), CHtml::encode($item['title']), true);
        }

        Yii::app()->end();
    }

    public function actionGetListOfItems() {
        $lang = Yii::app()->language;
        $where = 'item_translation.language_id=:lang';
        $where_cond = array(':lang' => $lang);

        $data = Yii::app()->db->createCommand()
            ->select('
                     item.id as id,
                     item.code,
                     item_translation.title as title
                 ')
            ->from(Item::tableName())
            ->leftJoin(ItemTranslation::tableName(), "item.id = item_translation.id")
            ->where($where, $where_cond)
            ->order('item.id ASC')
            ->queryAll();

        if (empty($data)) {
            echo CHtml::tag('option', array('value' => 0), CHtml::encode(Yii::t('item', 'У выбранной модели нет изделий')), true);
            Yii::app()->end();
        }

        echo CHtml::tag('option', array('value' => 0), CHtml::encode(Yii::t('item', 'Выберите изделие')), true);

        foreach ($data as $item) {
            $item['title']=$item['code'] . ' ' . $item['title'];
            echo CHtml::tag('option', array('value' => $item['id']), CHtml::encode($item['title']), true);
        }

        Yii::app()->end();
    }

    public function actionCopy()
    {
        $result=true;
        $oldModel=$this->loadModel();

        if($oldModel===null)
            throw new CHttpException(404);

        $newModel=new Item('copy');
        $newModel->code='0000';
        $newModel->partner_id=$oldModel->partner_id;
        $newModel->type_id=$oldModel->type_id;
        $newModel->fabric_id=$oldModel->fabric_id;

        $newModel->fabric_type_iwa=$oldModel->fabric_type_iwa;
        $newModel->fabric_type_iwa_stretch=$oldModel->fabric_type_iwa_stretch;

        $newModel->fabric_type_iww=$oldModel->fabric_type_iww;
        $newModel->fabric_type_iww_stretch=$oldModel->fabric_type_iww_stretch;

        $newModel->fabric_type_iwt=$oldModel->fabric_type_iwt;
        $newModel->fabric_type_iwt_stretch=$oldModel->fabric_type_iwt_stretch;

        $newModel->colour=$oldModel->colour;
        $newModel->stretch=$oldModel->stretch;
        $newModel->stretchp=$oldModel->stretchp;
        $newModel->bretel=$oldModel->bretel;
        $newModel->price=$oldModel->price;
        $newModel->comment=$oldModel->comment;

        $newModel->ready=0;
        $newModel->size_finished=0;


        //save translation
        $newModel->copyTranslations = $oldModel->translations;
        $result=$newModel->save(false);

        if($result) {
            foreach ($oldModel->sizeList as $i => $itemSizeModel)
            {
                $newItemSize=new ItemSize('copy');
                $newItemSize->attributes=$itemSizeModel->attributes;
                $newItemSize->item_id=$newModel->id;
                $newItemSize->save(false);
            }
        }

        //$result=($rangeStatus && $formulasStatus) ? true : false;

        //$sizeStatus=($sizeStatus) ? 'Успешно' : 'Ошибка';
        $this->redirect(array('item/update', 'id' => $newModel->id));
    }

}
