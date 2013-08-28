<?php

class m130109_104747_add_object_table extends CDbMigration
{
	public function up()
	{
        
        $this->getDbConnection()->createCommand(
            'CREATE TABLE IF NOT EXISTS `object` (
              `id` int(11) NOT NULL auto_increment,
              `obj_category_id` int(10) unsigned NOT NULL,
              `obj_type_id` int(10) unsigned DEFAULT NULL,
              `title` varchar(64) NOT NULL,
              `title_ru` varchar(64) NOT NULL,
              `title_en` varchar(64) NOT NULL,
              `address_ru` varchar(255) NOT NULL,
              `address_en` varchar(255) NOT NULL,
              `place_ru` varchar(255) NOT NULL,
              `place_en` varchar(255) NOT NULL,
              `information_ru` text DEFAULT NULL,
              `information_en` text DEFAULT NULL,              
              `phone` varchar(20) NOT NULL,
              `price` int(10) unsigned NOT NULL,
              `star` tinyint(1) unsigned DEFAULT NULL,
              `latitude` varchar(100) NOT NULL,
              `longitude` varchar(100) NOT NULL,
              `photo` varchar(255) DEFAULT NULL,
              `is_blocked` tinyint(1) unsigned NOT NULL DEFAULT "0",
              `is_locked` tinyint(1) unsigned NOT NULL DEFAULT "0",
              `created_by_id` int(10) unsigned NOT NULL,
              `updated_by_id` int(10) unsigned DEFAULT NULL,
              PRIMARY KEY  (`id`),
              KEY `object` (`title`,`title_ru`,`title_en`,`price`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;'
        )->execute();         
        
	}

	public function down()
	{
		echo "m130109_104747_add_object_table does not support migration down.\n";
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