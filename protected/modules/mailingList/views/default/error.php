<?php
$this->pageTitle=Yii::t('error', 'Ошибка {n}', $code);
?>

<h1><?php echo CHtml::encode($this->pageTitle); ?></h1>

<div class="flash-error">
<?php
if($message==='')
{
	switch($code)
	{
		case 403:
			$message=Yii::t('error', 'Доступ запрещен.');
			break;
		case 404:
			$message=Yii::t('error', 'Страница не найдена.');
			break;
		default:
			$message=Yii::t('error', 'Произошла ошибка на стороне сервера.');
			break;
	}
}

echo CHtml::encode($message);
?>
</div>