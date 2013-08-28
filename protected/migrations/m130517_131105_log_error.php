<?php

class m130517_131105_log_error extends CDbMigration
{
	public function up()
	{
        $this->addColumn('log', 'error', 'varchar(250)');
	}

	public function down()
	{
		echo "m130517_131105_log_error does not support migration down.\n";
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