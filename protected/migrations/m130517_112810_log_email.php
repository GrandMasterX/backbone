<?php

class m130517_112810_log_email extends CDbMigration
{
	public function up()
	{
        $this->addColumn('log', 'email', 'varchar(200)');
	}

	public function down()
	{
		echo "m130517_112810_log_email does not support migration down.\n";
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