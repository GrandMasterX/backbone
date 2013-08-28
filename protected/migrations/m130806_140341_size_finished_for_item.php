<?php

class m130806_140341_size_finished_for_item extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item','size_finished','tinyint(1) DEFAULT \'0\'');
	}

	public function down()
	{
		echo "m130806_140341_size_finished_for_item does not support migration down.\n";
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