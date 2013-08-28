<?php
/**
 * Default controller file.
 *
 * @author Turanszky Sandor <o.turansky@gmail.com>
 * @link http://www.tursystem.com.ua/
 * @copyright Copyright &copy; 2012-2013 TurSystem Software Development
 * @license http://www.tursystem.com.ua/license/
 */

class DefaultController extends Controller
{

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error',$error);
		}
	}


    /**
     * Sets the current language according to selection.
     * @param _lang contains language identifier.
     */    
    public function actionChangeLanguage()
    {
        if(!is_null(Yii::app()->request->getQuery('language'))) 
        {
            Yii::app()->user->setState('language',Yii::app()->request->getQuery('language'));
            Yii::app()->user->setState('currentLanguageTitle', Yii::app()->request->getQuery('currentLanguageTitle'));
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }
    
}