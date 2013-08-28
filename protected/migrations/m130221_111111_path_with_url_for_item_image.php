<?php

class m130221_111111_path_with_url_for_item_image extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item_image_import', 'path_with_url', 'text');
        $this->addColumn('item_image_import', 'name', 'varchar(255)');
	}

	public function down()
	{
		echo "m130221_111111_path_with_url_for_item_image does not support migration down.\n";
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