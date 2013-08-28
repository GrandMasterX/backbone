<?php

class m130712_123401_mailing_list extends CDbMigration
{
	public function up()
	{
        $this->getDbConnection()->createCommand(
            'CREATE TABLE IF NOT EXISTS `mailing_list` (
              `id` int(11) unsigned NOT NULL auto_increment,
              `title` varchar(64) NOT NULL,
              `lang` char(2) NOT NULL,
              `is_blocked` tinyint(1) unsigned NOT NULL DEFAULT "0",
              `is_locked` tinyint(1) unsigned NOT NULL DEFAULT "0",
              `status` tinyint(1) unsigned NOT NULL DEFAULT "0",
              `created_by_id` int(10) unsigned NOT NULL,
              `updated_by_id` int(10) unsigned DEFAULT NULL,
              `template` varchar(150) DEFAULT NULL,
              `weight` smallint(6) unsigned DEFAULT NULL,
              PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;'
        )->execute();
        
        $this->getDbConnection()->createCommand(
            'CREATE TABLE IF NOT EXISTS `mailing_list_user` (
              `mailing_list_id` int(11) unsigned NOT NULL,
              `user_id` int(11) unsigned NOT NULL,
              PRIMARY KEY  (`mailing_list_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
        )->execute();                  
	}

	public function down()
	{
		echo "m130712_123401_mailing_list does not support migration down.\n";
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