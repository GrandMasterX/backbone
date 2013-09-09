<?php

class m130904_115751_join_us extends CDbMigration
{
	public function up()
	{
        $this->getDbConnection()->createCommand(
            'CREATE TABLE IF NOT EXISTS `join_us` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(100) DEFAULT NULL,
              `company` varchar(100) DEFAULT NULL,
              `url` varchar(100) DEFAULT NULL,
              `phone` varchar(100) DEFAULT NULL,
              `comments` text DEFAULT NULL,
              PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
        )->execute();
	}

	public function down()
	{
		echo "m130904_115751_join_us does not support migration down.\n";
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