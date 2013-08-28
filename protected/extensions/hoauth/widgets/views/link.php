<?php
/**
 * @var HOAuthWidget $this
 * @var string $provider name of provider
 */
$urls = '';
$urls .= (!empty($_GET['type_id'])) ? '&type_id='.$_GET['type_id'] : '';
$urls .= (!empty($_GET['item_id'])) ? '&item_id='.$_GET['item_id'] : '';
$urls .= (!empty($_GET['code'])) ? '&code='.$_GET['code'] : '';
$invitation = Yii::app()->user->isGuest ? HOAuthAction::t('Sign in with') : HOAuthAction::t('Connect with');
?>
<a href="<?php echo Yii::app()->createUrl($this->route . '/oauth', array('provider' => $provider)).$urls; ?>" class="zocial icon <?php  echo strtolower($provider) ?>"><?php  echo "$invitation $provider"; ?></a>