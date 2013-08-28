<?php
Yii::import('zii.widgets.grid.CGridView');

class TreeGridView extends GridView
{
     /**
     * Renders the data items for the grid view.
     */
    public function renderItems()
    {
        if($this->dataProvider->getItemCount()>0 || $this->showTableOnEmpty)
        {
            echo "<table id=\"myTreeTable\" class=\"{$this->itemsCssClass}\">\n";
            $this->renderTableHeader();
            ob_start();
            $this->renderTableBody();
            $body=ob_get_clean();
            $this->renderTableFooter();
            echo $body; // TFOOT must appear before TBODY according to the standard.
            echo "</table>";
        }
        else
            $this->renderEmptyText();
    }
    
    /**
     * Renders a table body row.
     * @param integer $row the row number (zero-based).
     */
    public function renderTableRow($row)
    {
        $childClass = 'parent-elem-no-child';
        $data=$this->dataProvider->data[$row];
        $descendants=$data->children()->findAll();
        $count=count($descendants);
        
        if($count>0) 
            $childClass = 'parent-elem ic-col';
        
        if ($data->level > 1){
            if($count>0)
                $childClass="child-elem-with-children child-of-node-{$data->parent->id} ic-col";
            else
                $childClass="child-elem child-of-node-{$data->parent->id}";
        }
        
        if ($data->level==3){
            $levelClass="third-level "; 
            $childClass="child-elem-third-level child-of-node-{$data->parent->id}";
            $childClass=$levelClass . $childClass; 
        }        
        
        if($this->rowCssClassExpression!==null)
        {
            echo '<tr id="node-'.$data->id.'" class="'.$childClass.' '.$this->evaluateExpression($this->rowCssClassExpression,array('row'=>$row,'data'=>$data)).'">';
        }
        else if(is_array($this->rowCssClass) && ($n=count($this->rowCssClass))>0)
            echo '<tr id="node-'.$data->id.'" class="'.$childClass.' '.$this->rowCssClass[$row%$n].'">';
        else
            echo '<tr id="node-'.$data->id.'" class="'.$childClass.'">';
        foreach($this->columns as $column)
            $column->renderDataCell($row);
        echo "</tr>\n";
    }

    public function registerClientScript()
    {
        parent::registerClientScript();
        $cs=Yii::app()->getClientScript();
        $cs->registerScript(__FILE__,"
            $('tr').live('click', function() {
                if($(this).hasClass('parent-elem')) {
                    var children=$('.child-of-'+$(this).attr('id'));
                    $.each(children, function(key, child) {
                        if($(this).hasClass('ic-col')) {
                            $('.child-of-'+child.id).slideToggle();
                        }
                        $('#'+child.id).slideToggle();
                    }).promise()
                      .done($(this).toggleClass('ic-col'));
                 }

                if($(this).hasClass('child-elem-with-children')) {
                    var th=$(this);
                    $('.child-of-'+$(this).attr('id')).slideToggle(function(){
                        th.toggleClass('ic-col');
                    });
                }
            });
        ", CClientScript::POS_READY
        );
    }
}