<?php

class m130220_135428_item_import_images extends CDbMigration
{
	public function up()
	{
        $this->getDbConnection()->createCommand(
            'CREATE TABLE `item_image_import` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `item_id` int(10) unsigned NOT NULL,
              `path` text NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;'
        )->execute();         
	}

	public function down()
	{
		echo "m130220_135428_item_import_images does not support migration down.\n";
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