<?php

/**
 * This is the model class for table "item" and library Exel.
*/

class Excel extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Item the static model class
     */
    const EXCEL_DIR = 'uploads/excel/';
    
    public $image;
    public $FileName;
    public $path_with_id;
    public $article;
    public $title;
    // ... other attributes
 
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
            return 'excel_table';
    }

    public function behaviors()
    {
        return array(
            'zii.behaviors.CTimestampBehavior',
        );
    }
    
    public function rules()
    {
        return array(
           //array('id, article, K, DI, DBSH, SHs, SHUG, SHUGr, SHUT,SHUTr,SHUB,SHR,Dr,VP,SHUP,notice,razmer,tkan,Kpoyas,bretels,chashka,KG,KT,KB,SHg,Shleif,constr_notice', 'on'=>'insert,update'),
        );
    }
    
    public function Excelsave() {
        if (Yii::app() instanceof CWebApplication)
        {
            //handle single file upload
            $this->image = CUploadedFile::getInstance($this, 'excel');
            if(!is_null($this->image))
            {
                $this->FileName = mktime() . $this->image->name;
            }
        }
        if(!is_null($this->image)){
            $this->path_with_id = self::EXCEL_DIR . DIRECTORY_SEPARATOR . $this->id;
            Html::createDir($this->path_with_id);
            $filename=$this->path_with_id . DIRECTORY_SEPARATOR . $this->FileName;
            $this->image->saveAs($filename);
        }
        include_once ('PHPExcel/IOFactory.php');

        $objPHPExcel = PHPExcel_IOFactory::load($this->path_with_id . DIRECTORY_SEPARATOR . $this->FileName);
        $objPHPExcel->setActiveSheetIndex(0);
        $aSheet = $objPHPExcel->getActiveSheet();
        $row = 2;
        $notFound = array();
        $Found = array();
        while($aSheet->getCell('A'.$row)->getCalculatedValue()!='stop'):
            $Item = Item::model()->findByAttributes(array('code'=>$aSheet->getCell('A'.$row)->getCalculatedValue()));
            if($Item)
                $ItemSize = ItemSize::model()->findByAttributes(array('item_id'=>$Item->id));
            if(!$Item) {
                $notFound[] = $aSheet->getCell('A'.$row)->getCalculatedValue();
                $Item = new Item;
                $ItemSize = new ItemSize;
                $comment = '';
                $comment .= $aSheet->getCell('Z'.$row)->getCalculatedValue();
                $comment .= $aSheet->getCell('AA'.$row)->getCalculatedValue();
                $Item->stretch = $aSheet->getCell('B'.$row)->getCalculatedValue();
                $Item->bretel = ($aSheet->getCell('P'.$row)->getCalculatedValue()=='нет') ? 0: 1;
                $Item->fabric_iwa_stretch = $aSheet->getCell('R'.$row)->getCalculatedValue();
                $Item->fabric_iww_stretch = $aSheet->getCell('S'.$row)->getCalculatedValue();
                $Item->fabric_iwt_stretch = $aSheet->getCell('T'.$row)->getCalculatedValue();      
                $Item->stretchp = $aSheet->getCell('X'.$row)->getCalculatedValue();
                $Item->material = $aSheet->getCell('O'.$row)->getCalculatedValue();
                $Item->comment = $comment;
                $ItemSize->il = $aSheet->getCell('C'.$row)->getCalculatedValue();
                $ItemSize->iwss = $aSheet->getCell('D'.$row)->getCalculatedValue();
                $ItemSize->bw = $aSheet->getCell('E'.$row)->getCalculatedValue();
                $ItemSize->iwa = $aSheet->getCell('F'.$row)->getCalculatedValue();
                $ItemSize->iww = $aSheet->getCell('H'.$row)->getCalculatedValue();
                $ItemSize->iwt = $aSheet->getCell('J'.$row)->getCalculatedValue();
                $ItemSize->iwt = $aSheet->getCell('J'.$row)->getCalculatedValue();
                $ItemSize->iws = $aSheet->getCell('K'.$row)->getCalculatedValue();
                $ItemSize->ils = $aSheet->getCell('L'.$row)->getCalculatedValue();
                $ItemSize->iwt = $aSheet->getCell('J'.$row)->getCalculatedValue();
                $ItemSize->sup = $aSheet->getCell('N'.$row)->getCalculatedValue();
                $ItemSize->iwp = $aSheet->getCell('U'.$row)->getCalculatedValue();
                $ItemSize->iltwo = $aSheet->getCell('V'.$row)->getCalculatedValue();
                $ItemSize->iwsstwo = $aSheet->getCell('W'.$row)->getCalculatedValue();
                $ItemSize->iwar = $aSheet->getCell('G'.$row)->getCalculatedValue();
                $ItemSize->iwwr = $aSheet->getCell('I'.$row)->getCalculatedValue();
                $ItemSize->iwcb = $aSheet->getCell('M'.$row)->getCalculatedValue();
                $ItemSize->birka = $aSheet->getCell('Y'.$row)->getCalculatedValue();
                $ItemSize->cup = $aSheet->getCell('Q'.$row)->getCalculatedValue();
                $Item->save(false);
                $ItemSize->save(false);
            } else {
                $Found[] = $aSheet->getCell('A'.$row)->getCalculatedValue();
                $comment = '';
                $comment .= $aSheet->getCell('Z'.$row)->getCalculatedValue();
                $comment .= $aSheet->getCell('AA'.$row)->getCalculatedValue();
                $Item->stretch = $aSheet->getCell('B'.$row)->getCalculatedValue();
                $Item->bretel = ($aSheet->getCell('P'.$row)->getCalculatedValue()=='нет') ? 0: 1;
                $Item->fabric_iwa_stretch = $aSheet->getCell('R'.$row)->getCalculatedValue();
                $Item->fabric_iww_stretch = $aSheet->getCell('S'.$row)->getCalculatedValue();
                $Item->fabric_iwt_stretch = $aSheet->getCell('T'.$row)->getCalculatedValue();      
                $Item->stretchp = $aSheet->getCell('X'.$row)->getCalculatedValue();
                $Item->material = $aSheet->getCell('O'.$row)->getCalculatedValue();
                $Item->comment = $comment;
                $ItemSize->il = $aSheet->getCell('C'.$row)->getCalculatedValue();
                $ItemSize->iwss = $aSheet->getCell('D'.$row)->getCalculatedValue();
                $ItemSize->bw = $aSheet->getCell('E'.$row)->getCalculatedValue();
                $ItemSize->iwa = $aSheet->getCell('F'.$row)->getCalculatedValue();
                $ItemSize->iww = $aSheet->getCell('H'.$row)->getCalculatedValue();
                $ItemSize->iwt = $aSheet->getCell('J'.$row)->getCalculatedValue();
                $ItemSize->iwt = $aSheet->getCell('J'.$row)->getCalculatedValue();
                $ItemSize->iws = $aSheet->getCell('K'.$row)->getCalculatedValue();
                $ItemSize->ils = $aSheet->getCell('L'.$row)->getCalculatedValue();
                $ItemSize->iwt = $aSheet->getCell('J'.$row)->getCalculatedValue();
                $ItemSize->sup = $aSheet->getCell('N'.$row)->getCalculatedValue();
                $ItemSize->iwp = $aSheet->getCell('U'.$row)->getCalculatedValue();
                $ItemSize->iltwo = $aSheet->getCell('V'.$row)->getCalculatedValue();
                $ItemSize->iwsstwo = $aSheet->getCell('W'.$row)->getCalculatedValue();
                $ItemSize->iwar = $aSheet->getCell('G'.$row)->getCalculatedValue();
                $ItemSize->iwwr = $aSheet->getCell('I'.$row)->getCalculatedValue();
                $ItemSize->iwcb = $aSheet->getCell('M'.$row)->getCalculatedValue();
                $ItemSize->birka = $aSheet->getCell('Y'.$row)->getCalculatedValue();
                $ItemSize->cup = $aSheet->getCell('Q'.$row)->getCalculatedValue();
                $Item->save();
                $ItemSize->save(false);
            }
            $row++;
        endwhile;
        //echo 'Новые изделия : <br>'.var_dump($notFound).'<br>'.'Обновленные старые изделия: <br>'.var_dump($Found).'<br>';
    }
}