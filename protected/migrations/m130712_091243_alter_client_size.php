<?php

class m130712_091243_alter_client_size extends CDbMigration
{
	public function up()
	{
            $this->addColumn('client_size', 'is_locked', 'tinyint(1) unsigned NOT NULL DEFAULT \'0\'');
            $this->addColumn('client_size', 'create_time', 'datetime NOT NULL');
            $this->addColumn('client_size', 'update_time', 'datetime NULL');
	}

	public function down()
	{
		echo "m130712_091243_alter_client_size does not support migration down.\n";
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