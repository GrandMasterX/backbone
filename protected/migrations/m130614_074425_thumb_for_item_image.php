<?php

class m130614_074425_thumb_for_item_image extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item_image', 'thumbnail', 'varchar(255) DEFAULT NULL');
	}

	public function down()
	{
		echo "m130614_074425_thumb_for_item_image does not support migration down.\n";
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