<?php

class m130517_085649_log_brpwser extends CDbMigration
{
	public function up()
	{
        $this->addColumn('log', 'browser', 'varchar(200)');
	}

	public function down()
	{
		echo "m130517_085649_log_brpwser does not support migration down.\n";
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