<?php

class m130423_200244_userTitle extends CDbMigration
{
	public function up()
	{
        $this->addColumn('resformulatitle_translation', 'user_title', 'varchar(255)');
	}

	public function down()
	{
		echo "m130423_200244_userTitle does not support migration down.\n";
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