<?php

class m130220_145148_item_image_import extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item_image_import', 'main', 'tinyint(1) DEFAULT NULL');
	}

	public function down()
	{
		echo "m130220_145148_item_image_import does not support migration down.\n";
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