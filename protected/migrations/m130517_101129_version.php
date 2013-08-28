<?php

class m130517_101129_version extends CDbMigration
{
	public function up()
	{
        $this->addColumn('log', 'browser_v', 'varchar(50)');
	}

	public function down()
	{
		echo "m130517_101129_version does not support migration down.\n";
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