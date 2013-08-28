<?php

class m130708_235909_user_table_change extends CDbMigration
{
	public function up()
	{
            $this->addColumn('user', 'mailing', 'tinyint(1) DEFAULT 1');
	}

	public function down()
	{
		echo "m130708_235909_user_table_change does not support migration down.\n";
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