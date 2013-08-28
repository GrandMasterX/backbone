<?php

class m130118_200118_add_last_login_time_for_user_table extends CDbMigration
{
	public function up()
	{
        $this->addColumn('user', 'lastLoginTime', 'datetime NOT NULL');
	}

	public function down()
	{
		echo "m130118_200118_add_last_login_time_for_user_table does not support migration down.\n";
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