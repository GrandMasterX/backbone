<?php

class m130806_121037_item_size_birka extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item','comment','text DEFAULT NULL');
	}

	public function down()
	{
		echo "m130806_121037_item_size_birka does not support migration down.\n";
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