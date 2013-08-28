<?php

class m130809_064743_sub_for_item_fabric_table extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item_fabric','sub','tinyint(1) DEFAULT \'0\'');
        $this->update('item_fabric',array('sub'=>'1'),'id=:id',array(':id'=>4));
	}

	public function down()
	{
		echo "m130809_064743_sub_for_item_fabric_table does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}