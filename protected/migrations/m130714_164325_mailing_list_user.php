<?php

class m130714_164325_mailing_list_user extends CDbMigration
{
	public function up()
	{
            $this->getDbConnection()->createCommand(
            'CREATE TABLE IF NOT EXISTS `mailing_list_user` (
              `id` int(11) unsigned NOT NULL auto_increment,
              `user_id` int(11) unsigned NOT NULL,
              `mailing_list_id` int(11) unsigned NOT NULL,
              PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;'
        )->execute();         
	}

	public function down()
	{
		echo "m130714_164325_mailing_list_user does not support migration down.\n";
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