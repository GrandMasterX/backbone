<?php

class m130106_205430_add_category_table extends CDbMigration
{
	public function up()
	{
        $this->getDbConnection()->createCommand(
            'CREATE TABLE IF NOT EXISTS `obj_category` (
              `id` int(11) NOT NULL auto_increment,
              `title` varchar(64) NOT NULL,
              `lang` char(2) NOT NULL,
              PRIMARY KEY  (`id`),
              KEY `category_key` (`title`,`lang`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;'
        )->execute();        
	}

	public function down()
	{
		echo "m130106_205430_add_category_table does not support migration down.\n";
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