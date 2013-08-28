<?php
class ItemTypeController extends Controller
{
    public $category_tree = array();
    protected $languageTab;

    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly + block, markAsDeleted',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'roles' => array('manage_admin'),//this is a role containing all tasks and operations
            ),
            array('allow',
                'roles' => array('view_admin'),//allows to view admin list
                'actions' => array('index'),
            ),
            array('allow',
                'roles' => array('create_admin'),//allows to create an admin
                'actions' => array('create'),
            ),
            array('allow',
                'roles' => array('update_admin'),//allows to update an admin
                'actions' => array('update'),
            ),
            array('allow',
                'roles' => array('mark_as_deleted_admin'),//allows to markAsDeleted an admin
                'actions' => array('markAsDeleted'),
            ),
            array('allow',
                'roles' => array('block_admin'),//allows to block an admin
                'actions' => array('block'),
            ),
            array('allow',
                'roles' => array('copy_model_admin'),//allows to generate password for admin
                'actions' => array('copyModel'),
            ),
            array('allow',
                'roles' => array('update_range_admin'),//allows to change password for admin
                'actions' => array('updateRange'),
            ),
            array('deny'),
        );
    }
    
    /**
    * Actions used for admin module
    * block - block/unblock user
    * markAsDeleted sets user is_blocked db field value to '2' meaning
    * that the user is deleted but actually it remains in the database
    */
    function actions()
    {
        return array(
            'block' =>array(
                'class'=>'application.modules.admin.components.actions.BlockForTreeAction',
                'modelClass'=>'ItemType',
                'message_block'=>Yii::t('infoMessages', 'Тип(ы) изделия(й) включен(ы)!'),
                'errorMessage_block'=>Yii::t('infoMessages', 'Произошла ошибка при включении типа(ов) изделия(й)!'),
                'message_unBlock'=>Yii::t('infoMessages', 'Тип(ы) изделия(ы) выключен(ы)!'),
                'errorMessage_unBlock'=>Yii::t('infoMessages', 'Произошла ошибка при выключении типа(ов) изделия(й)!'),
            ),
            'markAsDeleted' =>array(
                'class'=>'application.modules.admin.components.actions.MarkAsDeletedForTreeAction',
                'modelClass'=>'ItemType',
                'message_mark'=>Yii::t('infoMessages', 'Тип(ы) изделия(й) удален(ы)!'),
                'errorMessage_mark'=>Yii::t('infoMessages', 'Произошла ошибка при удалении типа(ов) изделия(й)!'),
            )            
        );
    }     
    
	public function actionIndex()
	{

        $search = new ItemType('search');
        $search->unsetAttributes();
        if (!is_null(Yii::app()->request->getQuery('ItemType')))
            $search->attributes = Yii::app()->request->getQuery('ItemType');

		$criteria=new CDbCriteria;
        $criteria->compare('t.is_blocked',array('0'=>0, '1'=>1));
        $criteria->order='root, lft';
        $criteria->with = array('translations');
        $criteria->together = true;
        $criteria->compare('translations.title', $search->item_type_search, true);

		$dataProvider=new ActiveDataProvider('ItemType',array(
			'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => array('create_time' => true),
                'sortVar' => 'sort',
                'attributes' => array(
                    'item_type_search' => array(
                        'asc' => 'translations.title',
                        'desc' => 'translations.title DESC',
                    ),
                    '*',
                ),
            ),
            'pagination'=>array(
                'pageSize'=>500,//Todo:fix bug with pagination disabling
            ),            
		));

        if(!is_null(Yii::app()->request->getQuery('ajax')))
		{
			$this->renderPartial('_grid',array(
				'dataProvider'=>$dataProvider,
                'model'=>$search,
			));
		}
		else
		{
			$this->render('index',array(
				'dataProvider'=>$dataProvider,
                'model'=>$search,
			));
		}
	}

	public function actionCreate()
	{
        if(!is_null(Yii::app()->request->getPost('ItemType')))
            $postItemType = Yii::app()->request->getPost('ItemType');
        
        $model = new ItemType();
        $model->prepareTranslations();
        
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='create-itemType-form')
            $this->performMultipleModelAjaxValidation(array($model));

		if(isset($postItemType))
		{
            $model->typeSizeList=$postItemType['typeSizeList'];
            
            if(!is_null(Yii::app()->request->getPost('ItemTypeTranslation')))
                $model->itemTypeTranslation = Yii::app()->request->getPost('ItemTypeTranslation');
                
            if (!empty($postItemType['root']))
            {
                $node=ItemType::model()->findByPk($postItemType['root']);
                if($model->appendTo($node))
                {
                    $this->setFlashSuccess(Yii::t('infoMessages', 'Новый тип изделия добавлен как подкатегория к ' . ucfirst($node->title)));
                    $this->redirect(array('index'));                       
                }
            }             
			elseif($model->saveNode()) 
            {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Новый тип изделия добавлен!'));
                $this->redirect(array('index'));                    
            }
        }
        
        $this->render('create',array(
            'model'=>$model,
        ));
	}

	public function actionUpdate()
	{
        if(!is_null(Yii::app()->request->getPost('ItemType')))
            $postItemType = Yii::app()->request->getPost('ItemType');
                    
		$model=$this->loadModel();
        $model->prepareTranslations();

        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='update-itemType-form')
            $this->performMultipleModelAjaxValidation(array($model));
        
		if($model===null)
			throw new CHttpException(404);

		if(isset($postItemType))
		{
            $model->typeSizeList=$postItemType['typeSizeList'];
            
            if(!is_null(Yii::app()->request->getPost('ItemTypeTranslation')))
                $model->itemTypeTranslation = Yii::app()->request->getPost('ItemTypeTranslation');
                
            if (!empty($postItemType['root']) && $postItemType['root']<>$model->root)
            {
                $node=ItemType::model()->findByPk($postItemType['root']);
                if($model->moveAsFirst($node))
                {
                    $this->setFlashSuccess(Yii::t('infoMessages', 'Тип изделия перенесен в подкатегорию к ' . ucfirst($node->title)));
                    $this->redirect(array('index'));                       
                }
            }            
            elseif($model->saveNode())
            {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Данные типа изделия обновлены!'));
                $this->redirect(array('index'));
            }
 		}

		$this->render('update',array(
            'model'=>$model, 
            'uid'=>$model->id,
        ));
	}
    
    public function generateTranslationFieldsForTab($model, $form)
    {
        $tabs = array();
        foreach($model->translations as $language_id=>$translation)
        {
            if ($translation->scenario=='translation')
                $tabs[] = array('label'=>$translation->label, 'content'=>$this->renderPartial('_translate', array(
                    'translation'=>$translation, 'form'=>$form, 'language_id'=>$translation->language_id), true, false), 
                    'linkOptions'=>array('id'=>$translation->language_id, 'class'=>'langLink'), 'active'=>true);
            else
                $tabs[] = array('label'=>$translation->label, 'content'=>$this->renderPartial('_translate', array(
                    'translation'=>$translation, 'form'=>$form, 'language_id'=>$translation->language_id), true, false), 
                    'linkOptions'=>array('id'=>$translation->language_id, 'class'=>'langLink'));
        }
        
        return $tabs;         
    }
    
    public function actionLoadFormulaList()
    {
        $html=null;
        $type_id=Yii::app()->request->getPost('type_id');
        $item_id = Yii::app()->request->getPost('item_id');
        if(!empty($item_id) && empty($type_id)) {
            $sql = 'SELECT DISTINCT t2.id
                    FROM item t1
                    LEFT JOIN item_type t2 on t1.type_id = t2.id
                    WHERE t1.id=:item_id';
            $type_id = Yii::app()->db->createCommand($sql);
            $type_id->bindParam(":item_id", $item_id, PDO::PARAM_STR);
            $type_id = $type_id->queryRow();
            $type_id = $type_id['id'];
        }
        $models=Formula::model()->unlocked()->noParent()->findAll(array(
            'condition'=>'type_id=:type_id', 'params'=>array(':type_id'=>$type_id)
            )
        );
        
        $item=Item::model()->findByPk($item_id);
        $html=$this->renderPartial('/formula/_formula',array('models'=>$models, 'sizeList'=>($item) ? $item->sizeList : null), true, false);
        
        echo json_encode(array('html'=>$html,'type_id'=>$type_id,'item_id'=>$item_id));                
    }
    
    public function buildTreeArray()
    {
        $level=1;
        $tree = array(); 
        
        $roots=ItemType::model()->roots()->findAll();
        
        foreach($roots as $n=>$root)
        {
            
            $tree[$n]['id']=$root->id;
            $tree[$n]['title']=$root->title;            
            
            $children=$root->children()->findAll();
            foreach($children as $child)
            {
                $tree[$n]['chid'][] = array(
                    'id'=>$child->id,
                    'title'=>$child->title,
                    );
            }
            
        }
        
        return $tree;
    }    
    
    public function buildTree($categories)
    {
        $level=0;
         
        foreach($categories as $n=>$category)
        {
            if($category->level==$level)
                echo CHtml::closeTag('li')."\n";
            else if($category->level>$level)
                echo CHtml::openTag('ul')."\n";
            else
            {
                echo CHtml::closeTag('li')."\n";
         
                for($i=$level-$category->level;$i;$i--)
                {
                    echo CHtml::closeTag('ul')."\n";
                    echo CHtml::closeTag('li')."\n";
                }
            }
         
            echo CHtml::openTag('li');
            echo CHtml::encode($category->title);
            $level=$category->level;
        }
         
        for($i=$level;$i;$i--)
        {
            echo CHtml::closeTag('li')."\n";
            echo CHtml::closeTag('ul')."\n";
        }
    }
    
    public function getTreeRecursive() {
        $criteria = new CDbCriteria;
        $criteria->order = 'root, lft';
        $criteria->condition = 'level = 1';
        //$categories = Category::model()->findAll($criteria);
        $categories = ItemType::model()->findAll($criteria);

        foreach($categories as $n => $category) {
            $category_r = array(
                'label'=>$category->title,
                'url'=>'#',
                'level'=>$category->level,
            );              
            $this->category_tree[$n] = $category_r;

            $children = $category->children()->findAll();
            if($children)
                $this->category_tree[$n]['items'] = $this->getChildren($children);
        }
        return $this->category_tree;
    }

    private function getChildren($children) {
        $result = array();
        foreach($children as $i => $child) {
            $category_r = array(
                'label'=>$child->title,
                'url'=>'#',
            );          
            $result[$i] = $category_r;
            $new_children = $child->children()->findAll();
            if($new_children) {
                $result[$i]['items'] = $this->getChildren($new_children);
            }           
        }
        return $result_items = $result;
    }
    
    public function actionLoadRange()
    {
        $type_id=Yii::app()->request->getPost('type_id');   
        $filePath = Yii::app()->runtimePath.'/formulaRangeList_'.$type_id;

        if (!file_exists($filePath))
            $this->createFileForReange($type_id);

        $dataToJS = unserialize(file_get_contents($filePath));
        $data=array(
            'dataToJs'=>$this->convertToJS($dataToJS),
            'html'=>$this->renderPartial('_rangeList', array('data'=>$dataToJS), true, false),
            'filePath'=>$filePath,
            );
            
        echo json_encode($data);
        Yii::app()->end();         
        
    }

    /**
     * Makes a copy of a range file for the model copying purpose
     * @param $old_type_id
     * @param $new_type_id
     */
    public function copyRange($old_type_id,$new_type_id)
    {
        $result=true;
        $oldRangeFile = Yii::app()->runtimePath.'/formulaRangeList_'.$old_type_id;
        $newRangeFile = Yii::app()->runtimePath.'/formulaRangeList_'.$new_type_id;

        if(!copy($oldRangeFile, $newRangeFile))
        {
            Yii::log("Range file {$old_type_id} could not be copied for the new model {$new_type_id}",'error');
            $result=false;
        }

        return $result;
    }
    
    public function createFileForReange($type_id)
    {
        $_POST['RangeForm'][0]['title']='СГ';
        $_POST['RangeForm'][0]['min']='3';
        $_POST['RangeForm'][0]['minr']='85';
        $_POST['RangeForm'][0]['maxr']='';
        $_POST['RangeForm'][0]['max']='';
        
        $_POST['RangeForm'][1]['title']='СТ';
        $_POST['RangeForm'][1]['min']='-51';
        $_POST['RangeForm'][1]['minr']='85';
        $_POST['RangeForm'][1]['maxr']='';
        $_POST['RangeForm'][1]['max']='50';        
        
        $_POST['RangeForm'][2]['title']='СБ';
        $_POST['RangeForm'][2]['min']='5';
        $_POST['RangeForm'][2]['minr']='85';
        $_POST['RangeForm'][2]['maxr']='';
        $_POST['RangeForm'][2]['max']='';          
        
        $_POST['RangeForm'][3]['title']='ОП';
        $_POST['RangeForm'][3]['min']='';
        $_POST['RangeForm'][3]['minr']='85';
        $_POST['RangeForm'][3]['maxr']='';
        $_POST['RangeForm'][3]['max']='';                  
        
        $_POST['RangeForm'][4]['title']='ШГ';
        $_POST['RangeForm'][4]['min']='';
        $_POST['RangeForm'][4]['minr']='85';
        $_POST['RangeForm'][4]['maxr']='';
        $_POST['RangeForm'][4]['max']='';
        
        $_POST['RangeForm'][5]['title']='РП';
        $_POST['RangeForm'][5]['min']='';
        $_POST['RangeForm'][5]['minr']='85';
        $_POST['RangeForm'][5]['maxr']='';
        $_POST['RangeForm'][5]['max']='';                   
        
        $filePath = Yii::app()->runtimePath.'/formulaRangeList_'.$type_id;
        file_put_contents($filePath, serialize($_POST['RangeForm']));
    }

        public function convertToJS($data)
        {
            $dataToJs=array();
            foreach($data as $item)
            {
                $name='{'.$item['title'].'_min}';
                $dataToJs[$name]=$item['min'];
                $name='{'.$item['title'].'_minr}';
                $dataToJs[$name]=$item['minr'];
                $name='{'.$item['title'].'_maxr}';
                $dataToJs[$name]=$item['maxr'];                
                $name='{'.$item['title'].'_max}';
                $dataToJs[$name]=$item['max'];                                
            }
            return $dataToJs;            
        }
        
    public function actionLoadRangeForUpdate()
    {
        $type_id=Yii::app()->request->getPost('type_id');   
        $key=Yii::app()->request->getPost('key');     
        $filePath = Yii::app()->runtimePath.'/formulaRangeList_'.$type_id;
        $data = unserialize(file_get_contents($filePath));
        
        $model=new RangeForm('update');
        $model->key=$key;
        $model->type_id=$type_id;
        $model->title=$data[$key]['title'];
        $model->min=$data[$key]['min'];
        $model->minr=$data[$key]['minr'];
        $model->maxr=$data[$key]['maxr'];
        $model->max=$data[$key]['max'];

        $data=array(
            'status'=>'edit',
            'key'=>$model->key,
            'html'=>$this->renderPartial('_rangeListEditMode', array('model'=>$model), true, false),
            );    

        echo json_encode($data);
        Yii::app()->end();
    }
        
    public function actionUpdateRange()
    {
        $rangeForm=Yii::app()->request->getPost('RangeForm');
        $filePath = Yii::app()->runtimePath.'/formulaRangeList_'.$rangeForm['type_id'];
        $data = unserialize(file_get_contents($filePath));
        
        //TODO: rangeForm validation
        $model=new RangeForm('update');
        $model->attributes=$rangeForm;
        $data[$rangeForm['key']]=$rangeForm;
        
        if (file_put_contents($filePath, serialize($data)))
            $status='success';
        else
        {
            $error = CActiveForm::validate($model);
            if($error!='[]')
            {
                $data=array(
                        'error'=>json_decode($error),
                        'status'=>'error',
                    );
                echo json_encode($data);
            }            
        }
        $dataToJS = unserialize(file_get_contents($filePath));
        $data=array(
            'status'=>$status,
            'key'=>$model->key,
            'dataToJs'=>$this->convertToJS($dataToJS),
            'html'=>$this->renderPartial('_rangeList', array('model'=>$model), true, false),
            );
            
        echo json_encode($data);
        Yii::app()->end();                     
    }            
    
    public function actionGetListOfModels()
    {
        $arrayOfModels = array();
        $criteria=new CDbCriteria;
        $criteria->order='root, lft';
        $models = ItemType::model()->visible()->findAll($criteria);
        
        if(empty($models)) {
            echo CHtml::tag('option',
               array('value'=>0),CHtml::encode(Yii::t('item', 'Нет моделей')),true);
            Yii::app()->end();  
        }    
            
        echo CHtml::tag('option',
               array('value'=>0),CHtml::encode(Yii::t('item', 'Выберите модель')),true);
                   
        foreach($models as $model)
        {
            echo CHtml::tag('option',
                       array('value'=>$model->id),CHtml::encode($model->translations[Yii::app()->language]->title),true);
        }
        
        Yii::app()->end();
    }

    /**
     * Makes a copy of all formulas from and old itemType for a new itemType
     * for copying purpose
     * @param $oldType_id
     * @param $newType_id
     */
    public function copyFormulasForAnItemType($oldType_id,$newType_id)
    {
        $models=Formula::model()->unlocked()->noParent()->findAll(array(
            'condition'=>'type_id=:type_id',
            'params'=>array(':type_id'=>$oldType_id)
            )
        );

        $result=(count($models)==0) ? false : true;
        foreach($models as $model)
        {
            $newModel = new Formula;
            $newModel->attributes=$model->attributes;
            $newModel->type=$model->type;
            $newModel->type_id=$newType_id;
            $result=$newModel->save(false) & $result;

            //if model is a parent, create child models for it
            if($model->type==4)
            {
                foreach($model->children as $child)
                {
                    $newChildModel = new Formula;
                    $newChildModel->attributes=$child->attributes;
                    $newChildModel->type=$child->type;
                    $newChildModel->type_id=$newType_id;
                    $newChildModel->parent=$newModel->id;
                    $result=$newChildModel->save(false) & $result;
                    if(!$result)
                        Yii::log("Error occurred on copying child formula when saving for and old model id:{$oldType_id}");
                }
            }

            if(!$result)
                Yii::log("Error occurred on copying formula when saving for and old model id:{$oldType_id}");
        }
        return $result;
    }

    public function actionCopyModel()
    {
        $isRoot=false;
        $oldModel=$this->loadModel();

        if($oldModel===null)
            throw new CHttpException(404);

        $newModel=new ItemType('copy');

        //save typeSizeList
        $newModel->typeSizeList=$oldModel->typeSizeList;
        //save translation
        $newModel->copyTranslations = $oldModel->translations;

        //if an oldModel is a root
        if($oldModel->isRoot())
        {
            $result=$newModel->saveNode();
            $isRoot=true;
        }
        else
        {
            $node=$oldModel->getParent();
            $result=$newModel->appendTo($node);
        }

        if($result)
        {
            //copy range
            $rangeStatus=$this->copyRange($oldModel->id,$newModel->id);
            //copy formulas
            $formulasStatus=$this->copyFormulasForAnItemType($oldModel->id,$newModel->id);
        }

        $result=($rangeStatus && $formulasStatus) ? true : false;

        $rangeStatus=($rangeStatus) ? 'Успешно' : 'Ошибка';
        $formulasStatus=($formulasStatus) ? 'Успешно' : 'Ошибка';

        if($isRoot)
            $message='Тип скопирован.<br />Статус копирования диапазонов: ' . $rangeStatus .
                '<br />Статус копирования формул: ' .$formulasStatus;
        else
            $message='Тип ' . $oldModel->translations['ru']->title .
                'скопирован и добавлен как подкатегория к ' . ucfirst($node->title).
                '<br />Статус копирования диапазонов: ' . $rangeStatus .
                '<br />Статус копирования формул: ' .$formulasStatus;

        $message_box=$this->renderPartial('/layouts/messages/_message_success', array('message'=>$message), true, false);

        $data=array(
            'result'=>$result,
            'message'=>$message_box,
        );

        echo json_encode($data);
        Yii::app()->end();
    }
}