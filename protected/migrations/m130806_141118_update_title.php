<?php

class m130806_141118_update_title extends CDbMigration
{
	public function up()
	{
        $this->update('item_fabric',array('title'=>'Комбинированная'),'id=:id',array(':id'=>4));
	}

	public function down()
	{
		echo "m130806_141118_update_title does not support migration down.\n";
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