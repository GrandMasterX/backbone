<?php
class FormulaController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly + delete, createFormula, createResultFormula, AutoUpdate, LoadRangeForUpdate, UpdateRange, UpdateWeight, GetListOfParentFormulasByTypeId, BindFormulaToExistingParent, BindToParentActionOverFormula, MoveChainToModel',
        );
    }	
    
    public function actionIndex()
	{
			$model=new Formula();

            $this->render('index',array(
				'model'=>$model,
			));
	}
    
    public function actionCreateFormula() {
        $parent_id=Yii::app()->request->getPost('parent_id');
        $model=new Formula('formulaNormal');
        $model->title=Yii::t('formula', 'Новая формула');
        $model->type_id=Yii::app()->request->getPost('type_id');

        if(!is_null($parent_id))
            $model->parent=$parent_id;

        $model->save();
        $model->tag="{formula-$model->id}";
        $model->weight=$model->id;
        $model->save('tag,weight');
        
        $item_id=Yii::app()->request->getPost('item_id');
        $item=Item::model()->findByPk($item_id);   
        
        $html=$this->renderPartial('_formula',array('models'=>array($model), 'sizeList'=>($item) ? $item->sizeList : null), true, false);
        echo json_encode($html);
        Yii::app()->end();
    }
    
    /**
    * 1 calculation formula (normal)
    * 2 resulting formula (range type)
    * 3 resulting formula (graph type)
    * 4 parent holder element
    */
    public function actionCreateResultFormula() {
        $parent_id=Yii::app()->request->getPost('parent_id');
        $model=new Formula('formulaResult');
        $model->type_id=Yii::app()->request->getPost('type_id');
        
        if(!is_null($parent_id))
            $model->parent=$parent_id;        
        
        $formulaType=Yii::app()->request->getPost('type');
        $ch_array=(is_null(Yii::app()->request->getPost('ch_array'))) ? array() : Yii::app()->request->getPost('ch_array');

        switch ($formulaType) {
            case 'range_f':
                $model->type=2;
                break;
            case 'graph_f':
                $model->type=3;
                break;
            case 'parent':
                $model->type=4;
                break;
        }

        $model->save();
        $model->title=Yii::t('formula', 'Новая цепочка-'.$model->id);
        $model->weight=$model->id;
        $model->save('weight');
        
        if($model->type==4)
            $this->bindFormulaToParent($ch_array, $model->id);
            
        $item_id=Yii::app()->request->getPost('item_id');
        $item=Item::model()->findByPk($item_id);   
        
        $html=$this->renderPartial('_formula',array('models'=>array($model), 'sizeList'=>($item) ? $item->sizeList : null), true, false);
        $data=array(
            'html'=>$html,
            'type'=>$model->type,
            'ch_array'=>$ch_array,
        );
        echo json_encode($data);
        Yii::app()->end();
    }
    
    public function bindFormulaToParent($ch_array, $parent_id)
    {
        foreach($ch_array as $id)
        {
            $model=Formula::model()->findByPk($id);
            $model->parent=$parent_id;
            $model->save('parent');
        }
    }
    
    public function unbindFormulaFromParent($ch_array, $parent_id)
    {
        foreach($ch_array as $id)
        {
            $model=Formula::model()->findByPk($id);
            $model->parent=null;
            $model->save('parent');
        }
    }    
    
    public function actionBindToParentActionOverFormula() {
        $parent_id=Yii::app()->request->getPost('parent_id');
        $ch_array=Yii::app()->request->getPost('ch_array');    
        $type_id=Yii::app()->request->getPost('type_id');
        $item_id=Yii::app()->request->getPost('item_id');
        $action=Yii::app()->request->getPost('action');
        
        if ($action=='attach')
            $this->bindFormulaToParent($ch_array, $parent_id);
            
        if ($action=='detach')
            $this->unbindFormulaFromParent($ch_array, $parent_id);            
        
        $html=null;
        $models=Formula::model()->unlocked()->noParent()->findAll(array(
            'condition'=>'type_id=:type_id', 'params'=>array(':type_id'=>$type_id)));
            
        $item=Item::model()->findByPk($item_id);            
        
        $html=$this->renderPartial('/formula/_formula',array('models'=>$models, 'sizeList'=>($item) ? $item->sizeList : null), true, false);
        
        echo json_encode($html);  
        
        Yii::app()->end();
    }
    
    public function actionDelete() {
        $model=$this->loadModel();
        if($model->delete())
            $data=array('status'=>'success','id'=>$model->id);    
        else
            $data=array('status'=>'error');
        
        echo json_encode($data);
        Yii::app()->end();
    }
    
    /**
    * Updates formula models attribtes in auto mode on blur event
    * @param mixed $size_id
    */
    public function actionAutoUpdate()
    {
        $formulaPost=Yii::app()->request->getPost('Formula');
        if(!is_null($formulaPost))
        {
            $model=Formula::model()->findByPk($formulaPost['id']);
            $model->attributes=$formulaPost;

            if($model->validate() && $model->save()){
                $data=array(
                    'status'=>'success',
                    'rangeTitle'=>($model->type==2) ? $model->getRangeTitle($model->title) : null,
                );
                echo json_encode($data); 
            }
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
            Yii::app()->end();   
        }            
    }
    
    /**
    * Updates weight for formula models
    * @param array of model ids
    */
    public function actionUpdateWeight()
    {
        $dataArray=Yii::app()->request->getPost('idArray');
        
        if(!is_null($dataArray))
        {
            foreach($dataArray as $i=>$id) 
            {
                $model=Formula::model()->findByPk($id);
                $model->weight=$i;
                
                if($model->validate() && $model->save('weight')){
                    $data=array(
                        'status'=>'success',
                    );
                }
                else
                {
                    $error = CActiveForm::validate($model);
                    if($error!='[]')
                    {
                        $data=array(
                                'error'=>json_decode($error),
                                'status'=>'error',
                            );
                    }                
                } 
            }
            echo json_encode($data);
            Yii::app()->end();   
        }            
    }

    public function actionGetListOfParentFormulasByTypeId()
    {
        $type_id=Yii::app()->request->getQuery('type_id');
        //$lang=Yii::app()->language;

        $data = Yii::app()->db->createCommand()
            ->select(
                'formula.id as id, 
                 formula.title as title
            ')
            ->from(Formula::tableName())
            ->where('formula.type_id=:type_id AND formula.type=4', array(':type_id'=>$type_id))
            ->order('formula.title ASC')
            ->queryAll();        

            echo "<li><a class='copy-model' href='#'>".Yii::t('formula', 'Скопировать модель')."</a></li>";
            echo "<li class='divider'></li>";
            echo "<li><a class='parent range_f res-f-a use' href='#'>".Yii::t('formula', 'Создать новую цепочку')."</a></li>";
            echo "<li class='divider'></li>";
            echo "<li><a class='detach check-detach inactive' href='#'>".Yii::t('formula', 'Открепить от цепочки')."</a></li>";
            echo "<li class='divider'></li>";            
            echo "<li><a class='parent copy-parent check-copy inactive' href='#' data-toggle='modal' data-target='#copy-to-model'>".Yii::t('formula', 'Скопировать цепочку в модель')."</a></li>";
            echo "<li class='divider'></li>";                        
            
            echo "<li class='nav-header'>".Yii::t('item', 'Присоединить выбранные формулы к:')."</li>";
        
        foreach($data as $item)
        {
            echo "<li><a id='{$item['id']}' class='parent attach attach-link' href='javascript:void(0)'>{$item['title']}</a></li>";
        }
        
        Yii::app()->end();
    }
    
    public function actionMoveChainToModel()
    {
        $type_id=Yii::app()->request->getPost('type_id');
        $chains=Yii::app()->request->getPost('chains');
        
        foreach($chains as $id)
        {
            $model=Formula::model()->findByPk($id);
            
            if($model===null)
                throw new CHttpException(404);            
            
            //create a copy of a current parent formula (chain)
            $newModel=new Formula('formulaNormal');
            $newModel->title=$model->title . Yii::t('formula', ": Копия цепочки с id: {$model->id}");
            $newModel->type_id=$type_id;
            $newModel->type=4;
            $newModel->save(false);
            $newModel->weight=$newModel->id;
            $newModel->save(false);
            
            $report=Yii::t('formula', 'Скопирована цепочка: "title" и вложенных формул - children', array('title'=>$model->title, 'children'=>count($model->children)));
            
            foreach($model->children as $i=>$child)
            {
                $newChildModel=new Formula('formulaNormal');
                $newChildModel->title=$child->title . Yii::t('formula', ": Копия формулы с id: {$child->id}");
                $newChildModel->type_id=$type_id;
                $newChildModel->value=$child->value;
                $newChildModel->parent=$newModel->id;
                $newChildModel->save();

                $newChildModel->tag=$child->tag . Yii::t('formula', "_Copy-of-id_{$child->id}");
                $newChildModel->weight=$newChildModel->id;
                $newChildModel->save('tag,weight');                
            }
        }
        
        echo CJavaScript::jsonEncode($report);
        
        Yii::app()->end();
    }       
                
}