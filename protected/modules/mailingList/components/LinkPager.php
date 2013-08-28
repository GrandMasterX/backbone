<?php
  class LinkPager extends CLinkPager
  {
    const CSS_HIDDEN_PAGE='disabled';
    const CSS_SELECTED_PAGE='active';

    public function init()
    {
        $this->cssFile=Yii::app()->baseUrl.'/static/admin/pager/pager.css';
        parent::init();
    }
  }
?>
