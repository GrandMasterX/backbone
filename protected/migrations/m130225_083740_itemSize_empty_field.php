<?php

class m130225_083740_itemSize_empty_field extends CDbMigration
{
	public function up()
	{
        $this->addColumn('itemsize', 'empty', ' tinyint(1) DEFAULT 0 COMMENT \'Пустой размер (1=true) - подлежит удалению при периодической проверке\'');
	}

	public function down()
	{
		echo "m130225_083740_itemSize_empty_field does not support migration down.\n";
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