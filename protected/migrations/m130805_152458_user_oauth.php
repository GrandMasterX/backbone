<?php

class m130805_152458_user_oauth extends CDbMigration
{
	public function up()
	{
            $this->getDbConnection()->createCommand( 'CREATE TABLE IF NOT EXISTS `user_oauth` (
                `user_id` int(11) NOT NULL,
                `provider` varchar(45) NOT NULL,
                `identifier` varchar(64) NOT NULL,
                `profile_cache` text,
                `session_data` text,
                PRIMARY KEY (`provider`,`identifier`),
                UNIQUE KEY `unic_user_id_name` (`user_id`,`provider`),
                KEY `oauth_user_id` (`user_id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
            )->execute();
	}

	public function down()
	{
		echo "m130805_152458_user_oauth does not support migration down.\n";
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