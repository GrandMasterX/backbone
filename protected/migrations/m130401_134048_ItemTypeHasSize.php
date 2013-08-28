<?php

class m130401_134048_ItemTypeHasSize extends CDbMigration
{
	public function up()
	{
        
         $this->getDbConnection()->createCommand(
            'CREATE TABLE `itemType_size` (
              `itemType_id` int(10) unsigned NOT NULL,
              `size_id` int(10) unsigned NOT NULL,
              PRIMARY KEY (`itemType_id`,`size_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;'
        )->execute();         
        
	}

	public function down()
	{
		echo "m130401_134048_ItemTypeHasSize does not support migration down.\n";
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