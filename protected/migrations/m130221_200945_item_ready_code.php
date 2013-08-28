<?php

class m130221_200945_item_ready_code extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item', 'code', ' varchar(20) DEFAULT NULL COMMENT \'Код изделия\'');
        $this->addColumn('item', 'ready', ' tinyint(1) DEFAULT NULL COMMENT \'Изделие обработано\'');
	}

	public function down()
	{
		echo "m130221_200945_item_ready_code does not support migration down.\n";
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