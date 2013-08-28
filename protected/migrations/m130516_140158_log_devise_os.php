<?php

class m130516_140158_log_devise_os extends CDbMigration
{
	public function up()
	{
        $this->addColumn('log', 'device', 'varchar(100)');
        $this->addColumn('log', 'os', 'varchar(255)');
	}

	public function down()
	{
		echo "m130516_140158_log_devise_os does not support migration down.\n";
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