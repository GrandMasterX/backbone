<?php

class m130107_125922_table_for_type extends CDbMigration
{
	public function up()
	{
            $this->getDbConnection()->createCommand(
                'CREATE TABLE IF NOT EXISTS `obj_type` (
                  `id` int(11) NOT NULL auto_increment,
                  `title` varchar(64) NOT NULL,
                  `lang` char(2) NOT NULL,
                  `is_blocked` tinyint(1) unsigned NOT NULL DEFAULT "0",
                  `created_by_id` int(10) unsigned NOT NULL,
                  `updated_by_id` int(10) unsigned DEFAULT NULL,
                  `is_locked` tinyint(1) unsigned NOT NULL DEFAULT "0",
                  PRIMARY KEY  (`id`),
                  KEY `category_key` (`title`,`lang`)
                ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;'
            )->execute();
	}

	public function down()
	{
		echo "m130107_125922_table_for_type does not support migration down.\n";
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