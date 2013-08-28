<?php

class m130425_090926_user_language extends CDbMigration
{
	public function up()
	{
        $this->addColumn('user', 'language', 'varchar(3) DEFAULT \'en\'');
	}

	public function down()
	{
		echo "m130425_090926_user_language does not support migration down.\n";
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