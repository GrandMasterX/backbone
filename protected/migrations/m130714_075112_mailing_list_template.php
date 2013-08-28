<?php

class m130714_075112_mailing_list_template extends CDbMigration
{
	public function up()
	{
            $this->getDbConnection()->createCommand(
            'CREATE TABLE IF NOT EXISTS `mailing_list_template` (
              `id` int(11) NOT NULL auto_increment,
              `title` varchar(255) NOT NULL,
              `view_file` varchar(200) NOT NULL,
              `is_blocked` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
              `is_locked` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
              PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;'
        )->execute();         
        
	}

	public function down()
	{
		echo "m130714_075112_mailing_list_template does not support migration down.\n";
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