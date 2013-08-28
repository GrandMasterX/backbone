<?php

class m130227_083721_itemSizeTranslation extends CDbMigration
{
	public function up()
	{
         $this->getDbConnection()->createCommand(
            'CREATE TABLE `clientsize_translation` (
              `id` int(10) unsigned NOT NULL,
              `language_id` char(10) NOT NULL,
              `title` varchar(255) NOT NULL,
              `short_title` varchar(10) DEFAULT NULL,
              PRIMARY KEY (`id`,`language_id`),
              CONSTRAINT `clientSize_translation_fk1` FOREIGN KEY (`id`) REFERENCES `clientsize` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
        )->execute();        
	}

	public function down()
	{
		echo "m130227_083721_itemSizeTranslation does not support migration down.\n";
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